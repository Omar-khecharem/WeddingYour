<?php
/**
 * TopBanner Component
 * 
 * Top ticker bar showing promotional offers.
 * Coupon code and message come from MySQL settings/coupons.
 *
 * @package App\Components
 */

namespace App\Components;

class TopBanner extends Component
{
    protected function fetchData(): array
    {
        $stmt = $this->db()->prepare("SELECT code, description FROM sg_coupons WHERE is_active = 1 AND type = 'percentage' ORDER BY RAND() LIMIT 1");
        $stmt->execute();
        $coupon = $stmt->fetch();
        return [
            'message' => $this->setting('top_banner_message', 'Get FLAT 20% OFF On Topor Mukut set. To Redeem This Offer Use The Code'),
            'coupon_code' => $coupon['code'] ?? $this->setting('default_coupon', 'SGTM20'),
        ];
    }

    public static function css(): string
    {
        return '.header-top-bar { background: #fce4ec; color: #111; font-size: 13px; font-weight: 700; text-align: center; padding: 10px 15px; border-bottom: 2px solid #f8a5c2; letter-spacing: 0.5px; } .header-top-bar span { color: #b30d1b; }';
    }

    public function render(): string
    {
        $message = $this->getData('message');
        $code = $this->getData('coupon_code');
        return '<div class="header-top-bar">' . $this->e($message) . ' - <span>' . $this->e($code) . '</span></div>';
    }
}
