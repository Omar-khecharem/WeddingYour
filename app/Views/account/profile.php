<?php
/**
 * Modifier le profil
 *
 * Variables : $user (id, name, email, phone)
 */

$user = $user ?? [];
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'Mon compte', 'url' => url('account')],
    ['label' => 'Modifier le profil', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Mon profil</h1>
            <p class="text-sm text-gray-500">Modifiez vos informations personnelles</p>
        </div>
    </div>

    <?= error() ?>

    <form method="POST" action="<?= url('account/profile') ?>" class="space-y-5 max-w-2xl">
        <?= \App\Helpers\Security::csrfField() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet</label>
                <input type="text" name="name" value="<?= old('name', e($user['name'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('name') ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse e-mail</label>
                <input type="email" name="email" value="<?= old('email', e($user['email'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('email') ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone</label>
                <input type="tel" name="phone" value="<?= old('phone', e($user['phone'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('phone') ?>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<?php endSection() ?>
