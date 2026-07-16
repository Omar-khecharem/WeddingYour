<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
        <span>/</span>
        <a href="<?= url('blog') ?>" class="hover:text-red-600">Blog</a>
        <span>/</span>
        <span class="text-gray-800 font-medium"><?= e($post['title'] ?? '') ?></span>
    </nav>

    <article>
        <?php if (!empty($post['featured_image'])): ?>
        <img src="<?= uploadUrl($post['featured_image'], 'blogs') ?>" alt="<?= e($post['title'] ?? '') ?>" class="w-full h-64 sm:h-96 object-cover rounded-xl mb-8" loading="lazy">
        <?php endif; ?>

        <div class="flex items-center gap-3 mb-4">
            <?php if (!empty($post['category_name'])): ?>
            <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700">
                <?= e($post['category_name']) ?>
            </span>
            <?php endif; ?>
            <span class="text-xs text-gray-400">
                <?= !empty($post['published_at']) ? formatDate($post['published_at'], 'd M Y') : '' ?>
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 mb-6"><?= e($post['title'] ?? '') ?></h1>

        <?php if (!empty($post['excerpt'])): ?>
        <p class="text-lg text-gray-600 mb-6 leading-relaxed"><?= e($post['excerpt']) ?></p>
        <?php endif; ?>

        <div class="prose prose-gray max-w-none">
            <?= $post['content'] ?? '' ?>
        </div>
    </article>

    <div class="mt-10 pt-6 border-t border-gray-200">
        <a href="<?= url('blog') ?>" class="text-sm font-semibold text-primary-red hover:text-primary-red/80 transition-colors">
            &larr; Back to Blog
        </a>
    </div>
</div>
