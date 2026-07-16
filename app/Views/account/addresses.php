<?php


$addresses = $addresses ?? [];
$countries = $countries ?? [];

$typeLabels = [
    'billing'  => 'Billing',
    'shipping' => 'Shipping',
    'both'     => 'Billing & Shipping',
];

$typeColors = [
    'billing'  => 'bg-blue-100 text-blue-700',
    'shipping' => 'bg-green-100 text-green-700',
    'both'     => 'bg-purple-100 text-purple-700',
];
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'My Account', 'url' => url('account')],
    ['label' => 'My Addresses', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">My Addresses</h1>
                <p class="text-sm text-gray-500">Manage your billing and shipping addresses</p>
            </div>
        </div>
        <button type="button" onclick="toggleAddressForm()"
                class="maroon-btn inline-flex items-center gap-2 text-sm whitespace-nowrap">
            <i class="fa-solid fa-plus"></i> Add Address
        </button>
    </div>

    <?= error() ?>

    <!-- Formulaire Add / Edit -->
    <div id="address-form-container" class="hidden mb-8">
        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-gray-900" id="address-form-title">New Address</h2>
                <button type="button" onclick="toggleAddressForm()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form method="POST" action="<?= url('account/addresses') ?>" class="space-y-5">
                <?= \App\Helpers\Security::csrfField() ?>
                <input type="hidden" name="address_id" id="address_id" value="">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Label</label>
                        <input type="text" name="label" id="field_label"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="E.g.: Home, Office">
                        <?= error('label') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="full_name" id="field_full_name"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('full_name') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone" id="field_phone"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('phone') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                        <select name="country_id" id="field_country"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all bg-white">
                            <option value="">Select a country</option>
                            <?php foreach ($countries as $country): ?>
                            <option value="<?= (int)($country['id'] ?? 0) ?>">
                                <?= e($country['name'] ?? '') ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?= error('country_id') ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                        <input type="text" name="address_line1" id="field_address_line1"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="Street address">
                        <?= error('address_line1') ?>
                    </div>
                    <div class="sm:col-span-2">
                        <input type="text" name="address_line2" id="field_address_line2"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                               placeholder="Apartment, floor, etc. (optional)">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                        <input type="text" name="city" id="field_city"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('city') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">State / Region</label>
                        <input type="text" name="state" id="field_state"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('state') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ZIP / Postal Code</label>
                        <input type="text" name="postal_code" id="field_postal_code"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                        <?= error('postal_code') ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Address Type</label>
                        <select name="type" id="field_type"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all bg-white">
                            <option value="billing">Billing</option>
                            <option value="shipping">Shipping</option>
                            <option value="both" selected>Billing & Shipping</option>
                        </select>
                        <?= error('type') ?>
                    </div>
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_default" value="1" id="field_is_default"
                           class="rounded border-gray-300 text-primary-red focus:ring-primary-red">
                    <span class="text-sm text-gray-700">Set as default address</span>
                </label>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Save
                    </button>
                    <button type="button" onclick="toggleAddressForm()"
                            class="px-5 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Address list -->
    <?php if (empty($addresses)): ?>
    <div class="text-center py-16">
        <div class="text-5xl text-gray-300 mb-5">
            <i class="fa-solid fa-map-pin"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-700 mb-2">No addresses saved</h2>
        <p class="text-sm text-gray-500 mb-6">Add an address to get started.</p>
        <button onclick="toggleAddressForm()" class="maroon-btn">
            <i class="fa-solid fa-plus mr-1.5"></i> Add Address
        </button>
    </div>
    <?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($addresses as $addr): ?>
        <div class="relative border border-gray-200 rounded-xl p-5 hover:border-primary-red/30 transition-all <?= !empty($addr['is_default']) ? 'border-primary-red/50 bg-primary-red/[0.02]' : '' ?>">
            <?php if (!empty($addr['is_default'])): ?>
            <span class="absolute top-3 right-3 bg-primary-red text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                Default
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
                    <i class="fa-solid fa-pen mr-1"></i> Edit
                </button>
                <form method="POST" action="<?= url('account/addresses/delete') ?>" class="inline"
                      onsubmit="return confirm('Delete this address?')">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <input type="hidden" name="address_id" value="<?= (int)($addr['id'] ?? 0) ?>">
                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-600 transition-colors">
                        <i class="fa-solid fa-trash-can mr-1"></i> Delete
                    </button>
                </form>
                <?php if (empty($addr['is_default'])): ?>
                <form method="POST" action="<?= url('account/addresses/default') ?>" class="inline ml-auto">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <input type="hidden" name="address_id" value="<?= (int)($addr['id'] ?? 0) ?>">
                    <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                        Set as default
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
    document.getElementById('address-form-title').textContent = 'New Address';
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
    document.getElementById('address-form-title').textContent = 'Edit Address';
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
