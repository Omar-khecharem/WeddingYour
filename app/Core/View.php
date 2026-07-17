<?php
/**
 * View Renderer
 * 
 * Handles rendering of PHP view files with data extraction,
 * layout support, and section/content blocks.
 *
 * @package App\Core
 */

namespace App\Core;

class View
{
    /**
     * Registered view composers (callbacks that add data to views)
     */
    private static array $composers = [];

    /**
     * Section content storage
     */
    private static array $sections = [];

    /**
     * Current section being captured
     */
    private static ?string $currentSection = null;

    /**
     * Component cache
     */
    private static array $componentCache = [];

    /**
     * Render a view with layout
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): string
    {
        $content = self::renderPartial($view, $data);

        $layoutData = array_merge($data, ['content' => $content]);
        return self::renderPartial("layouts.{$layout}", $layoutData);
    }

    /**
     * Render a view file without layout
     */
    public static function renderPartial(string $view, array $data = []): string
    {
        $viewPath = self::resolveViewPath($view);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View '{$view}' not found at: {$viewPath}");
        }

        // Run view composers
        foreach (self::$composers as $pattern => $callback) {
            if (fnmatch($pattern, $view)) {
                $callback($data);
            }
        }

        // Extract data to variable scope
        extract($data, EXTR_SKIP);

        // Start output buffering
        ob_start();
        require $viewPath;
        return ob_get_clean();
    }

    /**
     * Resolve dot-notation view path to file path
     */
    private static function resolveViewPath(string $view): string
    {
        $path = str_replace('.', DS, $view);
        $extensions = ['.php', '.html', '.phtml'];

        foreach ($extensions as $ext) {
            $fullPath = VIEWS_DIR . DS . $path . $ext;
            if (file_exists($fullPath)) {
                return $fullPath;
            }
        }

        return VIEWS_DIR . DS . $path . '.php';
    }

    /**
     * Start a content section
     */
    public static function startSection(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }

    /**
     * End the current section
     */
    public static function endSection(): void
    {
        if (self::$currentSection) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }

    /**
     * Get section content
     */
    public static function section(string $name, string $default = ''): string
    {
        return self::$sections[$name] ?? $default;
    }

    /**
     * Check if a section exists
     */
    public static function hasSection(string $name): bool
    {
        return isset(self::$sections[$name]);
    }

    /**
     * Include a sub-view (component)
     */
    public static function include(string $view, array $data = []): string
    {
        return self::renderPartial($view, $data);
    }

    /**
     * Register a view composer
     */
    public static function composer(string $pattern, callable $callback): void
    {
        self::$composers[$pattern] = $callback;
    }

    /**
     * Escape HTML special characters
     */
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
    }

    /**
     * Render a component
     */
    public static function component(string $component, array $props = []): string
    {
        $componentClass = 'App\\Components\\' . $component;

        if (!class_exists($componentClass)) {
            throw new \RuntimeException("Component '{$component}' not found.");
        }

        $instance = new $componentClass($props);
        return $instance->render();
    }

    /**
     * Render errors if present
     */
    public static function errors(string $field = ''): string
    {
        $errors = \App\Helpers\Session::get('errors', []);
        if (empty($errors)) return '';

        if ($field && isset($errors[$field])) {
            $msg = is_array($errors[$field]) ? implode('<br>', $errors[$field]) : $errors[$field];
            return '<span class="text-red-500 text-xs mt-1">' . htmlspecialchars($msg) . '</span>';
        }

        if (!$field) {
            $html = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">';
            foreach ($errors as $error) {
                $html .= '<p class="text-sm">' . htmlspecialchars(is_array($error) ? implode(', ', $error) : $error) . '</p>';
            }
            $html .= '</div>';
            return $html;
        }

        return '';
    }

    /**
     * Render old input value
     */
    public static function old(string $field, string $default = ''): string
    {
        $old = \App\Helpers\Session::get('old', []);
        return htmlspecialchars($old[$field] ?? $default);
    }

    /**
     * Clear flash data (errors, old input)
     */
    public static function clearFlash(): void
    {
        \App\Helpers\Session::remove('errors');
        \App\Helpers\Session::remove('old');
    }
}
