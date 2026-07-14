<?php
/**
 * Response
 * 
 * HTTP response abstraction for sending JSON, HTML, redirects,
 * file downloads, and custom headers with status codes.
 *
 * @package App\Core
 */

namespace App\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private mixed $body = null;

    /**
     * Set HTTP status code
     */
    public function status(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Add a response header
     */
    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Set response body
     */
    public function body(mixed $content): self
    {
        $this->body = $content;
        return $this;
    }

    /**
     * Send JSON response
     */
    public function json(mixed $data, int $statusCode = null): void
    {
        if ($statusCode) {
            $this->statusCode = $statusCode;
        }
        $this->header('Content-Type', 'application/json; charset=utf-8');
        $this->send();
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Send HTML response
     */
    public function html(string $html): void
    {
        $this->header('Content-Type', 'text/html; charset=utf-8');
        $this->send();
        echo $html;
        exit;
    }

    /**
     * Redirect to a URL
     */
    public function redirect(string $url, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }

    /**
     * Redirect back
     */
    public function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? APP_URL;
        $this->redirect($referer);
    }

    /**
     * Send a file download
     */
    public function download(string $filePath, ?string $fileName = null): void
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File not found: {$filePath}");
        }

        $fileName = $fileName ?? basename($filePath);
        $fileSize = filesize($filePath);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-cache');
        readfile($filePath);
        exit;
    }

    /**
     * Send all prepared headers
     */
    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    /**
     * Set no-cache headers
     */
    public function noCache(): self
    {
        $this->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->header('Pragma', 'no-cache');
        $this->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        return $this;
    }

    /**
     * Set CORS headers
     */
    public function cors(): self
    {
        $this->header('Access-Control-Allow-Origin', '*');
        $this->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        $this->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-Token');
        $this->header('Access-Control-Allow-Credentials', 'true');
        $this->header('Access-Control-Max-Age', '86400');
        return $this;
    }

    /**
     * Set content security policy
     */
    public function csp(string $policy): self
    {
        $this->header('Content-Security-Policy', $policy);
        return $this;
    }
}
