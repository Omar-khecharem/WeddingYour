<?php
/**
 * VideoShowcase Component
 * 
 * Large video showcase section with play button.
 * Background image comes from MySQL settings.
 *
 * @package App\Components
 */

namespace App\Components;

class VideoShowcase extends Component
{
    protected function fetchData(): array
    {
        return [
            'bg_image' => $this->setting('video_showcase_bg', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1200'),
        ];
    }

    public static function css(): string
    {
        return '.video-showcase .play-btn{width:80px;height:80px;font-size:32px}';
    }

    public function render(): string
    {
        $bg = $this->e($this->getData('bg_image'));
        return '
<section class="max-w-[1200px] mx-auto my-10 px-4">
    <div class="rounded-2xl overflow-hidden shadow-xl relative h-[380px] bg-cover bg-center flex items-center justify-center video-showcase" style="background:linear-gradient(rgba(0,0,0,.15),rgba(0,0,0,.4)),url(' . $bg . ')">
        <div class="play-btn w-20 h-20 text-3xl"><i class="fa-solid fa-play"></i></div>
    </div>
</section>';
    }
}
