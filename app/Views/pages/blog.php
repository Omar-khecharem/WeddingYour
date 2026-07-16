<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Blog</span>
    </nav>

    <h1 class="text-3xl font-black text-gray-800 mb-8">Our Blog</h1>

    <?php if (!empty($posts)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($posts as $post): ?>
        <article class="rounded-xl border border-gray-200 overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow">
            <?php if (!empty($post['featured_image'])): ?>
            <img src="<?= uploadUrl($post['featured_image'], 'blogs') ?>" alt="<?= e($post['title'] ?? '') ?>" class="w-full h-48 object-cover" loading="lazy">
            <?php else: ?>
            <div class="w-full h-48 bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-red-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <?php endif; ?>
            <div class="p-5">
                <?php if (!empty($post['category_name'])): ?>
                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700 mb-3">
                    <?= e($post['category_name']) ?>
                </span>
                <?php endif; ?>
                <h2 class="text-lg font-bold text-gray-900 mb-2"><?= e($post['title'] ?? '') ?></h2>
                <p class="text-sm text-gray-500 mb-4"><?= e($post['excerpt'] ?? '') ?></p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-400">
                        <?= !empty($post['published_at']) ? formatDate($post['published_at'], 'd M Y') : '' ?>
                    </span>
                    <a href="<?= url('blog/' . e($post['slug'] ?? '')) ?>" class="text-sm font-semibold text-primary-red hover:text-primary-red/80 transition-colors">
                        Read More &rarr;
                    </a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
        <p class="text-gray-400 text-sm">No blog posts available yet.</p>
    </div>
    <?php endif; ?>
</div>
