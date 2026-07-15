<?php
$coupons = $coupons ?? [];
$showForm = $_GET['action'] ?? '';
$editCoupon = $editCoupon ?? null;
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Coupons</h1>
                    <p class="text-sm text-gray-500">Gérez vos codes promotionnels</p>
                </div>
                <a href="<?= url('admin/coupons?action=create') ?>" class="bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Ajouter un coupon
                </a>
            </div>
            <?php if ($showForm === 'create' || $editCoupon): ?>
            <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4"><?= $editCoupon ? 'Modifier le coupon' : 'Nouveau coupon' ?></h2>
                <form method="POST" action="<?= $editCoupon ? url('admin/coupons/' . e($editCoupon['id']) . '/update') : url('admin/coupons/store') ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="<?= e(old('code', $editCoupon['code'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                            <option value="fixed" <?= (old('type', $editCoupon['type'] ?? '') === 'fixed') ? 'selected' : '' ?>>Montant fixe</option>
                            <option value="percentage" <?= (old('type', $editCoupon['type'] ?? '') === 'percentage') ? 'selected' : '' ?>>Pourcentage</option>
                            <option value="free_shipping" <?= (old('type', $editCoupon['type'] ?? '') === 'free_shipping') ? 'selected' : '' ?>>Livraison gratuite</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Valeur <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="value" value="<?= e(old('value', $editCoupon['value'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Montant minimum</label>
                        <input type="number" step="0.01" name="min_amount" value="<?= e(old('min_amount', $editCoupon['min_amount'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" name="start_date" value="<?= e(old('start_date', $editCoupon['start_date'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
                        <input type="date" name="expiry_date" value="<?= e(old('expiry_date', $editCoupon['expiry_date'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Limite d'utilisation</label>
                        <input type="number" name="usage_limit" value="<?= e(old('usage_limit', $editCoupon['usage_limit'] ?? '')) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                            <option value="active" <?= (old('status', $editCoupon['status'] ?? '') === 'active') ? 'selected' : '' ?>>Actif</option>
                            <option value="inactive" <?= (old('status', $editCoupon['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 lg:col-span-3 flex gap-3 pt-2">
                        <button type="submit" class="bg-primary-red text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all">
                            <i class="fa-solid fa-save mr-1.5"></i> <?= $editCoupon ? 'Mettre à jour' : 'Créer le coupon' ?>
                        </button>
                        <a href="<?= url('admin/coupons') ?>" class="border border-gray-300 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">Annuler</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Code</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Type</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Valeur</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Montant min.</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Utilisations</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Début</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Expiration</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Statut</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($coupons)): ?>
                            <tr>
                                <td colspan="9" class="px-5 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-tag text-3xl mb-2 block text-gray-300"></i>
                                    Aucun coupon trouvé
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($coupons as $coupon): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <span class="font-mono font-bold text-primary-red"><?= e($coupon['code']) ?></span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    <?php if (($coupon['type'] ?? '') === 'fixed'): ?>
                                    Montant fixe
                                    <?php elseif (($coupon['type'] ?? '') === 'percentage'): ?>
                                    Pourcentage
                                    <?php elseif (($coupon['type'] ?? '') === 'free_shipping'): ?>
                                    Livraison gratuite
                                    <?php else: ?>
                                    <?= e($coupon['type'] ?? 'N/A') ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 font-medium text-gray-800">
                                    <?php if (($coupon['type'] ?? '') === 'percentage'): ?>
                                    <?= $coupon['value'] ?>%
                                    <?php else: ?>
                                    <?= formatPrice($coupon['value'] ?? 0) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 text-gray-500"><?= $coupon['min_amount'] ? formatPrice($coupon['min_amount']) : '-' ?></td>
                                <td class="px-5 py-3 text-gray-500"><?= $coupon['used_count'] ?? 0 ?><?= $coupon['usage_limit'] ? ' / ' . $coupon['usage_limit'] : '' ?></td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap"><?= $coupon['start_date'] ? formatDate($coupon['start_date']) : '-' ?></td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap"><?= $coupon['expiry_date'] ? formatDate($coupon['expiry_date']) : '-' ?></td>
                                <td class="px-5 py-3">
                                    <?php if (($coupon['status'] ?? '') === 'active'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="<?= url('admin/coupons?action=edit&id=' . e($coupon['id'])) ?>" class="p-1.5 text-gray-400 hover:text-primary-red transition-colors" title="Modifier"><i class="fa-solid fa-pen"></i></a>
                                        <button onclick="confirmDelete(<?= e($coupon['id']) ?>)" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php startSection('scripts') ?>
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?')) {
        window.location.href = '<?= url('admin/coupons') ?>/' + id + '/delete';
    }
}
</script>
<?php endSection() ?>
