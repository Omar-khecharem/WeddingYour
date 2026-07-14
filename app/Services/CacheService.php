<?php
/**
 * Cache Service
 * 
 * File-based caching system with TTL support for storing
 * rendered views, query results, and computed data to
 * improve application performance.
 *
 * @package App\Services
 */

namespace App\Services;

class CacheService
{
    private string $cacheDir;
    private int $defaultTtl;

    public function __construct()
    {
        $this->cacheDir = DATA_CACHE_DIR;
        $this->defaultTtl = CACHE_LIFETIME;

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Get a cached value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return $default;
        }

        $data = unserialize(file_get_contents($file));

        if ($data === false || !isset($data['expires']) || !isset($data['value'])) {
            return $default;
        }

        if (time() > $data['expires']) {
            unlink($file);
            return $default;
        }

        return $data['value'];
    }

    /**
     * Store a value in cache
     */
    public function set(string $key, mixed $value, ?int $ttl = null): bool
    {
        $file = $this->getFilePath($key);
        $ttl = $ttl ?? $this->defaultTtl;

        $data = [
            'expires' => time() + $ttl,
            'value' => $value,
            'created_at' => time(),
        ];

        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return file_put_contents($file, serialize($data), LOCK_EX) !== false;
    }

    /**
     * Check if cache key exists and is valid
     */
    public function has(string $key): bool
    {
        return $this->get($key, '__MISS__') !== '__MISS__';
    }

    /**
     * Delete a cached value
     */
    public function forget(string $key): bool
    {
        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }

    /**
     * Clear all cached data
     */
    public function clear(): bool
    {
        $files = glob($this->cacheDir . DS . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        return true;
    }

    /**
     * Remember a value (fetch from cache or store fresh result)
     */
    public function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        $cached = $this->get($key, '__MISS__');
        if ($cached !== '__MISS__') {
            return $cached;
        }

        $value = $callback();
        $this->set($key, $value, $ttl);
        return $value;
    }

    /**
     * Remember a value forever
     */
    public function rememberForever(string $key, callable $callback): mixed
    {
        return $this->remember($key, $callback, 365 * 24 * 3600); // 1 year
    }

    /**
     * Get remaining TTL for a key in seconds
     */
    public function ttl(string $key): int|false
    {
        $file = $this->getFilePath($key);
        if (!file_exists($file)) return false;

        $data = unserialize(file_get_contents($file));
        if ($data === false || !isset($data['expires'])) return false;

        return max(0, $data['expires'] - time());
    }

    /**
     * Increment a numeric value
     */
    public function increment(string $key, int $step = 1): int
    {
        $value = (int)$this->get($key, 0);
        $value += $step;
        $this->set($key, $value);
        return $value;
    }

    /**
     * Decrement a numeric value
     */
    public function decrement(string $key, int $step = 1): int
    {
        $value = (int)$this->get($key, 0);
        $value -= $step;
        $this->set($key, $value);
        return $value;
    }

    /**
     * Get cache file path for a key
     */
    private function getFilePath(string $key): string
    {
        $hash = md5($key);
        $prefix = substr($hash, 0, 2);
        $dir = $this->cacheDir . DS . $prefix;

        return $dir . DS . $hash . '.cache';
    }

    /**
     * Get cache statistics
     */
    public function stats(): array
    {
        $files = glob($this->cacheDir . DS . '*' . DS . '*.cache');
        $totalSize = 0;
        $count = 0;
        $valid = 0;
        $expired = 0;

        foreach ($files as $file) {
            if (!is_file($file)) continue;
            $count++;
            $totalSize += filesize($file);

            $data = @unserialize(file_get_contents($file));
            if ($data && isset($data['expires'])) {
                if (time() <= $data['expires']) {
                    $valid++;
                } else {
                    $expired++;
                }
            }
        }

        return [
            'total_files' => $count,
            'total_size' => $totalSize,
            'formatted_size' => $this->formatBytes($totalSize),
            'valid' => $valid,
            'expired' => $expired,
        ];
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
