<?php
$product = $product ?? null;
$categories = $categories ?? [];
$subcategories = $subcategories ?? [];
$brands = $brands ?? [];
$isEdit = !empty($product);
$pageTitle = $isEdit ? 'Modifier le produit' : 'Ajouter un produit';
?>
<div class="flex h-screen overflow-hidden bg-gray-50">
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto hidden lg:block">
        <div class="p-5 border-b border-gray-200">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-red flex items-center justify-center text-white font-bold text-sm">A</div>
                <div><span class="font-bold text-gray-800 text-sm">Administration</span><p class="text-xs text-gray-400">Panneau de contrôle</p></div>
            </a>
        </div>
        <nav class="p-4 space-y-1">
            <a href="<?= url('admin') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-chart-pie w-5 text-center"></i> Tableau de bord</a>
            <a href="<?= url('admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-box w-5 text-center"></i> Produits</a>
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-truck w-5 text-center"></i> Commandes</a>
            <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-users w-5 text-center"></i> Clients</a>
            <a href="<?= url('admin/reviews') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-star w-5 text-center"></i> Avis</a>
            <a href="<?= url('admin/coupons') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-tag w-5 text-center"></i> Coupons</a>
            <a href="<?= url('admin/pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-file w-5 text-center"></i> Pages</a>
            <hr class="my-3 border-gray-200">
            <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-gear w-5 text-center"></i> Paramètres</a>
            <a href="<?= url('admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-list w-5 text-center"></i> Logs</a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-[1400px] mx-auto py-6 px-4 lg:px-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="<?= url('admin/products') ?>" class="text-sm text-gray-500 hover:text-primary-red transition-colors mb-1 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Retour aux produits</a>
                    <h1 class="text-2xl font-bold text-gray-800"><?= $pageTitle ?></h1>
                </div>
                <?php if ($isEdit): ?>
                <a href="<?= url('products/' . e($product['slug'] ?? $product['id'])) ?>" target="_blank" class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors"><i class="fa-solid fa-external-link mr-1.5"></i> Voir sur le site</a>
                <?php endif; ?>
            </div>
            <form method="POST" action="<?= $isEdit ? url('admin/products/' . e($product['id']) . '/update') : url('admin/products/store') ?>" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informations générales</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="<?= e(old('name', $product['name'] ?? '')) ?>" id="product-name" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                                <input type="text" name="slug" value="<?= e(old('slug', $product['slug'] ?? '')) ?>" id="product-slug" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                                <p class="text-xs text-gray-400 mt-1">Généré automatiquement à partir du nom</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
                                    <input type="text" name="sku" value="<?= e(old('sku', $product['sku'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                                    <select name="brand_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                        <option value="">Sélectionner une marque</option>
                                        <?php foreach ($brands as $brand): ?>
                                        <option value="<?= e($brand['id'] ?? $brand) ?>" <?= (old('brand_id', $product['brand_id'] ?? '') == ($brand['id'] ?? $brand)) ? 'selected' : '' ?>><?= e($brand['name'] ?? $brand) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description courte</label>
                                <textarea name="short_description" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none"><?= e(old('short_description', $product['short_description'] ?? '')) ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" id="product-description"><?= e(old('description', $product['description'] ?? '')) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Prix et stock</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix régulier <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><?= APP_CURRENCY ?></span>
                                    <input type="number" step="0.01" name="regular_price" value="<?= e(old('regular_price', $product['regular_price'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix promo</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"><?= APP_CURRENCY ?></span>
                                    <input type="number" step="0.01" name="sale_price" value="<?= e(old('sale_price', $product['sale_price'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantité en stock</label>
                                <input type="number" name="stock_quantity" value="<?= e(old('stock_quantity', $product['stock_quantity'] ?? 0)) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut du stock</label>
                                <select name="stock_status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <option value="in_stock" <?= (old('stock_status', $product['stock_status'] ?? '') === 'in_stock') ? 'selected' : '' ?>>En stock</option>
                                    <option value="out_of_stock" <?= (old('stock_status', $product['stock_status'] ?? '') === 'out_of_stock') ? 'selected' : '' ?>>Épuisé</option>
                                    <option value="on_backorder" <?= (old('stock_status', $product['stock_status'] ?? '') === 'on_backorder') ? 'selected' : '' ?>>Sur commande</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <option value="active" <?= (old('status', $product['status'] ?? '') === 'active') ? 'selected' : '' ?>>Actif</option>
                                    <option value="draft" <?= (old('status', $product['status'] ?? '') === 'draft') ? 'selected' : '' ?>>Brouillon</option>
                                    <option value="inactive" <?= (old('status', $product['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Expédition</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                                <input type="number" step="0.01" name="weight" value="<?= e(old('weight', $product['weight'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dimensions (L x l x H cm)</label>
                                <input type="text" name="dimensions" value="<?= e(old('dimensions', $product['dimensions'] ?? '')) ?>" placeholder="10 x 15 x 5" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Référencement (SEO)</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta titre</label>
                                <input type="text" name="meta_title" value="<?= e(old('meta_title', $product['meta_title'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta description</label>
                                <textarea name="meta_description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none"><?= e(old('meta_description', $product['meta_description'] ?? '')) ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mots-clés</label>
                                <input type="text" name="meta_keywords" value="<?= e(old('meta_keywords', $product['meta_keywords'] ?? '')) ?>" placeholder="mot-clé1, mot-clé2, mot-clé3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Catégorisation</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= e($cat['id'] ?? $cat) ?>" <?= (old('category_id', $product['category_id'] ?? '') == ($cat['id'] ?? $cat)) ? 'selected' : '' ?>><?= e($cat['name'] ?? $cat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sous-catégorie</label>
                                <select name="subcategory_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <option value="">Sélectionner une sous-catégorie</option>
                                    <?php foreach ($subcategories as $sub): ?>
                                    <option value="<?= e($sub['id'] ?? $sub) ?>" <?= (old('subcategory_id', $product['subcategory_id'] ?? '') == ($sub['id'] ?? $sub)) ? 'selected' : '' ?>><?= e($sub['name'] ?? $sub) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Image du produit</h2>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image principale</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-red transition-colors cursor-pointer" onclick="document.getElementById('product-image').click()">
                                <?php if ($isEdit && !empty($product['image'])): ?>
                                <img src="<?= asset('images/' . e($product['image'])) ?>" alt="<?= e($product['name']) ?>" class="max-h-40 mx-auto mb-3 rounded-lg">
                                <?php else: ?>
                                <i class="fa-solid fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                                <?php endif; ?>
                                <p class="text-sm text-gray-500">Cliquez pour télécharger une image</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WebP (max 2 Mo)</p>
                            </div>
                            <input type="file" name="image" id="product-image" accept="image/png,image/jpeg,image/webp" class="hidden" onchange="previewImage(this)">
                            <?php if ($isEdit && !empty($product['image'])): ?>
                            <div class="mt-2 flex items-center gap-2">
                                <input type="checkbox" name="remove_image" id="remove-image" value="1">
                                <label for="remove-image" class="text-sm text-red-600">Supprimer l'image</label>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Mise en avant</h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" <?= old('is_featured', $product['is_featured'] ?? false) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-red focus:ring-primary-red">
                                <span class="text-sm text-gray-700">Produit vedette</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_new" value="1" <?= old('is_new', $product['is_new'] ?? false) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-red focus:ring-primary-red">
                                <span class="text-sm text-gray-700">Nouveau produit</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_trending" value="1" <?= old('is_trending', $product['is_trending'] ?? false) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-red focus:ring-primary-red">
                                <span class="text-sm text-gray-700">Tendance</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all">
                            <i class="fa-solid fa-save mr-1.5"></i> <?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?>
                        </button>
                        <a href="<?= url('admin/products') ?>" class="border border-gray-300 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
<script>
document.getElementById('product-name')?.addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('product-slug').value = slug;
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = input.parentElement;
            const img = container.querySelector('img') || document.createElement('img');
            img.src = e.target.result;
            img.className = 'max-h-40 mx-auto mb-3 rounded-lg';
            container.insertBefore(img, container.querySelector('p'));
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
