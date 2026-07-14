<?php
/**
 * Application Entry Point
 * 
 * All HTTP requests are routed through this file.
 * Sets up autoloading, configuration, error handling,
 * and dispatches the request to the appropriate route.
 */

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Load autoloader and bootstrap
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'autoload.php';

// Set secure headers
\App\Helpers\Security::setSecureHeaders();

// Load routes
require_once ROUTES_DIR . DS . 'web.php';
require_once ROUTES_DIR . DS . 'api.php';
require_once ROUTES_DIR . DS . 'admin.php';

// Dispatch the current request
\App\Core\Router::dispatch();
