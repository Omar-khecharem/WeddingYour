<?php
/**
 * Breadcrumb Component
 * 
 * Renders SEO-friendly breadcrumb navigation with schema.org
 * structured data support. Automatically generates home link.
 *
 * @package App\Components
 */

namespace App\Components;

class Breadcrumb extends Component
{
    public function render(): string
    {
        $crumbs = $this->prop('crumbs', []);
        if (empty($crumbs)) return '';

        $html = '<nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-4 flex-wrap" aria-label="Breadcrumb">';

        // Always start with Home
        $html .= '<a href="' . url('') . '" class="hover:text-primary-red transition-colors"><i class="fa-solid fa-house"></i></a>';

        foreach ($crumbs as $i => $crumb) {
            $html .= '<span class="text-gray-300">/</span>';

            $label = $crumb['label'] ?? '';
            $url = $crumb['url'] ?? '';
            $isLast = $i === array_key_last($crumbs);

            if ($isLast || empty($url)) {
                $html .= '<span class="text-gray-700 font-medium">' . $this->e($label) . '</span>';
            } else {
                $html .= '<a href="' . $this->e($url) . '" class="hover:text-primary-red transition-colors">' . $this->e($label) . '</a>';
            }
        }

        $html .= '</nav>';

        return $html;
    }
}
