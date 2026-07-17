<?php
/**
 * CategorySlider Component
 * 
 * Horizontal scrollable category circles with images.
 * All categories, names, and images come from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class CategorySlider extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("
            SELECT c.*, 
                   (SELECT image FROM sg_product_images pi JOIN sg_products p ON p.id = pi.product_id WHERE p.category_id = c.id AND pi.is_primary = 1 LIMIT 1) as sample_image
            FROM sg_categories c WHERE c.status = 1 ORDER BY c.sort_order ASC, c.name ASC
        ");
        return ['categories' => $stmt->fetchAll()];
    }

    public static function css(): string
    {
        return '.category-circle{text-align:center;cursor:pointer;min-width:100px}.category-circle .circle-img{width:110px;height:110px;border-radius:40% 40% 40% 40%;overflow:hidden;border:3px solid #e2e2e2;transition:all .3s;margin:0 auto 10px}.category-circle:hover .circle-img{transform:translateY(-5px);border-color:#b30d1b;box-shadow:0 6px 15px rgba(179,13,27,.15)}.category-circle .circle-img img{width:100%;height:100%;object-fit:cover}.category-circle p{font-size:11px;font-weight:800;text-transform:uppercase;color:#333;letter-spacing:.3px}';
    }

    public function render(): string
    {
        $categories = $this->getData('categories', []);
        $items = '';

        foreach ($categories as $cat) {
            $img = $cat['sample_image'] ? $this->imageUrl($cat['sample_image'], 'products') : asset('images/placeholder.png');
            if ($cat['image']) $img = $this->imageUrl($cat['image'], 'categories');
            $items .= '<div class="category-circle"><a href="' . url('category/' . $cat['slug']) . '"><div class="circle-img"><img src="' . $this->e($img) . '" alt="' . $this->e($cat['name']) . '" loading="lazy"></div><p>' . $this->e($cat['name']) . '</p></a></div>';
        }

        if (empty($categories)) {
            $items = '<div class="category-circle"><div class="circle-img bg-gray-100 flex items-center justify-center text-gray-400 text-2xl"><i class="fa-solid fa-box"></i></div><p>No Categories</p></div>';
        }

        return '<section class="py-8 px-[5%] bg-white border-b border-gray-200 overflow-x-auto"><div class="flex justify-center gap-8 min-w-max">' . $items . '</div></section>';
    }
}
