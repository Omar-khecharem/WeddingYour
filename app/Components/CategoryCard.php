<?php
/**
 * Category Card Component
 * 
 * Renders a category display card with image, name, description,
 * and product count. Used in category grids and featured sections.
 *
 * @package App\Components
 */

namespace App\Components;

class CategoryCard extends Component
{
    public function render(): string
    {
        $category = $this->prop('category', []);
        $style = $this->prop('style', 'circle'); // circle | card | trending
        if (empty($category)) return '';

        $name = $category['name'] ?? '';
        $slug = $category['slug'] ?? '';
        $image = $category['image'] ?? asset('images/placeholder.png');
        $icon = $category['icon'] ?? '';
        $productCount = (int)($category['product_count'] ?? 0);
        $description = $category['description'] ?? '';

        switch ($style) {
            case 'circle':
                return $this->renderCircle($name, $slug, $image);
            case 'trending':
                return $this->renderTrending($name, $slug, $image, $productCount);
            default:
                return $this->renderCard($name, $slug, $image, $icon, $description);
        }
    }

    /**
     * Circle style (used in category circles section)
     */
    private function renderCircle(string $name, string $slug, string $image): string
    {
        $html = '<div class="category-circle">';
        $html .= '<a href="' . url('category/' . $slug) . '">';
        $html .= '<div class="circle-img"><img src="' . $this->e($image) . '" alt="' . $this->e($name) . '" loading="lazy"></div>';
        $html .= '<p>' . $this->e($name) . '</p>';
        $html .= '</a></div>';
        return $html;
    }

    /**
     * Trending style (used in top trending section)
     */
    private function renderTrending(string $name, string $slug, string $image, int $productCount): string
    {
        $html = '<div class="trending-card">';
        $html .= '<div class="trending-img"><a href="' . url('category/' . $slug) . '">';
        $html .= '<img src="' . $this->e($image) . '" alt="' . $this->e($name) . '" loading="lazy">';
        $html .= '</a></div>';
        $html .= '<a href="' . url('category/' . $slug) . '" class="trending-btn">' . $this->e($name) . '</a>';
        if ($productCount > 0) {
            $html .= '<p class="text-[10px] text-gray-500 mt-2 font-medium">' . $productCount . ' products</p>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Card style (general purpose)
     */
    private function renderCard(string $name, string $slug, string $image, string $icon, string $description): string
    {
        $html = '<a href="' . url('category/' . $slug) . '" class="block bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-primary-red transition-all group">';
        if ($image) {
            $html .= '<div class="h-32 rounded-lg overflow-hidden mb-4 bg-gray-100">';
            $html .= '<img src="' . $this->e($image) . '" alt="' . $this->e($name) . '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">';
            $html .= '</div>';
        } elseif ($icon) {
            $html .= '<div class="w-16 h-16 mx-auto mb-4 bg-light-pink rounded-full flex items-center justify-center text-2xl text-primary-red"><i class="fa-solid ' . $this->e($icon) . '"></i></div>';
        }
        $html .= '<h3 class="text-center font-bold text-gray-800 text-sm group-hover:text-primary-red transition-colors">' . $this->e($name) . '</h3>';
        if ($description) {
            $html .= '<p class="text-center text-xs text-gray-500 mt-1 line-clamp-2">' . $this->e($description) . '</p>';
        }
        $html .= '</a>';
        return $html;
    }
}
