<?php
/**
 * Request
 * 
 * Wraps HTTP request data (GET, POST, JSON body, files, headers)
 * with convenient accessor methods and input filtering.
 *
 * @package App\Core
 */

namespace App\Core;

class Request
{
    private array $params;
    private array $query;
    private array $body;
    private array $files;
    private array $headers;
    private array $server;

    public function __construct(array $routeParams = [])
    {
        $this->params = $routeParams;
        $this->query = $_GET;
        $this->server = $_SERVER;  // must be set before parseBody() — method() reads it
        $this->files = $_FILES;
        $this->body = $this->parseBody();
        $this->headers = $this->parseHeaders();
    }

    /**
     * Parse request body based on Content-Type
     */
    private function parseBody(): array
    {
        $method = $this->method();

        if ($method === 'GET') {
            return [];
        }

        $contentType = $this->header('Content-Type', '');

        if (strpos($contentType, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            return is_array($data) ? $data : [];
        }

        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            if ($method === 'POST') {
                return $_POST;
            }
            parse_str(file_get_contents('php://input'), $data);
            return $data ?: [];
        }

        return [];
    }

    /**
     * Parse HTTP headers
     */
    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $header = ucwords(strtolower($header), '-');
                $headers[$header] = $value;
            }
        }
        // Add content-type and content-length
        if (isset($this->server['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $this->server['CONTENT_TYPE'];
        }
        if (isset($this->server['CONTENT_LENGTH'])) {
            $headers['Content-Length'] = $this->server['CONTENT_LENGTH'];
        }
        return $headers;
    }

    /**
     * Get all input data (merged)
     */
    public function all(): array
    {
        return array_merge($this->query, $this->body, $this->params);
    }

    /**
     * Get a specific input value
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $this->params[$key] ?? $default;
    }

    /**
     * Get query string parameter
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    /**
     * Get route parameter
     */
    public function param(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * Get only specified fields from input
     */
    public function only(array $keys): array
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->input($key);
        }
        return $data;
    }

    /**
     * Get all input except specified fields
     */
    public function except(array $keys): array
    {
        $data = $this->all();
        foreach ($keys as $key) {
            unset($data[$key]);
        }
        return $data;
    }

    /**
     * Check if input has a key
     */
    public function has(string $key): bool
    {
        return isset($this->body[$key]) || isset($this->query[$key]);
    }

    /**
     * Get uploaded file
     */
    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Check if a file was uploaded
     */
    public function hasFile(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Get HTTP method
     */
    public function method(): string
    {
        $method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');

        // Support method spoofing via _method field
        // Use $_POST directly to avoid circular dependency (body not yet initialized)
        if ($method === 'POST' && !empty($_POST['_method'])) {
            return strtoupper($_POST['_method']);
        }
        return $method;
    }

    /**
     * Get request URI
     */
    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    /**
     * Get full URL
     */
    public function fullUrl(): string
    {
        $scheme = $this->isSecure() ? 'https' : 'http';
        $host = $this->server['HTTP_HOST'] ?? 'localhost';
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return "{$scheme}://{$host}{$uri}";
    }

    /**
     * Check if HTTPS
     */
    public function isSecure(): bool
    {
        return (!empty($this->server['HTTPS']) && $this->server['HTTPS'] !== 'off')
            || ($this->server['SERVER_PORT'] ?? 80) == 443;
    }

    /**
     * Get header value
     */
    public function header(string $key, mixed $default = null): mixed
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * Get all headers
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Get client IP
     */
    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Get user agent
     */
    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * Check if request expects JSON
     */
    public function expectsJson(): bool
    {
        $accept = $this->header('Accept', '');
        return strpos($accept, 'application/json') !== false;
    }

    /**
     * Check if request is AJAX
     */
    public function isAjax(): bool
    {
        return strtolower($this->header('X-Requested-With', '')) === 'xmlhttprequest';
    }

    /**
     * Validate request
     */
    public function validate(array $rules): array
    {
        $validator = new \App\Helpers\Validation();
        return $validator->validate($this->all(), $rules);
    }

    /**
     * Get CSRF token from request
     */
    public function csrfToken(): string
    {
        return $this->body['_csrf_token'] ?? $this->header('X-CSRF-Token', '');
    }
}
