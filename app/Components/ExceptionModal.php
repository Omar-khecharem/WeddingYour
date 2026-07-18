<?php

namespace App\Components;

class ExceptionModal extends Component
{
    public function render(): string
    {
        $id = $this->prop('id', 'exception-modal-' . uniqid());
        $title = $this->prop('title', 'System Error');
        $message = $this->prop('message', 'An unexpected error occurred.');
        $details = $this->prop('details', '');
        $autoShow = $this->prop('autoShow', false);

        $html = '';

        if ($autoShow) {
            $html .= '<script>document.addEventListener("DOMContentLoaded",function(){openModal("' . $this->e($id) . '");});</script>';
        }

        $html .= '<div id="' . $this->e($id) . '" class="fixed inset-0 z-[9998] hidden overflow-y-auto" role="dialog" aria-modal="true">';
        $html .= '<div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">';
        $html .= '<div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal(\'' . $this->e($id) . '\')"></div>';
        $html .= '<div class="relative inline-block bg-white rounded-2xl shadow-xl text-left overflow-hidden transform transition-all max-w-2xl w-full my-8">';

        $html .= '<div class="px-6 py-4 bg-red-50 border-b border-red-200 flex items-center justify-between">';
        $html .= '<div class="flex items-center gap-3">';
        $html .= '<div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i></div>';
        $html .= '<h3 class="text-lg font-bold text-red-800">' . $this->e($title) . '</h3>';
        $html .= '</div>';
        $html .= '<button onclick="closeModal(\'' . $id . '\')" class="text-red-400 hover:text-red-600 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>';
        $html .= '</div>';

        $html .= '<div class="px-6 py-4 space-y-3">';
        $html .= '<div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-200">';
        $html .= '<i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>';
        $html .= '<p class="text-sm text-red-700">' . $this->e($message) . '</p>';
        $html .= '</div>';

        if ($details) {
            $html .= '<div class="mt-3">';
            $html .= '<details class="group">';
            $html .= '<summary class="text-sm text-gray-500 cursor-pointer hover:text-gray-700 font-medium"><i class="fa-solid fa-chevron-right mr-1 group-open:rotate-90 transition-transform"></i> Technical Details</summary>';
            $html .= '<pre class="mt-2 p-3 bg-gray-900 text-gray-300 text-xs rounded-lg overflow-x-auto max-h-48">' . $this->e($details) . '</pre>';
            $html .= '</details>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '<div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">';
        $html .= '<button onclick="closeModal(\'' . $id . '\')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Close</button>';
        $html .= '</div>';
        $html .= '</div></div></div>';

        return $html;
    }
}