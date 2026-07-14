<?php
/**
 * Admin Routes
 * 
 * Protected admin panel routes. All routes require admin authentication.
 *
 * @package Routes
 */

use App\Core\Router;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProductController as AdminProductController;
use App\Middleware\AdminMiddleware;

Router::group('/admin', ['middleware' => [AdminMiddleware::class]], function () {

    // Dashboard
    Router::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
    Router::get('/clear-cache', [DashboardController::class, 'clearCache'])->name('admin.cache');
    Router::get('/logs', [DashboardController::class, 'logs'])->name('admin.logs');

    // Products
    Router::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
    Router::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Router::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Router::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Router::post('/products/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Router::post('/products/delete', [AdminProductController::class, 'destroy'])->name('admin.products.delete');

    // Orders (using existing service)
    Router::get('/orders', function () {
        $controller = new \App\Core\Controller();
        $orderService = new \App\Services\OrderService();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $status = $_GET['status'] ?? null;
        $orders = $orderService->getAllOrders($page, 20, $status);
        return $controller->view('admin.orders.index', ['orders' => $orders]);
    })->name('admin.orders');

    Router::get('/orders/{id}', function ($params) {
        $controller = new \App\Core\Controller();
        $orderService = new \App\Services\OrderService();
        $order = $orderService->getOrder((int)$params['id']);
        if (!$order) {
            http_response_code(404);
            require VIEWS_DIR . DS . 'errors' . DS . '404.php';
            exit;
        }
        return $controller->view('admin.orders.show', ['order' => $order]);
    })->name('admin.orders.show');

    Router::post('/orders/status', function () {
        $orderService = new \App\Services\OrderService();
        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $tracking = $_POST['tracking_number'] ?? null;
        $orderService->updateStatus($orderId, $status, $tracking);
        \App\Helpers\Session::flash('success', 'Order status updated.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    })->name('admin.orders.status');

    // Users
    Router::get('/users', function () {
        $controller = new \App\Core\Controller();
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM sg_users ORDER BY created_at DESC");
        $users = $stmt->fetchAll();
        return $controller->view('admin.users.index', ['users' => $users]);
    })->name('admin.users');

    // Coupons
    Router::get('/coupons', function () {
        $controller = new \App\Core\Controller();
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM sg_coupons ORDER BY created_at DESC");
        $coupons = $stmt->fetchAll();
        return $controller->view('admin.coupons.index', ['coupons' => $coupons]);
    })->name('admin.coupons');

    Router::post('/coupons', function () {
        $couponService = new \App\Services\CouponService();
        $data = [
            'code' => $_POST['code'] ?? '',
            'type' => $_POST['type'] ?? 'percentage',
            'value' => (float)($_POST['value'] ?? 0),
            'min_order_amount' => $_POST['min_order_amount'] ? (float)$_POST['min_order_amount'] : null,
            'max_discount' => $_POST['max_discount'] ? (float)$_POST['max_discount'] : null,
            'usage_limit' => $_POST['usage_limit'] ? (int)$_POST['usage_limit'] : null,
            'is_active' => (int)($_POST['is_active'] ?? 1),
            'starts_at' => $_POST['starts_at'] ?: null,
            'expires_at' => $_POST['expires_at'] ?: null,
            'description' => $_POST['description'] ?? '',
        ];
        $result = $couponService->create($data);
        if ($result['success']) {
            \App\Helpers\Session::flash('success', 'Coupon created successfully.');
        } else {
            \App\Helpers\Session::flash('error', 'Failed to create coupon.');
        }
        header('Location: ' . url('admin/coupons'));
        exit;
    })->name('admin.coupons.create');

    Router::post('/coupons/delete', function () {
        $couponService = new \App\Services\CouponService();
        $couponService->delete((int)($_POST['id'] ?? 0));
        \App\Helpers\Session::flash('success', 'Coupon deleted.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    })->name('admin.coupons.delete');

    // Reviews
    Router::get('/reviews', function () {
        $controller = new \App\Core\Controller();
        $reviews = \App\Models\Review::getPending();
        return $controller->view('admin.reviews.index', ['reviews' => $reviews]);
    })->name('admin.reviews');

    Router::post('/reviews/approve', function () {
        $id = (int)($_POST['id'] ?? 0);
        \App\Models\Review::approve($id);
        \App\Helpers\Session::flash('success', 'Review approved.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    })->name('admin.reviews.approve');

    // Settings
    Router::get('/settings', function () {
        $controller = new \App\Core\Controller();
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT * FROM sg_settings ORDER BY `group`, `key`");
        $settings = $stmt->fetchAll();
        $grouped = [];
        foreach ($settings as $s) {
            $grouped[$s['group']][] = $s;
        }
        return $controller->view('admin.settings.index', ['settingsGrouped' => $grouped]);
    })->name('admin.settings');

    Router::post('/settings', function () {
        $pdo = \App\Core\Database::getInstance()->getConnection();
        foreach ($_POST as $key => $value) {
            if (str_starts_with($key, 'setting_')) {
                $settingKey = substr($key, 8);
                $stmt = $pdo->prepare("UPDATE sg_settings SET `value` = :value WHERE `key` = :key");
                $stmt->execute([':value' => $value, ':key' => $settingKey]);
            }
        }
        \App\Helpers\Session::flash('success', 'Settings updated successfully.');
        header('Location: ' . url('admin/settings'));
        exit;
    })->name('admin.settings.update');
});
