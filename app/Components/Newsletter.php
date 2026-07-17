<?php
/**
 * Newsletter Component
 * 
 * Renders an email subscription form with validation,
 * AJAX submission support, and success feedback.
 *
 * @package App\Components
 */

namespace App\Components;

class Newsletter extends Component
{
    public function render(): string
    {
        $title = $this->prop('title', 'Subscribe to Our Newsletter');
        $subtitle = $this->prop('subtitle', 'Get the latest updates on new products and exclusive offers.');
        $placeholder = $this->prop('placeholder', 'Enter your email address');
        $buttonText = $this->prop('buttonText', 'Subscribe');
        $class = $this->prop('class', '');
        $bgClass = $this->prop('bgClass', 'bg-primary-red');

        $html = '<div class="' . $this->e($bgClass) . ' text-white rounded-2xl p-8 md:p-12 ' . $this->e($class) . '">';
        $html .= '<div class="max-w-xl mx-auto text-center">';
        $html .= '<h3 class="text-2xl md:text-3xl font-bold font-playfair mb-2">' . $this->e($title) . '</h3>';
        $html .= '<p class="text-sm opacity-90 mb-6">' . $this->e($subtitle) . '</p>';
        $html .= '<form id="newsletter-form" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" onsubmit="return submitNewsletter(event)">';
        $html .= '<input type="email" name="email" required placeholder="' . $this->e($placeholder) . '" class="flex-1 px-5 py-3 rounded-full text-gray-800 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white">';
        $html .= '<button type="submit" class="bg-dark-red text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-opacity-90 transition-all whitespace-nowrap shadow-lg">' . $this->e($buttonText) . '</button>';
        $html .= '</form>';
        $html .= '<div id="newsletter-msg" class="mt-3 text-sm"></div>';
        $html .= '</div></div>';

        return $html;
    }

    /**
     * JavaScript for newsletter AJAX submission
     */
    public static function renderScript(): string
    {
        return '<script>
            function submitNewsletter(e) {
                e.preventDefault();
                var form = document.getElementById("newsletter-form");
                var msg = document.getElementById("newsletter-msg");
                var formData = new FormData(form);
                formData.append("action", "newsletter_subscribe");
                fetch("' . url('newsletter/subscribe') . '", {
                    method: "POST",
                    body: formData,
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    if (d.success) {
                        msg.innerHTML = "<span class=\"text-green-300 font-medium\">" + d.message + "</span>";
                        form.reset();
                    } else {
                        msg.innerHTML = "<span class=\"text-yellow-300 font-medium\">" + d.message + "</span>";
                    }
                })
                .catch(function() {
                    msg.innerHTML = "<span class=\"text-red-300 font-medium\">Something went wrong. Please try again.</span>";
                });
                return false;
            }
        </script>';
    }
}
