<?php
/**
 * Review Card Component
 * 
 * Renders a customer review/testimonial card with avatar,
 * name, rating stars, date, and review content matching
 * the site's design language.
 *
 * @package App\Components
 */

namespace App\Components;

class ReviewCard extends Component
{
    public function render(): string
    {
        $review = $this->prop('review', []);
        if (empty($review)) return '';

        $name = $review['name'] ?? 'Anonymous';
        $rating = (int)($review['rating'] ?? 5);
        $comment = $review['comment'] ?? '';
        $date = $review['created_at'] ?? '';
        $avatar = $review['avatar'] ?? '';
        $isVerified = (bool)($review['is_verified'] ?? false);
        $title = $review['title'] ?? '';

        $html = '<div class="review-card">';
        $html .= '<div class="flex items-center gap-3 mb-4">';

        // Avatar
        if ($avatar) {
            $html .= '<div class="avatar"><img src="' . $this->e($avatar) . '" alt="' . $this->e($name) . '" loading="lazy"></div>';
        } else {
            $initials = strtoupper(substr($name, 0, 1));
            $colors = ['#b30d1b', '#e65100', '#800020', '#d4af37', '#2e7d32'];
            $colorIndex = crc32($name) % count($colors);
            $html .= '<div class="avatar bg-gray-200 flex items-center justify-center font-bold text-lg" style="background:' . $colors[$colorIndex] . ';color:white;">' . $initials . '</div>';
        }

        $html .= '<div>';
        $html .= '<h5 class="font-bold text-sm text-gray-800 flex items-center gap-2">' . $this->e($name);
        if ($isVerified) {
            $html .= '<span class="bg-green-100 text-green-600 text-[9px] font-bold px-1.5 py-0.5 rounded">Verified</span>';
        }
        $html .= '</h5>';
        $html .= '<div class="stars text-[#ffd54f] text-xs">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $rating ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
        }
        $html .= '</div></div></div>';

        if ($title) {
            $html .= '<h6 class="font-bold text-xs text-gray-700 mb-1">' . $this->e($title) . '</h6>';
        }

        if ($date) {
            $html .= '<div class="text-[11px] text-gray-400 mb-2">' . timeAgo($date) . '</div>';
        }

        $html .= '<p class="text-[12.5px] text-gray-600 leading-relaxed">' . $this->e($comment) . '</p>';
        $html .= '</div>';

        return $html;
    }
}
