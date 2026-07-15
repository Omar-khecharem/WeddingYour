<?php
/**
 * PSR-4 Autoloader
 * 
 * Handles automatic class loading for the application.
 * Namespace mapping: App\ -> app/
 */

// Load constants first (defines APP_DIR, DS, CONFIG_DIR, etc.)
require_once __DIR__ . DIRECTORY_SEPARATOR . 'constants.php';

spl_autoload_register(function (string $className): void {
    $prefix = 'App\\';
    $baseDir = APP_DIR . DS;

    if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($className, strlen($prefix));
    $file = $baseDir . str_replace('\\', DS, $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

/**
 * Load helper functions
 */
require_once APP_DIR . DS . 'Helpers' . DS . 'functions.php';

/**
 * Load configuration files
 */
require_once CONFIG_DIR . DS . 'app.php';
require_once CONFIG_DIR . DS . 'database.php';

/**
 * Error and exception handler
 */
set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function (Throwable $exception): void {
    $logMessage = '[EXCEPTION] ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine();
    error_log($logMessage);

    if (APP_DEBUG) {
        echo '<pre style="background:#1a1a1a;color:#f8f8f8;padding:20px;margin:20px;border-radius:8px;font-size:14px;overflow:auto;">';
        echo '<h2 style="color:#ff6b6b;margin:0 0 15px 0;">🚨 ' . get_class($exception) . '</h2>';
        echo '<strong style="color:#ffd93d;">Message:</strong> ' . htmlspecialchars($exception->getMessage()) . '<br><br>';
        echo '<strong style="color:#ffd93d;">File:</strong> ' . $exception->getFile() . ':' . $exception->getLine() . '<br><br>';
        echo '<strong style="color:#ffd93d;">Stack Trace:</strong><br>';
        echo '<div style="background:#2d2d2d;padding:15px;border-radius:5px;margin-top:10px;">';
        foreach ($exception->getTrace() as $i => $trace) {
            $file = $trace['file'] ?? '[internal function]';
            $line = $trace['line'] ?? '';
            $class = $trace['class'] ?? '';
            $type = $trace['type'] ?? '';
            $function = $trace['function'] ?? '';
            echo "#{$i} {$file}({$line}): {$class}{$type}{$function}()<br>";
        }
        echo '</div></pre>';
    } else {
        http_response_code(500);
        require VIEWS_DIR . DS . 'errors' . DS . '500.php';
    }
    exit;
});

/**
 * Initialize session
 */
if (session_status() === PHP_SESSION_NONE) {
    $sessPath = ROOT_DIR . DS . 'storage' . DS . 'sessions';
    if (!is_dir($sessPath)) { @mkdir($sessPath, 0755, true); }
    session_save_path($sessPath);
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME * 60);
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME * 60,
        'path' => '/',
        'domain' => '',
        'secure' => APP_ENV === 'production',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Increase PHP limits for large uploads
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '55M');
ini_set('max_execution_time', '300');
ini_set('memory_limit', '256M');

/**
 * Set timezone
 */
date_default_timezone_set(APP_TIMEZONE);

/**
 * Set locale
 */
setlocale(LC_ALL, APP_LOCALE);
