<?php
/**
 * Modifier le mot de passe
 */
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'Mon compte', 'url' => url('account')],
    ['label' => 'Modifier le mot de passe', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-lock"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Modifier le mot de passe</h1>
            <p class="text-sm text-gray-500">Choisissez un mot de passe sécurisé</p>
        </div>
    </div>

    <?= error() ?>

    <form method="POST" action="<?= url('account/change-password') ?>" class="space-y-5 max-w-md">
        <?= \App\Helpers\Security::csrfField() ?>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe actuel</label>
            <input type="password" name="current_password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Votre mot de passe actuel">
            <?= error('current_password') ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nouveau mot de passe</label>
            <input type="password" name="new_password" required minlength="8"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Minimum 8 caractères">
            <?= error('new_password') ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmer le nouveau mot de passe</label>
            <input type="password" name="new_password_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Répétez le nouveau mot de passe">
            <?= error('new_password_confirmation') ?>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-500 space-y-1">
            <p class="font-semibold text-gray-700 mb-1">Exigences :</p>
            <p><i class="fa-solid fa-circle-check text-green-500 mr-1.5"></i> Minimum 8 caractères</p>
            <p><i class="fa-solid fa-circle-check text-green-500 mr-1.5"></i> Doit être différent de l'actuel</p>
        </div>

        <div class="pt-2">
            <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Mettre à jour le mot de passe
            </button>
        </div>
    </form>
</div>

<?php endSection() ?>
