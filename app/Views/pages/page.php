<div class="max-w-5xl mx-auto px-4 py-12">
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
        <span>/</span>
        <span class="text-gray-800 font-medium"><?= e($page['title'] ?? '') ?></span>
    </nav>
    <h1 class="text-3xl font-black text-gray-900 mb-6"><?= e($page['title'] ?? '') ?></h1>
    <div class="prose prose-gray max-w-none">
        <?= $page['content'] ?? '<p class="text-gray-400">No content.</p>' ?>
    </div>
</div>
