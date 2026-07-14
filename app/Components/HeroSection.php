<?php
/**
 * HeroSection Component
 * 
 * Hero area with video overlay card and flash sale banner.
 * Flash sale text, coupon code, and images come from MySQL.
 *
 * @package App\Components
 */

namespace App\Components;

class HeroSection extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("SELECT code, value, type, description FROM sg_coupons WHERE is_active = 1 AND code = 'SGTM20' LIMIT 1");
        $coupon = $stmt->fetch();
        return [
            'video_bg' => $this->setting('hero_video_bg', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1200'),
            'coupon_code' => $coupon['code'] ?? 'SGTM20',
            'discount' => $coupon['value'] ?? 20,
            'banner_title' => $this->setting('hero_banner_title', 'FLAT ' . ($coupon['value'] ?? 20) . '% OFF'),
            'banner_text' => $this->setting('hero_banner_text', 'On Handcrafted Traditional Topor Mukut Sets'),
            'banner_img' => $this->setting('hero_banner_img', 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=150'),
        ];
    }

    public static function css(): string
    {
        return '.hero-video-card{background:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.4)),var(--hero-bg);background-size:cover;background-position:center;border-radius:16px;overflow:hidden;height:280px;display:flex;align-items:center;justify-content:center;position:relative}.play-btn{width:70px;height:70px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;color:#b30d1b;cursor:pointer;box-shadow:0 4px 20px rgba(0,0,0,.25);transition:all .3s;animation:pulse-ring 2s infinite}.play-btn:hover{transform:scale(1.1);background:#b30d1b;color:white}@keyframes pulse-ring{0%{box-shadow:0 0 0 0 rgba(255,255,255,.4)}70%{box-shadow:0 0 0 20px rgba(255,255,255,0)}100%{box-shadow:0 0 0 0 rgba(255,255,255,0)}}.hero-banner-card{background:linear-gradient(135deg,#f57c00,#e65100);border-radius:16px;overflow:hidden;height:280px;padding:30px;display:flex;flex-direction:column;justify-content:center;color:white;position:relative}.hero-banner-card .banner-img{position:absolute;right:20px;top:50%;transform:translateY(-50%);width:35%;opacity:.85}.hero-banner-card .banner-img img{border-radius:50%;box-shadow:0 8px 25px rgba(0,0,0,.2)}';
    }

    public function render(): string
    {
        $videoBg = $this->e($this->getData('video_bg'));
        $couponCode = $this->e($this->getData('coupon_code'));
        $discount = $this->e($this->getData('discount'));
        $bannerTitle = $this->e($this->getData('banner_title'));
        $bannerText = $this->e($this->getData('banner_text'));
        $bannerImg = $this->e($this->getData('banner_img'));

        return '
<section class="max-w-[1200px] mx-auto my-6 px-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="hero-video-card" style="--hero-bg:url(' . $videoBg . ')">
        <div class="play-btn"><i class="fa-solid fa-play"></i></div>
        <span class="absolute top-3 right-3 bg-black/60 text-white text-xs px-3 py-1 rounded-full">Order <i class="fa-brands fa-whatsapp text-green-400"></i></span>
    </div>
    <div class="hero-banner-card">
        <div class="banner-img"><img src="' . $bannerImg . '" alt="Topor Set" loading="lazy"></div>
        <span class="bg-yellow-400 text-gray-900 font-bold text-[10px] uppercase px-2 py-1 rounded inline-block w-fit">Flash Sale</span>
        <h2 class="text-3xl md:text-4xl font-extrabold leading-tight mt-2">' . $bannerTitle . '</h2>
        <p class="text-sm text-orange-100 mt-1">' . $bannerText . '</p>
        <a href="' . url('products?coupon=' . $couponCode) . '" class="inline-block mt-4 bg-white text-orange-600 font-bold text-xs px-5 py-2 rounded-full shadow hover:bg-orange-50 transition-all w-fit">Buy Now</a>
    </div>
</section>';
    }
}
