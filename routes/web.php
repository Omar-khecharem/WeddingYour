<?php
/**
 * Web Routes
 * 
 * All frontend web routes for the application.
 * Routes are registered using the Router facade.
 *
 * @package Routes
 */

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\AuthController;
use App\Controllers\CheckoutController;
use App\Controllers\AccountController;
use App\Controllers\CompareController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

// Apply CSRF protection globally
Router::middleware(CsrfMiddleware::class);

// ---- Home ----
Router::get('/', [HomeController::class, 'index'])->name('home');

// ---- Auth ----
Router::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Router::post('/login', [AuthController::class, 'login'])->name('login');
Router::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Router::post('/register', [AuthController::class, 'register'])->name('register');
Router::post('/logout', [AuthController::class, 'logout'])->name('logout');
Router::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('forgot.form');
Router::post('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
Router::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('reset.form');
Router::post('/reset-password', [AuthController::class, 'reset'])->name('reset');

// ---- Products ----
Router::get('/products', [ProductController::class, 'index'])->name('products');
Router::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Router::get('/search', [ProductController::class, 'search'])->name('search');
Router::get('/api/product', [ProductController::class, 'getProduct'])->name('api.product');

// ---- Cart ----
Router::get('/cart', [CartController::class, 'index'])->name('cart');
Router::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Router::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Router::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Router::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Router::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Router::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

// ---- Checkout ----
Router::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Router::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
Router::get('/order/confirmation/{order_number}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// ---- Account (protected) ----
Router::group('/account', ['middleware' => [AuthMiddleware::class]], function () {
    Router::get('', [AccountController::class, 'index'])->name('account');
    Router::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Router::post('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Router::get('/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password');
    Router::post('/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');
    Router::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Router::get('/order/{id}', [AccountController::class, 'orderDetail'])->name('account.order');
    Router::post('/order/cancel', [AccountController::class, 'cancelOrder'])->name('account.order.cancel');
    Router::get('/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
    Router::post('/wishlist/add', [AccountController::class, 'addWishlist'])->name('account.wishlist.add');
    Router::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Router::post('/addresses', [AccountController::class, 'saveAddress'])->name('account.addresses.save');
    Router::post('/addresses/delete', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');
    Router::post('/addresses/default', [AccountController::class, 'setDefaultAddress'])->name('account.addresses.default');
    Router::get('/order/{id}/invoice', [AccountController::class, 'downloadInvoice'])->name('account.order.invoice');
});

// ---- Compare ----
Router::get('/compare', [CompareController::class, 'index'])->name('compare');
Router::post('/compare/toggle', [CompareController::class, 'toggle'])->name('compare.toggle');
Router::get('/compare/count', [CompareController::class, 'count'])->name('compare.count');
Router::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

// ---- Static pages ----
Router::get('/about', function () {
    $controller = new \App\Core\Controller();
    return $controller->view('pages.about');
})->name('about');

Router::get('/contact', function () {
    $controller = new \App\Core\Controller();
    return $controller->view('pages.contact');
})->name('contact');

Router::get('/outlets', function () {
    $controller = new \App\Core\Controller();
    return $controller->view('pages.outlets');
})->name('outlets');

Router::get('/blog', function () {
    $controller = new \App\Core\Controller();
    return $controller->view('pages.blog');
})->name('blog');

Router::get('/categories', function () {
    $controller = new \App\Core\Controller();
    $categories = \App\Models\Category::getActiveWithProductCount();
    return $controller->view('pages.categories', ['categories' => $categories]);
})->name('categories');

Router::get('/category/{slug}', function ($params) {
    $controller = new \App\Controllers\ProductController();
    $request = new \App\Core\Request($params);
    $response = new \App\Core\Response();
    $_GET['category'] = $params['slug'];
    return $controller->index($request, $response);
})->name('category');

Router::get('/page/{slug}', function ($params) {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sg_pages WHERE slug = :slug AND status = 1 LIMIT 1");
    $stmt->execute([':slug' => $params['slug']]);
    $page = $stmt->fetch();

    if (!$page) {
        http_response_code(404);
        require VIEWS_DIR . DS . 'errors' . DS . '404.php';
        exit;
    }

    $controller = new \App\Core\Controller();
    return $controller->view('pages.page', ['page' => $page]);
})->name('page');

// ---- Order tracking ----
Router::get('/order/track', function () {
    $controller = new \App\Core\Controller();
    return $controller->view('pages.track-order');
})->name('track.order');

Router::post('/order/track', function () {
    $orderNumber = $_POST['order_number'] ?? '';
    if ($orderNumber) {
        $order = \App\Models\Order::findByNumber($orderNumber);
        if ($order) {
            $controller = new \App\Core\Controller();
            return $controller->view('pages.track-order', ['tracked_order' => $order]);
        }
    }
    $controller = new \App\Core\Controller();
    return $controller->view('pages.track-order', ['error' => 'Order not found.']);
})->name('track.order.post');

// ---- Newsletter ----
Router::post('/newsletter/subscribe', function (\App\Core\Request $request) {
    $email = \App\Helpers\Security::sanitizeEmail($request->input('email', ''));
    if (!\App\Helpers\Security::validateEmail($email)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $pdo = \App\Core\Database::getInstance()->getConnection();
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO sg_newsletter_subscribers (email) VALUES (:email)");
        $stmt->execute([':email' => $email]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
    }
    exit;
})->name('newsletter.subscribe');
