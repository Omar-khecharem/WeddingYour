<div class="max-w-5xl mx-auto px-4 py-12">
    <nav class="flex items-center text-xs sm:text-sm text-premium-taupe mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-premium-burgundy transition-colors">Home</a>
        <span>/</span>
        <span class="text-premium-charcoal font-medium"><?= e($page['title'] ?? '') ?></span>
    </nav>
    <h1 class="heading-serif text-4xl sm:text-5xl text-premium-charcoal mb-6"><?= e($page['title'] ?? '') ?></h1>
    <div class="prose prose-gray max-w-none text-premium-mink">
        <?= $page['content'] ?? '<p class="text-premium-taupe">No content.</p>' ?>
    </div>
</div>
