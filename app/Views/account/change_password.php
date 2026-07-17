<?php

?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'My Account', 'url' => url('account')],
    ['label' => 'Change Password', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-lock"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Change Password</h1>
            <p class="text-sm text-gray-500">Choose a secure password</p>
        </div>
    </div>

    <?= error() ?>

    <form method="POST" action="<?= url('account/change-password') ?>" class="space-y-5 max-w-md">
        <?= \App\Helpers\Security::csrfField() ?>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Current Password</label>
            <input type="password" name="current_password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Your current password">
            <?= error('current_password') ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
            <input type="password" name="new_password" required minlength="8"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Minimum 8 characters">
            <?= error('new_password') ?>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all"
                   placeholder="Repeat new password">
            <?= error('new_password_confirmation') ?>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-500 space-y-1">
            <p class="font-semibold text-gray-700 mb-1">Requirements:</p>
            <p><i class="fa-solid fa-circle-check text-green-500 mr-1.5"></i> Minimum 8 characters</p>
            <p><i class="fa-solid fa-circle-check text-green-500 mr-1.5"></i> Must be different from current</p>
        </div>

        <div class="pt-2">
            <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Update Password
            </button>
        </div>
    </form>
</div>

<?php endSection() ?>
