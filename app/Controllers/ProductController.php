<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use App\Helpers\Session;

class ProductController extends Controller
{
    public function index(Request $request, Response $response): string
    {
        $filters = [
            'category'    => $request->query('category'),
            'subcategory' => $request->query('subcategory'),
            'brand'       => $request->query('brand'),
            'search'      => $request->query('q'),
            'sort'        => $request->query('sort', 'newest'),
            'min_price'   => $request->query('min_price'),
            'max_price'   => $request->query('max_price'),
            'rating'      => $request->query('rating'),
            'in_stock'    => $request->query('in_stock'),
            'featured'    => $request->query('featured'),
            'on_sale'     => $request->query('on_sale'),
        ];

        $page = $this->getPage();
        $result = Product::getFiltered($filters, $page, PAGINATION_PER_PAGE);
        $filterOptions = Product::getFilterOptions();

        $title = 'All Products';
        $description = 'Discover our complete collection of mukut, topor and wedding accessories.';
        if ($filters['category']) {
            $cat = Category::findBySlug($filters['category']);
            if ($cat) {
                $title = $cat['name'];
                $description = $cat['description'] ?: $description;
                $this->setBreadcrumb([
                    ['label' => 'Home', 'url' => url('/')],
                    ['label' => $cat['name']],
                ]);
            }
        } elseif ($filters['search']) {
            $title = 'Search: ' . e($filters['search']);
        } else {
            $this->setBreadcrumb([
                ['label' => 'Home', 'url' => url('/')],
                ['label' => 'Shop'],
            ]);
        }

        $this->setMeta($title, $description);

        $subcategories = [];
        try {
            $pdo = \App\Core\Database::getInstance()->getConnection();
            $subcategories = $pdo->query("SELECT sc.id, sc.name, sc.slug, sc.image, sc.category_id, c.slug AS cat_slug FROM sg_subcategories sc JOIN sg_categories c ON c.id = sc.category_id WHERE sc.status = 1 ORDER BY c.sort_order, sc.sort_order, sc.name")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {}

        $productIds = array_column($result['products'] ?? [], 'id');
        $ratings = Review::getBatchRatings($productIds);

        return $this->view('products.index', array_merge($result, [
            'filterOptions' => $filterOptions,
            'filters' => $filters,
            'currentCategory' => $filters['category'] ?: '',
            'searchQuery' => $filters['search'] ?: '',
            'productRatings' => $ratings,
            'sortBy' => $filters['sort'],
            'subcategories' => $subcategories,
        ]));
    }

    public function show(Request $request, Response $response): string
    {
        $slug = $request->param('slug');
        $product = Product::findBySlug($slug);

        if (!$product) {
            $this->notFound('Product not found');
        }

        $this->setMeta(
            $product['name'],
            $product['short_description'] ?: '',
            $product['meta_keywords'] ?? ''
        );

        $this->setBreadcrumb([
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'Shop', 'url' => url('products')],
            ['label' => $product['category_name'] ?? '', 'url' => url('products?category=' . ($product['category_slug'] ?? ''))],
            ['label' => $product['name']],
        ]);

        $relatedProducts = Product::getRelated($product['id'], $product['category_id'], 4);
        $reviews = Review::getApprovedForProduct($product['id']);
        $ratingStats = Review::getStats($product['id']);

        if ($this->isAjax()) {
            $this->json(compact('product', 'relatedProducts', 'reviews', 'ratingStats'));
        }

        return $this->view('products.show', compact('product', 'relatedProducts', 'reviews', 'ratingStats'));
    }

    public function search(Request $request, Response $response): void
    {
        $query = $request->query('q', '');
        if (strlen($query) < 2) {
            $this->json(['results' => []]);
            return;
        }
        $products = Product::searchAjax($query, 5);
        $this->json(['results' => $products]);
    }

    public function getProduct(Request $request, Response $response): void
    {
        $id = (int)$request->query('id');
        $product = Product::find($id);
        if (!$product) {
            $this->json(['error' => 'Product not found'], 404);
            return;
        }
        $this->json(['product' => $product->toArray()]);
    }

    public function checkPincode(Request $request, Response $response): void
    {
        $productId = (int)$request->query('product_id');
        $pincode = trim($request->query('pincode', ''));
        if (!$productId || !$pincode) {
            $this->json(['available' => false, 'message' => 'Invalid request.']);
            return;
        }
        $available = Product::checkPincode($productId, $pincode);
        if ($available) {
            $this->json(['available' => true, 'message' => '✓ Available for delivery at ' . e($pincode)]);
        } else {
            $this->json(['available' => false, 'message' => '✗ We do not deliver to ' . e($pincode) . ' yet.']);
        }
    }

    public function submitReview(Request $request, Response $response): void
    {
        $slug = $request->param('slug');
        $product = Product::findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            require VIEWS_DIR . DS . 'errors' . DS . '404.php';
            exit;
        }

        $user = $this->viewData['authUser'];
        $result = Review::submit([
            'product_id' => $product['id'],
            'user_id' => $user['id'] ?? null,
            'name' => $request->input('name', 'Anonymous'),
            'email' => $request->input('email', ''),
            'rating' => (int)$request->input('rating', 5),
            'title' => $request->input('title', ''),
            'comment' => $request->input('comment', ''),
        ]);

        if ($result['success']) {
            Session::flash('success', $result['message']);
        } else {
            Session::flash('error', 'Failed to submit review. Please try again.');
        }

        $this->redirect(url('product/' . e($product['slug'])));
    }
}
