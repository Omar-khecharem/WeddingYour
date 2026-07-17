<?php
/**
 * Router
 * 
 * Core routing engine that parses URLs and dispatches to the appropriate
 * controller method. Supports parameterized routes, named routes,
 * middleware binding, and RESTful conventions.
 *
 * @package App\Core
 */

namespace App\Core;

class Router
{
    /**
     * Registered routes grouped by HTTP method
     */
    public static array $routes = [];

    /**
     * Named route collection
     */
    public static array $namedRoutes = [];

    /**
     * Current matched route info
     */
    private static array $currentRoute = [];

    /**
     * Registered global middleware
     */
    private static array $middleware = [];

    /**
     * Route group attributes (prefix, middleware)
     */
    private static array $groupStack = [];

    /**
     * Register a GET route
     */
    public static function get(string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        return new RouteBuilder(self::addRoute('GET', $path, $handler, $options));
    }

    /**
     * Register a POST route
     */
    public static function post(string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        return new RouteBuilder(self::addRoute('POST', $path, $handler, $options));
    }

    /**
     * Register a PUT route
     */
    public static function put(string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        return new RouteBuilder(self::addRoute('PUT', $path, $handler, $options));
    }

    /**
     * Register a PATCH route
     */
    public static function patch(string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        return new RouteBuilder(self::addRoute('PATCH', $path, $handler, $options));
    }

    /**
     * Register a DELETE route
     */
    public static function delete(string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        return new RouteBuilder(self::addRoute('DELETE', $path, $handler, $options));
    }

    /**
     * Register routes for multiple HTTP methods
     */
    public static function match(array $methods, string $path, array|callable|string $handler, array $options = []): RouteBuilder
    {
        foreach ($methods as $method) {
            self::addRoute(strtoupper($method), $path, $handler, $options);
        }
        return new RouteBuilder(null);
    }

    /**
     * Define a route group with shared prefix and middleware
     */
    public static function group(string $prefix, array $attributes, callable $callback): void
    {
        $previousStack = self::$groupStack;
        self::$groupStack[] = [
            'prefix' => $prefix,
            'middleware' => $attributes['middleware'] ?? [],
            'options' => $attributes
        ];
        $callback();
        self::$groupStack = $previousStack;
    }

    /**
     * Add route to the registry
     */
    private static function addRoute(string $method, string $path, array|callable|string $handler, array $options): ?array
    {
        $prefix = '';
        $middleware = $options['middleware'] ?? [];

        foreach (self::$groupStack as $group) {
            $prefix = $group['prefix'] . $prefix;
            $middleware = array_merge($group['middleware'] ?? [], $middleware);
        }

        $fullPath = $prefix . $path;
        $name = $options['name'] ?? '';

        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $fullPath);
        $pattern = '#^' . $pattern . '$#';

        $route = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler,
            'pattern' => $pattern,
            'middleware' => $middleware,
            'options' => $options
        ];

        self::$routes[$method][] = $route;

        if ($name) {
            self::$namedRoutes[$name] = $route;
        }

        return $route;
    }

    /**
     * Generate a URL for a named route
     */
    public static function route(string $name, array $params = []): string
    {
        if (!isset(self::$namedRoutes[$name])) {
            throw new \RuntimeException("Route '{$name}' not found.");
        }

        $path = self::$namedRoutes[$name]['path'];
        foreach ($params as $key => $value) {
            $path = str_replace("{{$key}}", $value, $path);
        }
        return APP_URL . $path;
    }

    /**
     * Register global middleware
     */
    public static function middleware(string $middlewareClass): void
    {
        self::$middleware[] = $middlewareClass;
    }

    /**
     * Dispatch the current request to the appropriate handler
     */
    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove base path
        $basePath = parse_url(APP_URL, PHP_URL_PATH);
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = rtrim($uri, '/') ?: '/';

        // Handle OPTIONS preflight
        if ($method === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Filter named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                self::$currentRoute = $route;

                // Run global middleware
                foreach (self::$middleware as $mw) {
                    if (class_exists($mw)) {
                        $instance = new $mw();
                        $instance->handle();
                    }
                }

                // Run route-specific middleware
                foreach ($route['middleware'] as $mw) {
                    if (class_exists($mw)) {
                        $instance = new $mw();
                        $instance->handle();
                    }
                }

                self::executeHandler($route['handler'], $params);
                return;
            }
        }

        // 404 handling
        http_response_code(404);
        if (self::isApiRequest()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Route not found', 'status' => 404]);
        } else {
            require VIEWS_DIR . DS . 'errors' . DS . '404.php';
        }
        exit;
    }

    /**
     * Execute a route handler
     */
    private static function executeHandler(array|callable|string $handler, array $params): void
    {
        if ($handler instanceof \Closure) {
            echo $handler($params);
            return;
        }

        if (is_array($handler)) {
            [$controllerClass, $method] = $handler;

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller '{$controllerClass}' not found.");
            }

            $controller = new $controllerClass();
            $request = new Request($params);
            $response = new Response();

            echo $controller->$method($request, $response);
            return;
        }

        if (is_string($handler)) {
            [$controllerClass, $method] = explode('@', $handler);

            $controllerClass = 'App\\Controllers\\' . $controllerClass;

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller '{$controllerClass}' not found.");
            }

            $controller = new $controllerClass();
            $request = new Request($params);
            $response = new Response();

            echo $controller->$method($request, $response);
            return;
        }
    }

    /**
     * Check if the request expects JSON
     */
    public static function isApiRequest(): bool
    {
        return strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') === 0
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }

    /**
     * Get current route name
     */
    public static function currentRouteName(): string
    {
        return self::$currentRoute['options']['name'] ?? '';
    }

    /**
     * Check if the given route name matches the current request
     */
    public static function isActive(string $name): bool
    {
        return self::currentRouteName() === $name;
    }
}

class RouteBuilder
{
    private ?array $route;

    public function __construct(?array $route)
    {
        $this->route = $route;
    }

    public function name(string $name): self
    {
        if ($this->route) {
            $this->route['options']['name'] = $name;
            $key = array_key_last(Router::$routes[$this->route['method']]);
            Router::$routes[$this->route['method']][$key]['options']['name'] = $name;
            Router::$namedRoutes[$name] = &Router::$routes[$this->route['method']][$key];
        }
        return $this;
    }

    public function middleware(string|array $middleware): self
    {
        if ($this->route) {
            $mw = is_array($middleware) ? $middleware : [$middleware];
            $key = array_key_last(Router::$routes[$this->route['method']]);
            Router::$routes[$this->route['method']][$key]['middleware'] = array_merge(
                Router::$routes[$this->route['method']][$key]['middleware'] ?? [], $mw
            );
        }
        return $this;
    }
}
