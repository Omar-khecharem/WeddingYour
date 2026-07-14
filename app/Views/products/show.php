<?php
$breadcrumb = [
    ['label' => 'Accueil', 'url' => route('home')],
    ['label' => $product['category_name'] ?? 'Produits', 'url' => route('category', ['slug' => $product['category_slug'] ?? ''])],
    ['label' => e($product['name']), 'url' => '']
];
?>

<?php component('Breadcrumb', ['items' => $breadcrumb]); ?>

<!-- Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "<?= e($product['name']) ?>",
    "image": "<?= isset($product['image']) ? uploadUrl($product['image']) : '' ?>",
    "description": "<?= e(strip_tags($product['short_description'] ?? $product['description'])) ?>",
    "sku": "<?= e($product['sku']) ?>",
    "mpn": "<?= e($product['sku']) ?>",
    "brand": {
        "@type": "Brand",
        "name": "<?= e($product['brand_name'] ?? '') ?>"
    },
    <?php if (($product['sale_price'] ?? null) && $product['regular_price'] > 0): ?>
    "offers": {
        "@type": "Offer",
        "url": "<?= route('product', ['slug' => $product['slug']]) ?>",
        "priceCurrency": "EUR",
        "price": "<?= $product['sale_price'] ?>",
        "priceValidUntil": "<?= date('Y-12-31', strtotime('+1 year')) ?>",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "<?= $product['stock_status'] === 'instock' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>"
    },
    <?php else: ?>
    "offers": {
        "@type": "Offer",
        "url": "<?= route('product', ['slug' => $product['slug']]) ?>",
        "priceCurrency": "EUR",
        "price": "<?= $product['regular_price'] ?>",
        "priceValidUntil": "<?= date('Y-12-31', strtotime('+1 year')) ?>",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "<?= $product['stock_status'] === 'instock' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>"
    },
    <?php endif; ?>
    <?php if ($product['rating_avg'] > 0): ?>
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?= number_format($product['rating_avg'], 1) ?>",
        "reviewCount": "<?= $product['rating_count'] ?>"
    },
    <?php endif; ?>
    <?php if (!empty($reviews)): ?>
    "review": [
        <?php foreach ($reviews as $i => $review): ?>
        {
            "@type": "Review",
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "<?= $review['rating'] ?>"
            },
            "author": {
                "@type": "Person",
                "name": "<?= e($review['name']) ?>"
            },
            "datePublished": "<?= $review['created_at'] ?>",
            "description": "<?= e(strip_tags($review['comment'])) ?>"
        }<?= $i < count($reviews) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
    <?php endif; ?>
}
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">

        <!-- Image Gallery -->
        <div class="space-y-4">
            <?php
            $images = $product['images'] ?? [];
            if (empty($images) && $product['image']) {
                $images = [['image' => $product['image'], 'alt_text' => $product['name'], 'is_primary' => 1]];
            }
            $primaryImage = null;
            foreach ($images as $img) {
                if (!empty($img['is_primary'])) { $primaryImage = $img; break; }
            }
            if (!$primaryImage && !empty($images[0])) { $primaryImage = $images[0]; }
            ?>
            <div id="mainImageContainer" class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden">
                <img id="mainImage"
                     src="<?= $primaryImage ? uploadUrl($primaryImage['image']) : asset('img/placeholder.jpg') ?>"
                     alt="<?= e($primaryImage['alt_text'] ?? $product['name']) ?>"
                     class="w-full h-full object-center object-cover lg:w-full lg:h-full">
            </div>

            <?php if (count($images) > 1): ?>
            <div class="grid grid-cols-4 gap-3">
                <?php foreach ($images as $img): ?>
                <button type="button"
                        class="thumbnail-btn relative rounded-lg overflow-hidden bg-gray-100 border-2 <?= (!empty($img['is_primary']) || $img === reset($images)) ? 'border-indigo-600' : 'border-transparent' ?> hover:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        data-image="<?= uploadUrl($img['image']) ?>"
                        data-alt="<?= e($img['alt_text'] ?? $product['name']) ?>">
                    <img src="<?= uploadUrl($img['image']) ?>"
                         alt="<?= e($img['alt_text'] ?? $product['name']) ?>"
                         class="w-full h-full object-center object-cover">
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Product Info -->
        <div class="mt-8 lg:mt-0">

            <?php if ($product['brand_name'] ?? null): ?>
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium"><?= e($product['brand_name']) ?></p>
            <?php endif; ?>

            <h1 class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl"><?= e($product['name']) ?></h1>

            <!-- Rating -->
            <div class="mt-3 flex items-center space-x-3">
                <div class="flex items-center">
                    <?php $rating = round($product['rating_avg'] ?? 0); ?>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <svg class="w-5 h-5 <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <?php endfor; ?>
                </div>
                <span class="text-sm text-gray-500">
                    <?= number_format($product['rating_avg'] ?? 0, 1) ?> (<?= $product['rating_count'] ?? 0 ?> avis)
                </span>
            </div>

            <!-- Price -->
            <div class="mt-6">
                <?php if (($product['sale_price'] ?? null) && $product['regular_price'] > $product['sale_price']): ?>
                <div class="flex items-center space-x-3">
                    <span class="text-3xl font-bold text-gray-900"><?= formatPrice($product['sale_price']) ?></span>
                    <span class="text-xl text-gray-400 line-through"><?= formatPrice($product['regular_price']) ?></span>
                    <?php if ($product['discount_percent'] ?? null): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        -<?= (int)$product['discount_percent'] ?>%
                    </span>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <span class="text-3xl font-bold text-gray-900"><?= formatPrice($product['regular_price']) ?></span>
                <?php endif; ?>
            </div>

            <!-- Short Description -->
            <?php if ($product['short_description'] ?? null): ?>
            <div class="mt-4 prose prose-sm text-gray-600">
                <?= $product['short_description'] ?>
            </div>
            <?php endif; ?>

            <!-- Stock Status -->
            <div class="mt-4">
                <?php if ($product['stock_status'] === 'instock'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    En stock
                    <?php if ($product['stock_quantity'] > 0 && $product['stock_quantity'] <= 10): ?>
                    <span class="ml-1">(<?= $product['stock_quantity'] ?> restants)</span>
                    <?php endif; ?>
                </span>
                <?php elseif ($product['stock_status'] === 'outofstock'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Rupture de stock
                </span>
                <?php elseif ($product['stock_status'] === 'onbackorder'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Précommande
                </span>
                <?php endif; ?>
            </div>

            <!-- SKU & Category -->
            <div class="mt-4 space-y-2 text-sm text-gray-500">
                <p><span class="font-medium text-gray-700">SKU :</span> <?= e($product['sku']) ?></p>
                <?php if ($product['category_name'] ?? null): ?>
                <p>
                    <span class="font-medium text-gray-700">Catégorie :</span>
                    <a href="<?= route('category', ['slug' => $product['category_slug']]) ?>" class="text-indigo-600 hover:text-indigo-500">
                        <?= e($product['category_name']) ?>
                    </a>
                </p>
                <?php endif; ?>
                <?php if ($product['brand_name'] ?? null): ?>
                <p><span class="font-medium text-gray-700">Marque :</span> <?= e($product['brand_name']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Variants -->
            <?php if (!empty($product['variants'])): ?>
            <div class="mt-6 space-y-4">
                <?php foreach ($product['variants'] as $variant): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700"><?= e($variant['name'] ?? 'Option') ?></label>
                    <div class="mt-1 flex flex-wrap gap-2">
                        <?php foreach ($variant['values'] ?? [] as $val): ?>
                        <button type="button"
                                class="variant-btn inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <?= e($val['label'] ?? $val) ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Quantity & Add to Cart -->
            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                <div class="flex items-center border border-gray-300 rounded-md">
                    <button type="button" id="qtyMinus" class="p-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </button>
                    <input type="number" id="qtyInput" value="1" min="1" max="999"
                           class="w-16 text-center border-0 focus:ring-0 text-gray-900 font-medium [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    <button type="button" id="qtyPlus" class="p-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>

                <button type="submit" id="addToCartBtn"
                        class="flex-1 inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        <?= $product['stock_status'] !== 'instock' ? 'disabled' : '' ?>>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Ajouter au panier
                </button>
            </div>

            <!-- Wishlist & Compare -->
            <div class="mt-4 flex space-x-4">
                <button type="button" id="addToWishlistBtn"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Ajouter aux favoris
                </button>
                <button type="button" id="addToCompareBtn"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Comparer
                </button>
            </div>

            <!-- Tags -->
            <?php if (!empty($product['tags'])): ?>
            <div class="mt-6 flex flex-wrap gap-2">
                <?php foreach ($product['tags'] as $tag): ?>
                <a href="<?= route('tag', ['slug' => $tag['slug'] ?? $tag]) ?>"
                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <?= e($tag['name'] ?? (is_string($tag) ? $tag : '')) ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Product Tabs -->
    <div class="mt-16">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" data-tab="description"
                        class="tab-btn text-indigo-600 border-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Description
                </button>
                <button type="button" data-tab="reviews"
                        class="tab-btn text-gray-500 border-transparent hover:text-gray-700 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Avis (<?= $product['rating_count'] ?? 0 ?>)
                </button>
                <button type="button" data-tab="shipping"
                        class="tab-btn text-gray-500 border-transparent hover:text-gray-700 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Livraison
                </button>
            </nav>
        </div>

        <!-- Tab: Description -->
        <div id="tab-description" class="tab-content mt-6">
            <div class="prose prose-sm sm:prose max-w-none text-gray-600">
                <?= $product['description'] ?>
            </div>
        </div>

        <!-- Tab: Reviews -->
        <div id="tab-reviews" class="tab-content hidden mt-6">
            <%-- Rating Summary --%>
            <?php if ($ratingStats): ?>
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="text-center sm:text-left">
                        <p class="text-4xl font-bold text-gray-900"><?= number_format($ratingStats['average'] ?? $product['rating_avg'], 1) ?></p>
                        <div class="flex items-center justify-center sm:justify-start mt-1">
                            <?php $avg = round($ratingStats['average'] ?? $product['rating_avg'] ?? 0); ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <svg class="w-4 h-4 <?= $i <= $avg ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Basé sur <?= $ratingStats['total'] ?? $product['rating_count'] ?> avis</p>
                    </div>
                    <?php if (!empty($ratingStats['distribution'])): ?>
                    <div class="mt-4 sm:mt-0 flex-1 max-w-xs ml-0 sm:ml-8 space-y-1">
                        <?php for ($star = 5; $star >= 1; $star--): ?>
                        <?php $count = $ratingStats['distribution'][$star] ?? 0; ?>
                        <?php $total = $ratingStats['total'] ?? 1; ?>
                        <?php $pct = $total > 0 ? round(($count / $total) * 100) : 0; ?>
                        <div class="flex items-center text-sm">
                            <span class="w-12 text-gray-600"><?= $star ?> étoile<?= $star > 1 ? 's' : '' ?></span>
                            <div class="flex-1 mx-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: <?= $pct ?>%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-500"><?= $count ?></span>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <%-- Reviews List --%>
            <?php if (!empty($reviews)): ?>
            <div class="space-y-8">
                <?php foreach ($reviews as $review): ?>
                <div class="border-b border-gray-200 pb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-indigo-600"><?= strtoupper(substr($review['name'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?= e($review['name']) ?></p>
                                <div class="flex items-center space-x-2">
                                    <div class="flex">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <svg class="w-4 h-4 <?= $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <?php endfor; ?>
                                    </div>
                                    <?php if ($review['is_verified'] ?? false): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Achat vérifié
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <time class="text-sm text-gray-500"><?= date('d/m/Y', strtotime($review['created_at'])) ?></time>
                    </div>
                    <?php if ($review['title'] ?? null): ?>
                    <p class="mt-3 text-sm font-medium text-gray-900"><?= e($review['title']) ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-600"><?= nl2br(e($review['comment'])) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-gray-500 text-sm">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
            <?php endif; ?>
        </div>

        <!-- Tab: Shipping -->
        <div id="tab-shipping" class="tab-content hidden mt-6">
            <div class="prose prose-sm max-w-none text-gray-600">
                <h3 class="text-lg font-medium text-gray-900">Livraison standard</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Livraison offerte dès 50 € d'achat</li>
                    <li>Délai de livraison : 3 à 5 jours ouvrés</li>
                    <li>Livraison en France métropolitaine et en Belgique</li>
                </ul>
                <h3 class="text-lg font-medium text-gray-900 mt-6">Livraison express</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Livraison en 24h chrono : 9,90 €</li>
                    <li>Commandé avant 14h, livré le lendemain avant 18h</li>
                </ul>
                <h3 class="text-lg font-medium text-gray-900 mt-6">Retours</h3>
                <p>Vous disposez d'un délai de 30 jours à compter de la réception de votre commande pour retourner un article. Les articles doivent être retournés dans leur état d'origine, non portés et avec leurs étiquettes.</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Vous aimerez aussi</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($relatedProducts as $p): ?>
            <?php component('ProductCard', ['product' => $p]); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
(function() {
    // Thumbnail switching
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    thumbnails.forEach(btn => {
        btn.addEventListener('click', function() {
            thumbnails.forEach(b => b.classList.replace('border-indigo-600', 'border-transparent'));
            this.classList.replace('border-transparent', 'border-indigo-600');
            mainImage.src = this.dataset.image;
            mainImage.alt = this.dataset.alt;
        });
    });

    // Quantity controls
    const qtyInput = document.getElementById('qtyInput');
    document.getElementById('qtyMinus').addEventListener('click', function() {
        const val = parseInt(qtyInput.value) || 1;
        if (val > 1) qtyInput.value = val - 1;
    });
    document.getElementById('qtyPlus').addEventListener('click', function() {
        const val = parseInt(qtyInput.value) || 1;
        if (val < 999) qtyInput.value = val + 1;
    });

    // Tabs
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = {};

    tabs.forEach(btn => {
        const tab = btn.dataset.tab;
        contents[tab] = document.getElementById('tab-' + tab);
        btn.addEventListener('click', function() {
            tabs.forEach(b => {
                b.classList.replace('text-indigo-600', 'text-gray-500');
                b.classList.replace('border-indigo-600', 'border-transparent');
            });
            this.classList.replace('text-gray-500', 'text-indigo-600');
            this.classList.replace('border-transparent', 'border-indigo-600');

            Object.values(contents).forEach(el => el.classList.add('hidden'));
            contents[tab].classList.remove('hidden');
        });
    });

    // Variant selection
    document.querySelectorAll('.variant-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.closest('.space-y-4');
            const siblings = parent.querySelectorAll('.variant-btn');
            siblings.forEach(b => {
                b.classList.remove('ring-2', 'ring-indigo-500', 'border-indigo-500');
                b.classList.add('border-gray-300');
            });
            this.classList.add('ring-2', 'ring-indigo-500', 'border-indigo-500');
            this.classList.remove('border-gray-300');
        });
    });
})();
</script>
