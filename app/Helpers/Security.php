<?php
/**
 * Security Helper
 * 
 * Provides input sanitization, XSS prevention, CSRF protection,
 * password hashing, and encryption utilities.
 *
 * @package App\Helpers
 */

namespace App\Helpers;

class Security
{
    /**
     * Sanitize user input
     */
    public static function sanitize(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map([self::class, 'sanitize'], $value);
        }
        if (is_string($value)) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        }
        return $value;
    }

    /**
     * Sanitize for URL
     */
    public static function sanitizeUrl(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize email
     */
    public static function sanitizeEmail(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Validate email
     */
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate URL
     */
    public static function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate integer
     */
    public static function validateInt(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Generate CSRF token field
     */
    public static function csrfField(): string
    {
        $token = Session::csrfToken();
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $token . '">';
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCsrf(string $token): bool
    {
        if (empty($token)) return false;
        return Session::verifyCsrf($token);
    }

    /**
     * Hash password
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ALGO, ['cost' => PASSWORD_COST]);
    }

    /**
     * Verify password
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Check if password needs rehash
     */
    public static function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_ALGO, ['cost' => PASSWORD_COST]);
    }

    /**
     * Generate secure random token
     */
    public static function generateToken(int $length = 64): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Encrypt data (simple AES-256-CBC)
     */
    public static function encrypt(string $data, string $key): string
    {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypt data
     */
    public static function decrypt(string $data, string $key): string|false
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Strip all HTML tags except allowed
     */
    public static function stripTags(string $value, string $allowed = '<p><br><b><strong><i><em><u><a><ul><ol><li><h2><h3><h4><span><div><img>'): string
    {
        return strip_tags($value, $allowed);
    }

    /**
     * Prevent XSS in JSON output
     */
    public static function jsonSafe(array $data): array
    {
        array_walk_recursive($data, function (&$value) {
            if (is_string($value)) {
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
            }
        });
        return $data;
    }

    /**
     * Rate limiting check
     */
    public static function checkRateLimit(string $key, int $maxAttempts = 5, int $period = 300): bool
    {
        $storage = DATA_CACHE_DIR . DS . 'ratelimit_' . md5($key) . '.tmp';
        $data = @file_get_contents($storage) ? unserialize(file_get_contents($storage)) : ['count' => 0, 'reset' => time() + $period];

        if (time() > $data['reset']) {
            $data = ['count' => 0, 'reset' => time() + $period];
        }

        $data['count']++;
        file_put_contents($storage, serialize($data), LOCK_EX);

        return $data['count'] <= $maxAttempts;
    }

    /**
     * Get client IP with proxy support
     */
    public static function getClientIp(): string
    {
        $headers = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Set secure headers
     */
    public static function setSecureHeaders(): void
    {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
}
