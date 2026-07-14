<?php
/**
 * Gestion des adresses
 *
 * Variables :
 *   $addresses – tableau d'adresses existantes
 *   $countries – tableau de pays (id, name)
 */

$addresses = $addresses ?? [];
$countries = $countries ?? [];

$typeLabels = [
    'billing'  => 'Facturation',
    'shipping' => 'Livraison',
    'both'     => 'Facturation et livraison',
];

$typeColors = [
    'billing'  => 'bg-blue-100 text-blue-700',
    'shipping' => 'bg-green-100 text-green-700',
    'both'     => 'bg-purple-100 text-purple-700',
];
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'Mon compte', 'url' => url('account')],
    ['label' => 'Mes adresses', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Mes adresses</h1>
                <p class="text-sm text-gray-500">Gérez vos adresses de facturation et de livraison</p>
            </div>
        </div>
        <button type="button" onclick="toggleAddressForm()"
                class="maroon-btn inline-flex items-center gap-2 text-sm whitespace-nowrap">
            <i class="fa-solid fa-plus"></i> Ajouter une adresse
        </button>
    </div>

    <?= error() ?>

    <!-- Formulaire Add / Edit -->
    <div id="address-form-container" class="hidden mb-8">
        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-gray-900" id="address-form-title">Nouvelle adresse</h2>
                <button type="button" onclick="toggleAddressForm()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form method="POST" action="<?= url('account/addresses/save') ?>" class="space-y-5">
                <?= \App\Helpers\Security::csrfField() ?>
                <input type="hidden" name="address_id" id="address_id" value="">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Libellé</label>
                        <input type="text" name="label" id="field_label"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="Ex : Domicile, Bureau">
                        <?= error('label') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nom complet</label>
                        <input type="text" name="full_name" id="field_full_name"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('full_name') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" name="phone" id="field_phone"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('phone') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pays</label>
                        <select name="country_id" id="field_country"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all bg-white">
                            <option value="">Sélectionner un pays</option>
                            <?php foreach ($countries as $country): ?>
                            <option value="<?= (int)($country['id'] ?? 0) ?>">
                                <?= e($country['name'] ?? '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('country_id') ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse</label>
                        <input type="text" name="address_line1" id="field_address_line1"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="Numéro et nom de rue">
                        <?= error('address_line1') ?>
                    </div>
                    <div class="sm:col-span-2">
                        <input type="text" name="address_line2" id="field_address_line2"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="Appartement, étage, etc. (optionnel)">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ville</label>
                        <input type="text" name="city" id="field_city"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('city') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">État / Région</label>
                        <input type="text" name="state" id="field_state"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('state') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Code postal</label>
                        <input type="text" name="postal_code" id="field_postal_code"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('postal_code') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Type d'adresse</label>
                        <select name="type" id="field_type"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all bg-white">
                            <option value="billing">Facturation</option>
                            <option value="shipping">Livraison</option>
                            <option value="both" selected>Facturation et livraison</option>
                        </select>
                        <?= error('type') ?>
                    </div>
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_default" value="1" id="field_is_default"
                           class="rounded border-gray-300 text-primary-red focus:ring-primary-red">
                    <span class="text-sm text-gray-700">Définir comme adresse par défaut</span>
                </label>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                    </button>
                    <button type="button" onclick="toggleAddressForm()"
                            class="px-5 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des adresses -->
    <?php if (empty($addresses)): ?>
    <div class="text-center py-16">
        <div class="text-5xl text-gray-300 mb-5">
            <i class="fa-solid fa-map-pin"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-700 mb-2">Aucune adresse enregistrée</h2>
        <p class="text-sm text-gray-500 mb-6">Ajoutez une adresse pour faciliter vos achats.</p>
        <button onclick="toggleAddressForm()" class="maroon-btn">
            <i class="fa-solid fa-plus mr-1.5"></i> Ajouter une adresse
        </button>
    </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($addresses as $addr): ?>
        <div class="relative border border-gray-200 rounded-xl p-5 hover:border-primary-red/30 transition-all <?= !empty($addr['is_default']) ? 'border-primary-red/50 bg-primary-red/[0.02]' : '' ?>">
            <?php if (!empty($addr['is_default'])): ?>
            <span class="absolute top-3 right-3 bg-primary-red text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                Par défaut
            </span>
            <?php endif; ?>

            <?php if (!empty($addr['label'])): ?>
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-bold px-2 py-0.5 rounded-full <?= $typeColors[$addr['type']] ?? 'bg-gray-100 text-gray-600' ?>">
                    <?= $typeLabels[$addr['type']] ?? e($addr['type']) ?>
                </span>
                <span class="text-sm font-bold text-gray-900"><?= e($addr['label']) ?></span>
            </div>
            <?php endif; ?>

            <div class="text-sm text-gray-600 space-y-0.5">
                <p class="font-semibold text-gray-900"><?= e($addr['full_name'] ?? '') ?></p>
                <p><?= e($addr['phone'] ?? '') ?></p>
                <p class="mt-1"><?= e($addr['address_line1'] ?? '') ?></p>
                <?php if (!empty($addr['address_line2'])): ?>
                <p><?= e($addr['address_line2']) ?></p>
                <?php endif; ?>
                <p>
                    <?= e($addr['city'] ?? '') ?>
                    <?php if (!empty($addr['state'])): ?>, <?= e($addr['state']) ?><?php endif; ?>
                    <?php if (!empty($addr['postal_code'])): ?> <?= e($addr['postal_code']) ?><?php endif; ?>
                </p>
            </div>

            <div class="flex items-center gap-3 mt-4 pt-3 border-t border-gray-100">
                <button type="button" onclick="editAddress(<?= htmlspecialchars(json_encode($addr)) ?>)"
                        class="text-xs font-semibold text-primary-red hover:text-primary-red/80 transition-colors">
                    <i class="fa-solid fa-pen mr-1"></i> Modifier
                </button>
                <form method="POST" action="<?= url('account/addresses/delete') ?>" class="inline"
                      onsubmit="return confirm('Supprimer cette adresse ?')">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <input type="hidden" name="address_id" value="<?= (int)($addr['id'] ?? 0) ?>">
                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-600 transition-colors">
                        <i class="fa-solid fa-trash-can mr-1"></i> Supprimer
                    </button>
                </form>
                <?php if (empty($addr['is_default'])): ?>
                <form method="POST" action="<?= url('account/addresses/default') ?>" class="inline ml-auto">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <input type="hidden" name="address_id" value="<?= (int)($addr['id'] ?? 0) ?>">
                    <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        Définir par défaut
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</div>

<script>
function toggleAddressForm() {
    var container = document.getElementById('address-form-container');
    container.classList.toggle('hidden');
    if (container.classList.contains('hidden')) {
        resetAddressForm();
    }
}

function resetAddressForm() {
    document.getElementById('address-form-title').textContent = 'Nouvelle adresse';
    document.getElementById('address_id').value = '';
    document.getElementById('field_label').value = '';
    document.getElementById('field_full_name').value = '';
    document.getElementById('field_phone').value = '';
    document.getElementById('field_address_line1').value = '';
    document.getElementById('field_address_line2').value = '';
    document.getElementById('field_city').value = '';
    document.getElementById('field_state').value = '';
    document.getElementById('field_postal_code').value = '';
    document.getElementById('field_type').value = 'both';
    document.getElementById('field_is_default').checked = false;
    document.getElementById('field_country').value = '';
}

function editAddress(addr) {
    document.getElementById('address-form-title').textContent = 'Modifier l\'adresse';
    document.getElementById('address_id').value = addr.id || '';
    document.getElementById('field_label').value = addr.label || '';
    document.getElementById('field_full_name').value = addr.full_name || '';
    document.getElementById('field_phone').value = addr.phone || '';
    document.getElementById('field_address_line1').value = addr.address_line1 || '';
    document.getElementById('field_address_line2').value = addr.address_line2 || '';
    document.getElementById('field_city').value = addr.city || '';
    document.getElementById('field_state').value = addr.state || '';
    document.getElementById('field_postal_code').value = addr.postal_code || '';
    document.getElementById('field_type').value = addr.type || 'both';
    document.getElementById('field_is_default').checked = !!addr.is_default;
    document.getElementById('field_country').value = addr.country_id || '';

    var container = document.getElementById('address-form-container');
    container.classList.remove('hidden');
    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<?php endSection() ?>
