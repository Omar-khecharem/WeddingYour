<?php
/**
 * Session Helper
 * 
 * Static helper for managing PHP session data with flash message support.
 *
 * @package App\Helpers
 */

namespace App\Helpers;

class Session
{
    /**
     * Get a session value (supports dot notation for nested arrays)
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $parts = explode('.', $key, 2);
        if (count($parts) === 2) {
            $value = $_SESSION[$parts[0]] ?? null;
            if (is_array($value) && array_key_exists($parts[1], $value)) {
                return $value[$parts[1]];
            }
            return $default;
        }
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set a session value
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Check if session key exists
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a session key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Get and forget (one-time flash message)
     */
    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }

        $value = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * Check if a flash message exists
     */
    public static function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Get all flash messages
     */
    public static function getFlashes(): array
    {
        $flashes = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $flashes;
    }

    /**
     * Add a success flash message
     */
    public static function success(string $message): void
    {
        self::flash('success', $message);
    }

    /**
     * Add an error flash message
     */
    public static function error(string $message): void
    {
        self::flash('error', $message);
    }

    /**
     * Add an info flash message
     */
    public static function info(string $message): void
    {
        self::flash('info', $message);
    }

    /**
     * Add a warning flash message
     */
    public static function warning(string $message): void
    {
        self::flash('warning', $message);
    }

    /**
     * Regenerate session ID (prevents fixation)
     */
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    /**
     * Destroy the session
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Get CSRF token (generate if not exists)
     */
    public static function csrfToken(): string
    {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    /**
     * Regenerate CSRF token
     */
    public static function regenerateCsrf(): string
    {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCsrf(string $token): bool
    {
        return isset($_SESSION[CSRF_TOKEN_NAME])
            && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }
}
