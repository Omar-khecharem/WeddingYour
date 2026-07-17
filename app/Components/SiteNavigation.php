<?php
/**
 * SiteNavigation Component
 * 
 * Navigation bar with categories dropdown, page links,
 * and user icons (account, wishlist, compare, cart).
 * All categories and page links come from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class SiteNavigation extends Component
{
    protected function fetchData(): array
    {
        $categories = [];
        $stmt = $this->db()->query("SELECT id, name, slug FROM sg_categories WHERE status = 1 ORDER BY sort_order ASC LIMIT 10");
        while ($row = $stmt->fetch()) {
            $categories[] = $row;
        }
        return [
            'categories' => $categories,
            'cart_count' => (int)\App\Helpers\Session::get('cart.count', 0),
            'wishlist_count' => (int)\App\Helpers\Session::get('wishlist.count', 0),
            'compare_count' => (int)\App\Helpers\Session::get('compare.count', 0),
            'is_logged_in' => \App\Helpers\Session::has('user'),
            'user_name' => \App\Helpers\Session::get('user.name', ''),
        ];
    }

    public static function css(): string
    {
        return '.nav-categories { background: #990011; color: white; font-weight: 700; padding: 12px 24px; display: flex; align-items: center; gap: 16px; cursor: pointer; transition: background 0.3s; border-radius: 4px 0 0 4px; } .nav-categories:hover { background: #7a000d; } .nav-links { background: #83868c; border-bottom: 1px solid #6a6d73; } .nav-links a { color: #e8e8e8; font-weight: 600; font-size: 13px; padding: 12px 0; transition: color 0.3s; } .nav-links a:hover { color: white; } .nav-links .active { border-bottom: 2px solid #990011; } .cart-badge { position: absolute; top: -4px; right: -6px; background: #990011; color: white; font-size: 10px; font-weight: 700; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; }';
    }

    public static function js(): string
    {
        return 'document.addEventListener("click",function(e){var t=e.target.closest(".nav-categories");if(t){var n=t.nextElementSibling;n&&(n.classList.contains("hidden")?n.classList.remove("hidden"):n.classList.add("hidden"))}});';
    }

    public function render(): string
    {
        $cats = $this->getData('categories', []);
        $cartCount = $this->getData('cart_count');
        $wishCount = $this->getData('wishlist_count');
        $compCount = $this->getData('compare_count');
        $loggedIn = $this->getData('is_logged_in');
        $userName = $this->getData('user_name');

        $catItems = '';
        foreach ($cats as $c) {
            $catItems .= '<a href="' . url('category/' . $c['slug']) . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary-red">' . $this->e($c['name']) . '</a>';
        }

        return '
<nav class="nav-links">
    <div class="max-w-[1300px] mx-auto flex items-center justify-between px-[5%]">
        <div class="nav-categories relative">
            <i class="fa-solid fa-bars"></i>
            <span class="uppercase tracking-wide text-sm">Browse Categories</span>
            <i class="fa-solid fa-chevron-down text-xs ml-4"></i>
            <div class="absolute top-full left-0 bg-white shadow-xl rounded-b-xl z-50 hidden min-w-[220px] py-2 border border-gray-100" style="border-radius:0 0 12px 12px">' . $catItems . '</div>
        </div>
        <div class="flex items-center gap-6 overflow-x-auto py-2">
            <a href="' . url('') . '" class="active"><i class="fa-solid fa-house text-xs mr-1"></i> HOME</a>
            <a href="' . url('outlets') . '"><i class="fa-solid fa-shop text-xs mr-1"></i> OUR OUTLETS</a>
            <a href="' . url('about') . '"><i class="fa-solid fa-address-card text-xs mr-1"></i> ABOUT US</a>
            <a href="' . url('contact') . '"><i class="fa-solid fa-address-book text-xs mr-1"></i> CONTACT US</a>
            <a href="' . url('blog') . '">BLOGS</a>
        </div>
        <div class="flex items-center gap-3 py-2">
            <a href="' . ($loggedIn ? url('account') : url('login')) . '" class="icon-btn" title="' . ($loggedIn ? 'My Account' : 'Login') . '"><i class="fa-regular fa-user"></i></a>
            <a href="' . url('compare') . '" class="icon-btn relative" title="Compare"><i class="fa-solid fa-arrows-rotate"></i>' . ($compCount > 0 ? '<span class="cart-badge">' . $compCount . '</span>' : '') . '</a>
            <a href="' . url('wishlist') . '" class="icon-btn relative" title="Wishlist"><i class="fa-regular fa-heart"></i>' . ($wishCount > 0 ? '<span class="cart-badge">' . $wishCount . '</span>' : '') . '</a>
            <div class="flex items-center gap-2">
                <a href="' . url('cart') . '" class="icon-btn bg-[#990011] text-white relative" title="Cart"><i class="fa-solid fa-cart-shopping"></i>' . ($cartCount > 0 ? '<span class="cart-badge">' . $cartCount . '</span>' : '') . '</a>
                <span class="text-sm font-bold text-white">' . APP_CURRENCY . '0.00</span>
            </div>
        </div>
    </div>
</nav>';
    }
}
