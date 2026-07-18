<?php
/**
 * SiteFooter Component
 * 
 * Complete footer with about, links, contact, security banner.
 * ALL text and links come from MySQL settings.
 *
 * @package App\Components
 */

namespace App\Components;

class SiteFooter extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->query("SELECT `key`, `value` FROM sg_settings WHERE `group` IN ('general', 'social')");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
        return [
            'site_name' => $settings['site_name'] ?? APP_NAME,
            'email' => $settings['site_email'] ?? CONTACT_EMAIL,
            'phone' => $settings['site_phone'] ?? CONTACT_PHONE,
            'address' => $settings['site_address'] ?? CONTACT_ADDRESS,
            'whatsapp' => $settings['whatsapp_number'] ?? WHATSAPP_NUMBER,
            'facebook' => $settings['facebook_url'] ?? '#',
            'instagram' => $settings['instagram_url'] ?? '#',
            'youtube' => $settings['youtube_url'] ?? '#',
        ];
    }

    public static function css(): string
    {
        return 'footer{background:#1a1a1a;color:#e5e5e5;padding:60px 5% 30px;font-size:13.5px}.footer-col h3{color:white;font-size:15px;font-weight:700;text-transform:uppercase;margin-bottom:20px;padding-bottom:8px;position:relative}.footer-col h3::after{content:\'\';position:absolute;bottom:0;left:0;width:35px;height:2px;background:#b30d1b}.footer-col ul li{margin-bottom:12px}.footer-col ul li a{transition:all .3s}.footer-col ul li a:hover{color:white;padding-left:5px}.security-banner{background:#2b2b2b;border-left:4px solid #b30d1b;padding:15px 25px;border-radius:4px}.security-banner h4{color:white;font-size:14px;font-weight:700;margin-bottom:5px}.payment-methods img{height:22px;filter:grayscale(100%);opacity:.6;transition:all .3s}.payment-methods img:hover{filter:grayscale(0%);opacity:1}';
    }

    public function render(): string
    {
        $name = $this->e($this->getData('site_name'));
        $email = $this->e($this->getData('email'));
        $phone = $this->e($this->getData('phone'));
        $address = $this->e($this->getData('address'));
        $year = date('Y');

        return '
<footer>
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-10">
        <div class="footer-col">
            <h3>About ' . $name . '</h3>
            <p class="leading-relaxed mb-4">' . $name . ' is India\'s leading designer and online marketplace for premium handmade Sholapith wedding items, bridal accessories, and traditional religious items. Handcrafting memories since decades.</p>
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-10 cursor-pointer">
        </div>
        <div class="footer-col">
            <h3>Important Links</h3>
            <ul>
                <li><a href="' . url('account') . '">My Account</a></li>
                <li><a href="' . url('order/track') . '">Track Orders</a></li>
                <li><a href="' . url('page/shipping-returns') . '">Shipping & Returns</a></li>
                <li><a href="' . url('page/privacy-policy') . '">Privacy Policy</a></li>
                <li><a href="' . url('page/terms-conditions') . '">Terms & Conditions</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Contact Us</h3>
            <ul>
                <li class="flex items-start gap-3 mb-4"><i class="fa-solid fa-location-dot text-primary-red text-base mt-0.5"></i><span>' . $address . '</span></li>
                <li class="flex items-start gap-3 mb-4"><i class="fa-solid fa-phone text-primary-red text-base mt-0.5"></i><span>' . $phone . '</span></li>
                <li class="flex items-start gap-3 mb-4"><i class="fa-solid fa-envelope text-primary-red text-base mt-0.5"></i><span>' . $email . '</span></li>
            </ul>
        </div>
    </div>
    <div class="security-banner max-w-[1200px] mx-auto mb-8">
        <h4><i class="fa-solid fa-shield-halved text-primary-red mr-2"></i> Security Warning / Disclaimer</h4>
        <p>Please note that ' . $name . ' representatives will never ask you for OTPs, credit/debit card numbers, PINs, or bank account credentials. Beware of spam phone calls or messages pretending to be our support team. Report any suspicious activities immediately.</p>
    </div>
    <div class="max-w-[1200px] mx-auto pt-6 border-t border-gray-800 flex justify-between items-center flex-wrap gap-4 text-xs text-gray-400">
        <p>&copy; ' . $year . ' ' . $name . '. Handcrafted in India. All Rights Reserved.</p>
        <div class="payment-methods flex gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/196/196070.png" alt="Visa"><img src="https://cdn-icons-png.flaticon.com/512/196/196081.png" alt="MasterCard"><img src="https://cdn-icons-png.flaticon.com/512/196/196091.png" alt="UPI"><img src="https://cdn-icons-png.flaticon.com/512/196/196076.png" alt="Net Banking">
        </div>
    </div>
</footer>';
    }
}
