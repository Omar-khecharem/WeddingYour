<?php
/**
 * QuickGrid Component
 * 
 * 3-column grid categories with image grids and "See more" links.
 * Categories, images, and links come from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class QuickGrid extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("
            SELECT c.*, 
                   (SELECT GROUP_CONCAT(pi.image ORDER BY pi.sort_order ASC SEPARATOR '|') 
                    FROM sg_product_images pi 
                    JOIN sg_products p ON p.id = pi.product_id 
                    WHERE p.category_id = c.id AND pi.is_primary = 0 LIMIT 4) as grid_images
            FROM sg_categories c WHERE c.status = 1 ORDER BY c.sort_order ASC LIMIT 3
        ");
        $grids = $stmt->fetchAll();

        foreach ($grids as &$g) {
            $images = $g['grid_images'] ? explode('|', $g['grid_images']) : [];
            if (empty($images)) {
                $stmt2 = $this->db()->prepare("SELECT pi.image FROM sg_product_images pi JOIN sg_products p ON p.id = pi.product_id WHERE p.category_id = :cid LIMIT 4");
                $stmt2->execute([':cid' => $g['id']]);
                $images = array_column($stmt2->fetchAll(), 'image');
            }
            $g['images'] = $images;
            while (count($g['images']) < 4) {
                $g['images'][] = '';
            }
        }

        return ['grids' => $grids];
    }

    public static function css(): string
    {
        return '.quick-grid-card{background:white;border:1px solid #e8e8e8;border-radius:8px;padding:20px;box-shadow:0 4px 12px rgba(0,0,0,.03)}.quick-grid-card h3{font-size:17px;font-weight:700;color:#222;margin-bottom:15px;padding-bottom:8px;position:relative}.quick-grid-card h3::after{content:\'\';position:absolute;bottom:0;left:0;width:40px;height:2px;background:#b30d1b}.grid-img-item{height:100px;border-radius:6px;overflow:hidden;background:#f5f5f5}.grid-img-item img{width:100%;height:100%;object-fit:cover;transition:transform .3s}.grid-img-item:hover img{transform:scale(1.08)}';
    }

    public function render(): string
    {
        $grids = $this->getData('grids', []);
        $html = '<section class="max-w-[1200px] mx-auto my-10 px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">';

        foreach ($grids as $g) {
            $images = $g['images'] ?? ['', '', '', ''];
            $html .= '<div class="quick-grid-card"><h3>' . $this->e($g['name']) . '</h3><div class="grid grid-cols-2 gap-2.5 mb-4">';
            foreach ($images as $img) {
                $src = $img ? $this->imageUrl($img, 'products') : asset('images/placeholder.png');
                $html .= '<div class="grid-img-item"><img src="' . $this->e($src) . '" alt="" loading="lazy"></div>';
            }
            $html .= '</div><a href="' . url('category/' . $g['slug']) . '" class="text-[12.5px] font-bold text-gray-600 hover:text-primary-red flex items-center gap-1 transition-colors">See more <i class="fa-solid fa-angle-right"></i></a></div>';
        }

        if (empty($grids)) {
            for ($i = 1; $i <= 3; $i++) {
                $html .= '<div class="quick-grid-card"><h3>Category ' . $i . '</h3><div class="grid grid-cols-2 gap-2.5 mb-4">';
                for ($j = 0; $j < 4; $j++) {
                    $html .= '<div class="grid-img-item bg-gray-100 flex items-center justify-center text-gray-300"><i class="fa-solid fa-image"></i></div>';
                }
                $html .= '</div><a href="#" class="text-[12.5px] font-bold text-gray-600 hover:text-primary-red flex items-center gap-1">See more <i class="fa-solid fa-angle-right"></i></a></div>';
            }
        }

        return $html . '</section>';
    }
}
