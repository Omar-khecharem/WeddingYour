<?php
/**
 * Base Component
 * 
 * Abstract base class for ALL UI components.
 * Each component is fully independent with its own:
 * - PHP logic (fetchData, render)
 * - HTML template (render)
 * - CSS (css method)
 * - JavaScript (js method)
 * 
 * Components NEVER hardcode data. All text, images, products,
 * categories come from MySQL via fetchData().
 *
 * @package App\Components
 */

namespace App\Components;

use App\Core\Database;

abstract class Component
{
    protected array $props;
    protected array $data = [];
    protected static array $cssRegistry = [];
    protected static array $jsRegistry = [];

    public function __construct(array $props = [])
    {
        $this->props = $props;
    }

    /**
     * Fetch data from MySQL. Override in child classes.
     * Components MUST fetch their own data from database.
     */
    protected function fetchData(): array
    {
        return [];
    }

    /**
     * Get a prop value
     */
    protected function prop(string $key, mixed $default = null): mixed
    {
        return $this->props[$key] ?? $default;
    }

    /**
     * Set internal data (from MySQL)
     */
    protected function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Get internal data
     */
    protected function getData(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Get database connection
     */
    protected function db(): \PDO
    {
        return Database::getInstance()->getConnection();
    }

    /**
     * Get a setting from MySQL database
     */
    protected function setting(string $key, string $default = ''): string
    {
        static $settings = [];
        if (empty($settings)) {
            $stmt = $this->db()->query("SELECT `key`, `value` FROM sg_settings");
            while ($row = $stmt->fetch()) {
                $settings[$row['key']] = $row['value'];
            }
        }
        return $settings[$key] ?? $default;
    }

    /**
     * CSS for this component (override in child classes)
     */
    public static function css(): string
    {
        return '';
    }

    /**
     * JavaScript for this component (override in child classes)
     */
    public static function js(): string
    {
        return '';
    }

    /**
     * Render the component HTML
     */
    abstract public function render(): string;

    /**
     * Render component with data fetching
     */
    public function renderWithData(): string
    {
        $this->data = $this->fetchData();
        $html = $this->render();
        self::registerAssets();
        return $html;
    }

    /**
     * Register CSS/JS for this component
     */
    protected function registerAssets(): void
    {
        $class = static::class;
        $css = static::css();
        $js = static::js();
        if ($css && !isset(self::$cssRegistry[$class])) {
            self::$cssRegistry[$class] = $css;
        }
        if ($js && !isset(self::$jsRegistry[$class])) {
            self::$jsRegistry[$class] = $js;
        }
    }

    /**
     * Get all registered CSS
     */
    public static function getRegisteredCss(): string
    {
        return implode("\n", self::$cssRegistry);
    }

    /**
     * Get all registered JS
     */
    public static function getRegisteredJs(): string
    {
        return implode("\n", self::$jsRegistry);
    }

    /**
     * Escape HTML
     */
    protected function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
    }

    /**
     * Get image URL from database path
     */
    protected function imageUrl(?string $path, string $type = 'products'): string
    {
        if (empty($path)) return asset('images/placeholder.png');
        return uploadUrl($type . '/' . $path);
    }

    /**
     * Format price
     */
    protected function price(float $amount): string
    {
        return APP_CURRENCY . ' ' . number_format($amount, 2);
    }

    /**
     * Format date
     */
    protected function date(string $date, string $format = 'd M Y'): string
    {
        return $date ? date($format, strtotime($date)) : '';
    }

    /**
     * Time ago
     */
    protected function timeAgo(string $date): string
    {
        if (!$date) return '';
        $timestamp = strtotime($date);
        $diff = time() - $timestamp;
        $intervals = [31536000 => 'year', 2592000 => 'month', 604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second'];
        foreach ($intervals as $seconds => $label) {
            $count = floor($diff / $seconds);
            if ($count >= 1) return "{$count} {$label}" . ($count > 1 ? 's' : '') . ' ago';
        }
        return 'just now';
    }
}
