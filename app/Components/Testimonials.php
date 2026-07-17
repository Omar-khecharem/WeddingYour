<?php
/**
 * Testimonials Component
 * 
 * Customer reviews/testimonials grid.
 * ALL data (names, comments, ratings, avatars, dates) comes from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class Testimonials extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("
            SELECT r.*, u.avatar as user_avatar, p.name as product_name
            FROM sg_reviews r
            LEFT JOIN sg_users u ON u.id = r.user_id
            LEFT JOIN sg_products p ON p.id = r.product_id
            WHERE r.is_approved = 1
            ORDER BY r.created_at DESC LIMIT 3
        ");
        return ['reviews' => $stmt->fetchAll()];
    }

    public static function css(): string
    {
        return '.review-card{background:white;border:1px solid #e2e2e2;border-radius:12px;padding:25px;transition:all .3s}.review-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.05)}.review-card .avatar{width:46px;height:46px;border-radius:50%;overflow:hidden;background:#eaeaea;flex-shrink:0}.review-card .avatar img{width:100%;height:100%;object-fit:cover}';
    }

    public function render(): string
    {
        $reviews = $this->getData('reviews', []);
        $items = '';

        foreach ($reviews as $r) {
            $name = $this->e($r['name'] ?? 'Anonymous');
            $comment = $this->e($r['comment'] ?? '');
            $rating = (int)($r['rating'] ?? 5);
            $date = $this->timeAgo($r['created_at'] ?? '');
            $avatar = '';

            if ($r['user_avatar']) {
                $avatar = '<div class="avatar"><img src="' . $this->e($r['user_avatar']) . '" alt="' . $name . '" loading="lazy"></div>';
            } else {
                $initial = strtoupper(substr($name, 0, 1));
                $colors = ['#b30d1b', '#e65100', '#800020', '#d4af37'];
                $color = $colors[crc32($name) % count($colors)];
                $avatar = '<div class="avatar flex items-center justify-center font-bold text-white text-lg" style="background:' . $color . '">' . $initial . '</div>';
            }

            $stars = '';
            for ($i = 1; $i <= 5; $i++) {
                $stars .= $i <= $rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
            }

            $items .= '
<div class="review-card">
    <div class="flex items-center gap-3 mb-4">
        ' . $avatar . '
        <div>
            <h5 class="font-bold text-sm text-gray-800">' . $name . '</h5>
            <div class="stars text-[#ffd54f] text-xs">' . $stars . '</div>
        </div>
    </div>
    <div class="text-[11px] text-gray-400 mb-3">' . $date . '</div>
    <p class="text-[12.5px] text-gray-600 leading-relaxed">' . $comment . '</p>
</div>';
        }

        if (empty($reviews)) {
            $items = '<div class="col-span-full text-center py-8 text-gray-400">No reviews yet. Be the first!</div>';
        }

        return '
<section class="bg-gray-50 py-14 px-4 border-y border-gray-200">
    <div class="max-w-[1200px] mx-auto">
        <div class="text-center max-w-[600px] mx-auto mb-8">
            <h2 class="section-title">Reviews On Google By Our Clients</h2>
            <p class="section-subtitle">Real feedback from real weddings</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">' . $items . '</div>
    </div>
</section>';
    }
}
