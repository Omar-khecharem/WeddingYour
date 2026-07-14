<?php
/**
 * Pagination Component
 * 
 * Renders accessible page navigation with previous/next links,
 * page numbers, ellipsis for large result sets, and configurable
 * styling to match the site's design system.
 *
 * @package App\Components
 */

namespace App\Components;

class Pagination extends Component
{
    public function render(): string
    {
        $currentPage = (int)$this->prop('currentPage', 1);
        $totalPages = (int)$this->prop('totalPages', 1);
        $baseUrl = $this->prop('baseUrl', '?');
        $maxVisible = (int)$this->prop('maxVisible', 5);
        $class = $this->prop('class', '');

        if ($totalPages <= 1) return '';

        $html = '<nav class="flex items-center justify-center gap-1.5 mt-8 ' . $this->e($class) . '" aria-label="Pagination">';

        // Previous button
        $prevDisabled = $currentPage <= 1;
        $prevUrl = $baseUrl . 'page=' . ($currentPage - 1);
        $html .= $prevDisabled
            ? '<span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-gray-50 text-gray-300 cursor-not-allowed"><i class="fa-solid fa-chevron-left text-xs"></i></span>'
            : '<a href="' . $this->e($prevUrl) . '" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary-red transition-all"><i class="fa-solid fa-chevron-left text-xs"></i></a>';

        // Page numbers
        $half = floor(($maxVisible - 1) / 2);
        $start = max(1, $currentPage - $half);
        $end = min($totalPages, $start + $maxVisible - 1);

        if ($end - $start + 1 < $maxVisible) {
            $start = max(1, $end - $maxVisible + 1);
        }

        if ($start > 1) {
            $html .= '<a href="' . $this->e($baseUrl) . 'page=1" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary-red transition-all text-sm font-medium">1</a>';
            if ($start > 2) {
                $html .= '<span class="inline-flex items-center justify-center w-10 h-10 text-gray-400 text-sm">...</span>';
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            $isActive = $i === $currentPage;
            $pageUrl = $baseUrl . 'page=' . $i;
            $html .= $isActive
                ? '<span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary-red text-white text-sm font-bold shadow-sm">' . $i . '</span>'
                : '<a href="' . $this->e($pageUrl) . '" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary-red transition-all text-sm font-medium">' . $i . '</a>';
        }

        if ($end < $totalPages) {
            if ($end < $totalPages - 1) {
                $html .= '<span class="inline-flex items-center justify-center w-10 h-10 text-gray-400 text-sm">...</span>';
            }
            $html .= '<a href="' . $this->e($baseUrl) . 'page=' . $totalPages . '" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary-red transition-all text-sm font-medium">' . $totalPages . '</a>';
        }

        // Next button
        $nextDisabled = $currentPage >= $totalPages;
        $nextUrl = $baseUrl . 'page=' . ($currentPage + 1);
        $html .= $nextDisabled
            ? '<span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-gray-50 text-gray-300 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></span>'
            : '<a href="' . $this->e($nextUrl) . '" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-primary-red transition-all"><i class="fa-solid fa-chevron-right text-xs"></i></a>';

        $html .= '</nav>';

        return $html;
    }
}
