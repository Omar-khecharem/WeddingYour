<?php
/**
 * Environment Loader
 *
 * Loads .env file from the project root and defines constants.
 * Supports: # comments, quoted values, multi-line with \"
 */

class EnvLoader
{
    private static bool $loaded = false;

    public static function load(string $path = null): void
    {
        if (self::$loaded) return;

        $path = $path ?? dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($path)) {
            // Try parent directory (Hostinger: .env is above public_html)
            $parent = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env';
            if (file_exists($parent)) {
                $path = $parent;
            } else {
                return; // No .env file, use defaults
            }
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove surrounding quotes
                if ((str_starts_with($value, '"') && str_ends_with($value, '"'))
                    || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                    $value = substr($value, 1, -1);
                }

                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}

EnvLoader::load();
