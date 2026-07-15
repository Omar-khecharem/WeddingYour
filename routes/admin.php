<?php

use App\Core\Router;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProductController as AdminProductController;
use App\Controllers\Admin\SettingController;
use App\Controllers\Admin\CategoryController;
use App\Controllers\Admin\BannerController;
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\OutletController;
use App\Controllers\Admin\DealController;
use App\Controllers\Admin\CategoryCardController;
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
    Router::post('/products/delete-image', [AdminProductController::class, 'deleteImage'])->name('admin.products.delete-image');

    // Categories
    Router::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Router::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Router::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Router::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Router::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Router::post('/categories/delete', [CategoryController::class, 'destroy'])->name('admin.categories.delete');

    // Orders
    Router::get('/orders', function () {
        $c = new DashboardController();
        $orderService = new \App\Services\OrderService();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $status = $_GET['status'] ?? null;
        $orders = $orderService->getAllOrders($page, 20, $status);
        return $c->view('admin.orders.index', ['orders' => $orders]);
    })->name('admin.orders');

    Router::get('/orders/{id}', function ($params) {
        $c = new DashboardController();
        $orderService = new \App\Services\OrderService();
        $order = $orderService->getOrder((int)$params['id']);
        if (!$order) { http_response_code(404); exit; }
        return $c->view('admin.orders.show', ['order' => $order]);
    })->name('admin.orders.show');

    Router::post('/orders/status', function () {
        $orderService = new \App\Services\OrderService();
        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $tracking = $_POST['tracking_number'] ?? null;
        $orderService->updateStatus($orderId, $status, $tracking);
        \App\Helpers\Session::flash('success', 'Order status updated.');
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('admin/orders')));
        exit;
    })->name('admin.orders.status');

    // Users
    Router::get('/users', function () {
        $c = new DashboardController();
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $users = $pdo->query("SELECT * FROM sg_users ORDER BY created_at DESC")->fetchAll();
        return $c->view('admin.users.index', ['users' => $users]);
    })->name('admin.users');

    // Reviews
    Router::get('/reviews', function () {
        $c = new DashboardController();
        $reviews = \App\Models\Review::getPending();
        return $c->view('admin.reviews.index', ['reviews' => $reviews]);
    })->name('admin.reviews');

    Router::post('/reviews/approve', function () {
        \App\Models\Review::approve((int)($_POST['id'] ?? 0));
        \App\Helpers\Session::flash('success', 'Review approved.');
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('admin/reviews')));
        exit;
    })->name('admin.reviews.approve');

    // Settings
    Router::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Router::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Banners
    Router::get('/banners', [BannerController::class, 'index'])->name('admin.banners');
    Router::get('/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Router::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Router::get('/banners/edit/{id}', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Router::post('/banners/update/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Router::post('/banners/delete', [BannerController::class, 'destroy'])->name('admin.banners.delete');

    // Gallery
    Router::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Router::get('/gallery/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
    Router::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Router::get('/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
    Router::post('/gallery/update/{id}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Router::post('/gallery/delete', [GalleryController::class, 'destroy'])->name('admin.gallery.delete');

    // Outlets
    Router::get('/outlets', [OutletController::class, 'index'])->name('admin.outlets');
    Router::get('/outlets/create', [OutletController::class, 'create'])->name('admin.outlets.create');
    Router::post('/outlets', [OutletController::class, 'store'])->name('admin.outlets.store');
    Router::get('/outlets/edit/{id}', [OutletController::class, 'edit'])->name('admin.outlets.edit');
    Router::post('/outlets/update/{id}', [OutletController::class, 'update'])->name('admin.outlets.update');
    Router::post('/outlets/delete', [OutletController::class, 'destroy'])->name('admin.outlets.delete');

    // Deals
    Router::get('/deals', [DealController::class, 'index'])->name('admin.deals');
    Router::post('/deals', [DealController::class, 'store'])->name('admin.deals.store');
    Router::post('/deals/delete', [DealController::class, 'destroy'])->name('admin.deals.delete');

    // Category Cards
    Router::get('/category-cards', [CategoryCardController::class, 'index'])->name('admin.category-cards');
    Router::get('/category-cards/create', [CategoryCardController::class, 'create'])->name('admin.category-cards.create');
    Router::post('/category-cards', [CategoryCardController::class, 'store'])->name('admin.category-cards.store');
    Router::get('/category-cards/edit/{id}', [CategoryCardController::class, 'edit'])->name('admin.category-cards.edit');
    Router::post('/category-cards/update/{id}', [CategoryCardController::class, 'update'])->name('admin.category-cards.update');
    Router::post('/category-cards/delete', [CategoryCardController::class, 'destroy'])->name('admin.category-cards.delete');
});
