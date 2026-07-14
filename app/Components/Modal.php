<?php
/**
 * Modal Component
 * 
 * Renders accessible modal dialogs with customizable content,
 * header, footer, sizes, and trigger buttons.
 *
 * @package App\Components
 */

namespace App\Components;

class Modal extends Component
{
    public function render(): string
    {
        $id = $this->prop('id', 'modal-' . uniqid());
        $title = $this->prop('title', '');
        $body = $this->prop('body', '');
        $size = $this->prop('size', 'md'); // sm, md, lg, xl
        $footer = $this->prop('footer', '');
        $showClose = $this->prop('showClose', true);

        $sizes = [
            'sm' => 'max-w-md',
            'md' => 'max-w-lg',
            'lg' => 'max-w-2xl',
            'xl' => 'max-w-4xl',
        ];

        $sizeClass = $sizes[$size] ?? $sizes['md'];

        $html = '<div id="' . $this->e($id) . '" class="fixed inset-0 z-[9998] hidden overflow-y-auto" role="dialog" aria-modal="true">';
        $html .= '<div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">';
        $html .= '<div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal(\'' . $this->e($id) . '\')"></div>';
        $html .= '<div class="relative inline-block bg-white rounded-2xl shadow-xl text-left overflow-hidden transform transition-all ' . $sizeClass . ' w-full my-8">';

        // Header
        if ($title || $showClose) {
            $html .= '<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">';
            $html .= '<h3 class="text-lg font-bold text-gray-900">' . $this->e($title) . '</h3>';
            if ($showClose) {
                $html .= '<button onclick="closeModal(\'' . $this->e($id) . '\')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>';
            }
            $html .= '</div>';
        }

        // Body
        $html .= '<div class="px-6 py-4">' . $body . '</div>';

        // Footer
        if ($footer) {
            $html .= '<div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">' . $footer . '</div>';
        }

        $html .= '</div></div></div>';

        // Trigger button
        $triggerText = $this->prop('triggerText', 'Open Modal');
        $triggerClass = $this->prop('triggerClass', 'bg-primary-red text-white px-4 py-2 rounded-lg hover:opacity-90');
        $trigger = $this->prop('trigger', '');

        if ($trigger) {
            $html = $trigger . $html;
        } else {
            $html = '<button type="button" onclick="openModal(\'' . $this->e($id) . '\')" class="' . $this->e($triggerClass) . '">' . $this->e($triggerText) . '</button>' . $html;
        }

        return $html;
    }

    /**
     * Render modal open/close JavaScript
     */
    public static function renderScripts(): string
    {
        return '<script>
            function openModal(id) { document.getElementById(id).classList.remove("hidden"); document.body.style.overflow = "hidden"; }
            function closeModal(id) { document.getElementById(id).classList.add("hidden"); document.body.style.overflow = ""; }
            document.addEventListener("keydown", function(e) { if (e.key === "Escape") { document.querySelectorAll(\'[role="dialog"]\').forEach(function(m) { m.classList.add("hidden"); }); document.body.style.overflow = ""; } });
        </script>';
    }
}
