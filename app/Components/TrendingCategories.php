<?php
/**
 * TrendingCategories Component
 * 
 * Top trending categories grid with images.
 * Categories, names, images, and product counts come from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class TrendingCategories extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("
            SELECT c.*, COUNT(p.id) as product_count,
                   (SELECT image FROM sg_product_images pi JOIN sg_products p2 ON p2.id = pi.product_id WHERE p2.category_id = c.id AND pi.is_primary = 1 LIMIT 1) as sample_image
            FROM sg_categories c
            LEFT JOIN sg_products p ON p.category_id = c.id AND p.status = 1 AND p.is_trending = 1
            WHERE c.status = 1
            GROUP BY c.id
            ORDER BY product_count DESC, c.sort_order ASC LIMIT 4
        ");
        return ['categories' => $stmt->fetchAll()];
    }

    public static function css(): string
    {
        return '.section-title{font-family:\'Playfair Display\',serif;font-size:30px;font-weight:700;color:#5c0017}.section-subtitle{font-size:13px;color:#666;text-transform:uppercase;letter-spacing:1.5px;font-weight:600}.trending-card{background:white;border-radius:40px;border:3px solid #ffdde1;padding:15px;text-align:center;box-shadow:0 8px 24px rgba(0,0,0,.04);transition:all .3s}.trending-card:hover{transform:translateY(-5px);border-color:#b30d1b;box-shadow:0 12px 30px rgba(179,13,27,.08)}.trending-card .trending-img{height:200px;border-radius:30px;overflow:hidden;margin-bottom:18px}.trending-card .trending-img img{width:100%;height:100%;object-fit:cover;transition:transform .3s}.trending-card:hover .trending-img img{transform:scale(1.06)}.trending-btn{display:inline-block;background:linear-gradient(135deg,#f57c00,#e65100);color:white;padding:10px 30px;border-radius:25px;font-weight:700;font-size:13px;box-shadow:0 4px 12px rgba(230,81,0,.3);transition:all .3s;width:85%}.trending-btn:hover{background:linear-gradient(135deg,#e65100,#bf360c);box-shadow:0 6px 18px rgba(230,81,0,.45);transform:scale(1.03)}.maroon-btn{display:inline-block;background:linear-gradient(135deg,#b30d1b,#800000);color:white;padding:14px 45px;border-radius:30px;font-weight:700;font-size:13.5px;text-transform:uppercase;box-shadow:0 5px 15px rgba(179,13,27,.3);transition:all .3s}.maroon-btn:hover{transform:scale(1.05);box-shadow:0 8px 22px rgba(179,13,27,.45)}';
    }

    public function render(): string
    {
        $categories = $this->getData('categories', []);
        $items = '';

        foreach ($categories as $cat) {
            $img = $cat['sample_image'] ? $this->imageUrl($cat['sample_image'], 'products') : asset('images/placeholder.png');
            $items .= '<div class="trending-card"><div class="trending-img"><img src="' . $this->e($img) . '" alt="' . $this->e($cat['name']) . '" loading="lazy"></div><a href="' . url('category/' . $cat['slug']) . '" class="trending-btn">' . $this->e($cat['name']) . '</a></div>';
        }

        if (empty($categories)) {
            for ($i = 1; $i <= 4; $i++) {
                $items .= '<div class="trending-card"><div class="trending-img bg-gray-100"></div><span class="trending-btn">Category</span></div>';
            }
        }

        return '
<section class="py-10">
    <div class="text-center max-w-[600px] mx-auto mb-10">
        <h2 class="section-title">Top Trending Categories</h2>
        <p class="section-subtitle">Exquisite Handcrafted Wedding Masterpieces</p>
    </div>
    <div class="max-w-[1200px] mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">' . $items . '</div>
    <div class="text-center mt-8"><a href="' . url('categories') . '" class="maroon-btn">View All Categories <i class="fa-solid fa-angles-right ml-1.5"></i></a></div>
</section>';
    }
}
