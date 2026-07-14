<?php
/**
 * WhatsApp Button Component
 * 
 * Renders a floating WhatsApp button with a pulsating animation,
 * tooltip, and pre-filled message support for customer inquiries.
 *
 * @package App\Components
 */

namespace App\Components;

class WhatsAppButton extends Component
{
    public function render(): string
    {
        $number = $this->prop('number', WHATSAPP_NUMBER);
        $message = $this->prop('message', 'Hello! I have a question about your products.');
        $position = $this->prop('position', 'right'); // right | left
        $showTooltip = $this->prop('showTooltip', true);
        $tooltipText = $this->prop('tooltipText', 'Chat with us on WhatsApp');

        $url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $number) . '?text=' . urlencode($message);
        $posClass = $position === 'left' ? 'left-5' : 'right-5';

        $html = '<a href="' . $this->e($url) . '" class="whatsapp-float ' . $posClass . '" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">';

        if ($showTooltip) {
            $html .= '<span class="absolute ' . ($position === 'right' ? 'right-16' : 'left-16') . ' bg-gray-800 text-white text-xs px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg">';
            $html .= $this->e($tooltipText);
            $html .= '</span>';
        }

        $html .= '<i class="fa-brands fa-whatsapp"></i>';
        $html .= '</a>';

        return $html;
    }
}
