<?php
/**
 * MemoriesBar Component
 * 
 * Full-width decorative banner between sections.
 * Text comes from MySQL settings.
 *
 * @package App\Components
 */

namespace App\Components;

class MemoriesBar extends Component
{
    protected function fetchData(): array
    {
        return ['text' => $this->setting('memories_bar_text', 'Have Some Memories!')];
    }

    public function render(): string
    {
        return '<div class="bg-primary-red text-white text-center py-6 px-4 text-2xl md:text-3xl font-extrabold uppercase tracking-wider font-playfair">' . $this->e($this->getData('text')) . '</div>';
    }
}
