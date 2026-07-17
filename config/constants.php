<?php
/**
 * Application Constants
 * 
 * Path constants and global definitions used throughout the application.
 */

// Directory separator shorthand
define('DS', DIRECTORY_SEPARATOR);

// Root paths
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . DS . 'app');
define('CONFIG_DIR', ROOT_DIR . DS . 'config');
define('PUBLIC_DIR', ROOT_DIR . DS . 'public');
define('ROUTES_DIR', ROOT_DIR . DS . 'routes');
define('DATABASE_DIR', ROOT_DIR . DS . 'database');
define('LOGS_DIR', ROOT_DIR . DS . 'logs');
define('CACHE_DIR', ROOT_DIR . DS . 'cache');

// App subdirectories
define('CORE_DIR', APP_DIR . DS . 'Core');
define('CONTROLLERS_DIR', APP_DIR . DS . 'Controllers');
define('MODELS_DIR', APP_DIR . DS . 'Models');
define('VIEWS_DIR', APP_DIR . DS . 'Views');
define('COMPONENTS_DIR', APP_DIR . DS . 'Components');
define('HELPERS_DIR', APP_DIR . DS . 'Helpers');
define('SERVICES_DIR', APP_DIR . DS . 'Services');
define('MIDDLEWARE_DIR', APP_DIR . DS . 'Middleware');
define('TRAITS_DIR', APP_DIR . DS . 'Traits');

// Public asset paths
define('ASSETS_URL', 'assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/images');
define('UPLOADS_URL', 'uploads');
define('PRODUCT_IMAGES_URL', UPLOADS_URL . '/products');
define('CATEGORY_IMAGES_URL', UPLOADS_URL . '/categories');
define('REVIEW_IMAGES_URL', UPLOADS_URL . '/reviews');

// Public asset directories
define('ASSETS_DIR', PUBLIC_DIR . DS . 'assets');
define('CSS_DIR', ASSETS_DIR . DS . 'css');
define('JS_DIR', ASSETS_DIR . DS . 'js');
define('IMAGES_DIR', ASSETS_DIR . DS . 'images');
define('UPLOADS_DIR', PUBLIC_DIR . DS . 'uploads');
define('PRODUCT_IMAGES_DIR', UPLOADS_DIR . DS . 'products');
define('CATEGORY_IMAGES_DIR', UPLOADS_DIR . DS . 'categories');
define('REVIEW_IMAGES_DIR', UPLOADS_DIR . DS . 'reviews');

// Cache paths
define('VIEW_CACHE_DIR', CACHE_DIR . DS . 'views');
define('DATA_CACHE_DIR', CACHE_DIR . DS . 'data');

// Error constants
define('ERROR_NOT_FOUND', '404');
define('ERROR_FORBIDDEN', '403');
define('ERROR_SERVER', '500');
define('ERROR_UNAUTHORIZED', '401');

// Status constants
define('STATUS_ACTIVE', 1);
define('STATUS_INACTIVE', 0);
define('STATUS_DRAFT', 2);

// Order statuses
define('ORDER_PENDING', 'pending');
define('ORDER_CONFIRMED', 'confirmed');
define('ORDER_PROCESSING', 'processing');
define('ORDER_SHIPPED', 'shipped');
define('ORDER_DELIVERED', 'delivered');
define('ORDER_CANCELLED', 'cancelled');
define('ORDER_REFUNDED', 'refunded');

// Payment statuses
define('PAYMENT_PENDING', 'pending');
define('PAYMENT_COMPLETED', 'completed');
define('PAYMENT_FAILED', 'failed');
define('PAYMENT_REFUNDED', 'refunded');
