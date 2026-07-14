<?php
/**
 * Liste d'envies
 *
 * Variables :
 *   $wishlist – tableau de produits (id, name, slug, image, regular_price, sale_price, discount_percent)
 */

$wishlist = $wishlist ?? [];
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'Mon compte', 'url' => url('account')],
    ['label' => 'Ma liste d\'envies', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-heart"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Ma liste d'envies</h1>
            <p class="text-sm text-gray-500">Retrouvez tous vos produits favoris</p>
        </div>
    </div>

    <?php if (empty($wishlist)): ?>
    <div class="text-center py-16">
        <div class="text-5xl text-gray-300 mb-5">
            <i class="fa-regular fa-heart"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-700 mb-2">Votre liste d'envies est vide</h2>
        <p class="text-sm text-gray-500 mb-6">Parcourez notre catalogue et ajoutez vos articles préférés.</p>
        <a href="<?= url('products') ?>" class="maroon-btn">
            <i class="fa-solid fa-bag-shopping mr-1.5"></i> Découvrir nos produits
        </a>
    </div>
    <?php else: ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach ($wishlist as $item): ?>
        <div class="relative group">
            <?= component('ProductCard', ['product' => $item]) ?>
            <form method="POST" action="<?= url('wishlist/remove') ?>" class="absolute top-2 left-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                <?= \App\Helpers\Security::csrfField() ?>
                <input type="hidden" name="product_id" value="<?= (int)($item['id'] ?? 0) ?>">
                <button type="submit" class="w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-red-500 hover:bg-red-50 transition-all"
                        title="Retirer de la liste">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</div>

<?php endSection() ?>
