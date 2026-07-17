<?php

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'autoload.php';

require_once ROUTES_DIR . DS . 'web.php';
require_once ROUTES_DIR . DS . 'api.php';
require_once ROUTES_DIR . DS . 'admin.php';

\App\Helpers\Security::setSecureHeaders();

\App\Core\Router::dispatch();
