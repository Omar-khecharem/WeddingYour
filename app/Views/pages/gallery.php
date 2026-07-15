<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Gallery</span>
    </nav>

    <h1 class="text-3xl font-black text-gray-800 mb-8">Our Gallery</h1>

    <?php if (!empty($galleryItems)): ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($galleryItems as $item): ?>
        <div class="rounded-xl overflow-hidden border border-gray-200 group">
            <img src="<?= uploadUrl($item['image'], 'gallery') ?>" alt="<?= e($item['title'] ?? 'Gallery') ?>" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            <?php if (!empty($item['title'])): ?>
            <div class="p-3">
                <h3 class="text-sm font-semibold text-gray-800"><?= e($item['title']) ?></h3>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
        <p class="text-gray-400 text-sm">No gallery images available yet.</p>
    </div>
    <?php endif; ?>
</div>
