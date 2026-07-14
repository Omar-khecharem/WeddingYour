<?php
/**
 * API Routes
 * 
 * RESTful API endpoints for headless/interactive features.
 * All routes are prefixed with /api/ automatically.
 *
 * @package Routes
 */

use App\Core\Router;

Router::group('/api', [], function () {

    // Products
    Router::get('/products', function (\App\Core\Request $request) {
        $page = (int)($request->query('page', 1));
        $perPage = (int)($request->query('per_page', 12));
        $category = $request->query('category');
        $search = $request->query('search');

        $conditions = ['status' => STATUS_ACTIVE];
        if ($category) {
            $cat = \App\Models\Category::findBySlug($category);
            if ($cat) $conditions['category_id'] = $cat['id'];
        }

        $result = \App\Models\Product::paginate($page, $perPage, $conditions);
        $result['items'] = array_map(function ($p) { return $p->toArray(); }, $result['items']);

        header('Content-Type: application/json');
        echo json_encode($result);
    });

    // Single product
    Router::get('/products/{id}', function (\App\Core\Request $request) {
        $id = (int)$request->param('id');
        $product = \App\Models\Product::find($id);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode($product->toArray());
    });

    // Categories
    Router::get('/categories', function () {
        header('Content-Type: application/json');
        echo json_encode(\App\Models\Category::getActiveWithProductCount());
    });

    // Cart
    Router::get('/cart', function () {
        $cart = new \App\Services\CartService();
        header('Content-Type: application/json');
        echo json_encode($cart->getCart());
    });

    // Orders
    Router::get('/orders/{id}', function (\App\Core\Request $request) {
        $id = (int)$request->param('id');
        $order = new \App\Services\OrderService();
        $result = $order->getOrder($id);
        header('Content-Type: application/json');
        echo json_encode($result ?: ['error' => 'Order not found']);
    });

    // Health check
    Router::get('/health', function () {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'app' => APP_NAME,
            'version' => '1.0.0',
            'time' => date('Y-m-d H:i:s'),
        ]);
    });
});
