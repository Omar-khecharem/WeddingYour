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
Router::get('/logout', [AuthController::class, 'logout'])->name('logout');
Router::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('forgot.form');
Router::post('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
Router::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('reset.form');
Router::post('/reset-password', [AuthController::class, 'reset'])->name('reset');

// ---- Products ----
Router::get('/products', [ProductController::class, 'index'])->name('products');
Router::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Router::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Router::get('/search', [ProductController::class, 'search'])->name('search');
Router::get('/api/product', [ProductController::class, 'getProduct'])->name('api.product');
Router::get('/api/check-pincode', [ProductController::class, 'checkPincode'])->name('api.pincode');
Router::post('/product/{slug}/review', [ProductController::class, 'submitReview'])->name('product.review');

// ---- Cart ----
Router::get('/cart', [CartController::class, 'index'])->name('cart');
Router::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Router::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Router::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Router::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Router::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Router::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

// ---- Checkout (login required) ----
Router::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware([AuthMiddleware::class]);
Router::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place')->middleware([AuthMiddleware::class]);
Router::get('/order/confirmation/{order_number}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// ---- Account (protected) ----
Router::group('/account', ['middleware' => [AuthMiddleware::class]], function () {
    Router::get('', [AccountController::class, 'index'])->name('account');
    Router::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Router::post('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Router::get('/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password');
    Router::post('/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');
    Router::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Router::get('/orders/{id}', [AccountController::class, 'orderDetail'])->name('account.order');
    Router::post('/orders/cancel', [AccountController::class, 'cancelOrder'])->name('account.order.cancel');
    Router::get('/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');

    Router::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Router::post('/addresses', [AccountController::class, 'saveAddress'])->name('account.addresses.save');
    Router::post('/addresses/delete', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');
    Router::post('/addresses/default', [AccountController::class, 'setDefaultAddress'])->name('account.addresses.default');
    Router::get('/orders/{id}/invoice', [AccountController::class, 'downloadInvoice'])->name('account.order.invoice');
});

// ---- Wishlist AJAX (guest-accessible, controller handles auth) ----
Router::get('/wishlist/ids', [AccountController::class, 'wishlistIds'])->name('account.wishlist.ids');
Router::post('/wishlist/add', [AccountController::class, 'addWishlist'])->name('account.wishlist.add');

// ---- Compare ----
Router::get('/compare', [CompareController::class, 'index'])->name('compare');
Router::post('/compare/toggle', [CompareController::class, 'toggle'])->name('compare.toggle');
Router::get('/compare/count', [CompareController::class, 'count'])->name('compare.count');
Router::get('/compare/ids', [CompareController::class, 'ids'])->name('compare.ids');
Router::match(['GET', 'POST'], '/compare/clear', function () {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $userId = \App\Helpers\Session::get('user.id');
    $sessionId = session_id();
    if ($userId) {
        $pdo->prepare("DELETE FROM sg_compare WHERE user_id = :u")->execute([':u' => $userId]);
    } else {
        $pdo->prepare("DELETE FROM sg_compare WHERE session_id = :s")->execute([':s' => $sessionId]);
    }
    \App\Helpers\Session::flash('success', 'Compare list cleared.');
    header('Location: ' . url('compare'));
    exit;
})->name('compare.clear');
Router::get('/compare/remove/{slug}', function ($params) {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT id FROM sg_products WHERE slug = :slug LIMIT 1");
    $stmt->execute([':slug' => $params['slug']]);
    $product = $stmt->fetch();
    if ($product) {
        $userId = \App\Helpers\Session::get('user.id');
        $sessionId = session_id();
        if ($userId) {
            $pdo->prepare("DELETE FROM sg_compare WHERE user_id = :u AND product_id = :p")->execute([':u' => $userId, ':p' => $product['id']]);
        } else {
            $pdo->prepare("DELETE FROM sg_compare WHERE session_id = :s AND product_id = :p")->execute([':s' => $sessionId, ':p' => $product['id']]);
        }
    }
    \App\Helpers\Session::flash('success', 'Product removed from compare.');
    header('Location: ' . url('compare'));
    exit;
})->name('compare.remove');

// ---- Static pages ----
Router::get('/about', function () {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sg_pages WHERE slug = :s AND status = 1 LIMIT 1");
    $stmt->execute([':s' => 'about']);
    $page = $stmt->fetch();
    if ($page) {
        return \App\Core\View::render('pages.page', ['page' => $page]);
    }
    return \App\Core\View::render('pages.about');
})->name('about');

Router::match(['GET', 'POST'], '/contact', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        if ($name && $email && $message) {
            $pdo = \App\Core\Database::getInstance()->getConnection();
            $stmt = $pdo->prepare("INSERT INTO sg_contact_messages (name, email, message) VALUES (:n, :e, :m)");
            $stmt->execute([':n' => $name, ':e' => $email, ':m' => $message]);
            \App\Helpers\Session::flash('success', 'Message sent successfully! We will get back to you soon.');
        } else {
            \App\Helpers\Session::flash('error', 'Please fill in all required fields.');
        }
        header('Location: ' . url('contact'));
        exit;
    }

    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sg_pages WHERE slug = :s AND status = 1 LIMIT 1");
    $stmt->execute([':s' => 'contact']);
    $page = $stmt->fetch();
    if ($page) {
        return \App\Core\View::render('pages.page', ['page' => $page]);
    }
    return \App\Core\View::render('pages.contact');
})->name('contact');

Router::get('/outlets', function () {
    $outlets = \App\Models\Outlet::getActive();
    return \App\Core\View::render('pages.outlets', ['outlets' => $outlets]);
})->name('outlets');

Router::get('/outlets/{slug}', function (array $params) {
    $slug = $params['slug'] ?? '';
    $outlet = \App\Models\Outlet::findBySlug($slug);
    if (!$outlet) {
        http_response_code(404);
        return \App\Core\View::render('errors.404');
    }
    return \App\Core\View::render('pages.outlet', ['outlet' => $outlet]);
})->name('outlet');

Router::get('/gallery', function () {
    $galleryItems = \App\Models\GalleryItem::getActive(null, 30);
    return \App\Core\View::render('pages.gallery', ['galleryItems' => $galleryItems]);
})->name('gallery');

Router::get('/blog', function () {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $categoryName = $_GET['category'] ?? '';
    $where = 'b.is_published = 1';
    $params = [];
    if ($categoryName) {
        $where .= ' AND bc.name = :cat';
        $params[':cat'] = $categoryName;
    }
    $stmt = $pdo->prepare("SELECT b.*, bc.name AS category_name, bc.slug AS category_slug FROM sg_blogs b LEFT JOIN sg_blog_categories bc ON bc.id = b.category_id WHERE $where ORDER BY b.published_at DESC");
    $stmt->execute($params);
    $posts = $stmt->fetchAll();
    return \App\Core\View::render('pages.blog', ['posts' => $posts]);
})->name('blog');

Router::get('/blog/{slug}', function ($params) {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT b.*, bc.name AS category_name, bc.slug AS category_slug FROM sg_blogs b LEFT JOIN sg_blog_categories bc ON bc.id = b.category_id WHERE b.slug = :slug AND b.is_published = 1 LIMIT 1");
    $stmt->execute([':slug' => $params['slug']]);
    $post = $stmt->fetch();
    if (!$post) {
        http_response_code(404);
        return \App\Core\View::render('errors.404');
    }
    return \App\Core\View::render('pages.blog-detail', ['post' => $post]);
})->name('blog.detail');

Router::get('/categories', function () {
    $categories = \App\Models\Category::getActiveWithProductCount();
    return \App\Core\View::render('pages.categories', ['categories' => $categories]);
})->name('categories');

Router::get('/category/{slug}', function ($params) {
    $controller = new \App\Controllers\ProductController();
    $_GET['category'] = $params['slug'];
    $request = new \App\Core\Request($params);
    $response = new \App\Core\Response();
    return $controller->index($request, $response);
})->name('category');

Router::get('/privacy-policy', function () {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sg_pages WHERE slug = :s AND status = 1 LIMIT 1");
    $stmt->execute([':s' => 'privacy-policy']);
    $page = $stmt->fetch();
    if ($page) {
        return \App\Core\View::render('pages.page', ['page' => $page]);
    }
    return \App\Core\View::render('pages.privacy-policy');
})->name('privacy-policy');

Router::get('/terms-of-use', function () {
    $pdo = \App\Core\Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM sg_pages WHERE slug = :s AND status = 1 LIMIT 1");
    $stmt->execute([':s' => 'terms-of-use']);
    $page = $stmt->fetch();
    if ($page) {
        return \App\Core\View::render('pages.page', ['page' => $page]);
    }
    return \App\Core\View::render('pages.terms-of-use');
})->name('terms-of-use');

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

    return \App\Core\View::render('pages.page', ['page' => $page]);
})->name('page');

// ---- Order tracking ----
Router::get('/order/track', function () {
    return \App\Core\View::render('pages.track-order');
})->name('track.order');

Router::post('/order/track', function () {
    $orderNumber = $_POST['order_number'] ?? '';
    if ($orderNumber) {
        $order = \App\Models\Order::findByNumber($orderNumber);
        if ($order) {
            return \App\Core\View::render('pages.track-order', ['tracked_order' => $order]);
        }
    }
    return \App\Core\View::render('pages.track-order', ['error' => 'Order not found.']);
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
        $stmt = $pdo->prepare("INSERT IGNORE INTO sg_newsletter (email) VALUES (:email)");
        $stmt->execute([':email' => $email]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Thank you for subscribing!']);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
    }
    exit;
})->name('newsletter.subscribe');
