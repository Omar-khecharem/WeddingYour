<?php
/**
 * Alert Component
 * 
 * Renders dismissible alert/notification messages with support for
 * success, error, warning, and info types with icons and animations.
 *
 * @package App\Components
 */

namespace App\Components;

class Alert extends Component
{
    private static array $types = [
        'success' => ['icon' => 'fa-circle-check', 'color' => 'bg-green-100 border-green-400 text-green-700'],
        'error'   => ['icon' => 'fa-circle-xmark', 'color' => 'bg-red-100 border-red-400 text-red-700'],
        'warning' => ['icon' => 'fa-triangle-exclamation', 'color' => 'bg-yellow-100 border-yellow-400 text-yellow-700'],
        'info'    => ['icon' => 'fa-circle-info', 'color' => 'bg-blue-100 border-blue-400 text-blue-700'],
    ];

    public function render(): string
    {
        $type = $this->prop('type', 'info');
        $message = $this->prop('message', '');
        $dismissible = $this->prop('dismissible', true);
        $icon = $this->prop('icon', null);

        if (!$message) return '';

        $config = self::$types[$type] ?? self::$types['info'];
        $iconClass = $icon ?? $config['icon'];

        $html = "<div class=\"{$config['color']} border-l-4 px-4 py-3 rounded-lg shadow-sm {$this->prop('class', '')}\" role=\"alert\">";
        $html .= '<div class="flex items-center justify-between">';
        $html .= '<div class="flex items-center gap-3">';
        $html .= '<i class="fa-solid ' . $iconClass . ' text-lg"></i>';
        $html .= '<p class="text-sm font-medium">' . $this->e($message) . '</p>';
        $html .= '</div>';

        if ($dismissible) {
            $html .= '<button onclick="this.parentElement.parentElement.remove()" class="text-current opacity-50 hover:opacity-100 transition-opacity ml-3">&times;</button>';
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * Render a flash message from session
     */
    public static function renderFlash(): string
    {
        $html = '';
        $flashTypes = ['success', 'error', 'warning', 'info'];

        foreach ($flashTypes as $type) {
            $message = \App\Helpers\Session::flash($type);
            if ($message) {
                $alert = new self(['type' => $type, 'message' => $message, 'class' => 'fixed top-24 right-5 z-[9999] animate-slideInRight max-w-md']);
                $html .= $alert->render();
            }
        }

        return $html;
    }
}
