<?php
/**
 * Rate Limit Middleware
 * 
 * Restricts the number of requests a client can make within a time window.
 * Uses IP-based tracking with file-based storage.
 *
 * @package App\Middleware
 */

namespace App\Middleware;

class RateLimitMiddleware
{
    private int $maxRequests;
    private int $windowMinutes;

    public function __construct(int $maxRequests = 60, int $windowMinutes = 1)
    {
        $this->maxRequests = $maxRequests;
        $this->windowMinutes = $windowMinutes;
    }

    /**
     * Handle the middleware check
     */
    public function handle(): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = 'ratelimit_' . md5($ip);
        $storage = DATA_CACHE_DIR . DS . $key . '.tmp';

        $data = ['count' => 0, 'reset' => time() + ($this->windowMinutes * 60)];

        if (file_exists($storage)) {
            $content = @file_get_contents($storage);
            if ($content) {
                $stored = unserialize($content);
                if ($stored && isset($stored['reset']) && $stored['reset'] > time()) {
                    $data = $stored;
                }
            }
        }

        $data['count']++;

        // Write to file with exclusive lock
        $fp = fopen($storage, 'w');
        if ($fp && flock($fp, LOCK_EX)) {
            fwrite($fp, serialize($data));
            flock($fp, LOCK_UN);
            fclose($fp);
        }

        // Set rate limit headers
        header('X-RateLimit-Limit: ' . $this->maxRequests);
        header('X-RateLimit-Remaining: ' . max(0, $this->maxRequests - $data['count']));
        header('X-RateLimit-Reset: ' . $data['reset']);

        if ($data['count'] > $this->maxRequests) {
            http_response_code(429);
            header('Retry-After: ' . ($data['reset'] - time()));

            if (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => 'Too many requests. Please try again later.',
                    'retry_after' => $data['reset'] - time(),
                    'status' => 429
                ]);
            } else {
                echo '<h1>429 Too Many Requests</h1>';
                echo '<p>Please try again after ' . ($data['reset'] - time()) . ' seconds.</p>';
            }
            exit;
        }
    }
}
