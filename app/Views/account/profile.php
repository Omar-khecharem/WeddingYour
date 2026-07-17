<?php


$user = $user ?? [];
?>

<?= component('Breadcrumb', ['crumbs' => [
    ['label' => 'My Account', 'url' => url('account')],
    ['label' => 'Edit Profile', 'url' => null],
]]) ?>

<?php startSection('content') ?>

<div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">My Profile</h1>
            <p class="text-sm text-gray-500">Edit your personal information</p>
        </div>
    </div>

    <?= error() ?>

    <form method="POST" action="<?= url('account/profile') ?>" class="space-y-5 max-w-2xl">
        <?= \App\Helpers\Security::csrfField() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                <input type="text" name="name" value="<?= old('name', e($user['name'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('name') ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                <input type="email" name="email" value="<?= old('email', e($user['email'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('email') ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone</label>
                <input type="tel" name="phone" value="<?= old('phone', e($user['phone'] ?? '')) ?>"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-red focus:ring-1 focus:ring-primary-red transition-all">
                <?= error('phone') ?>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="maroon-btn inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<?php endSection() ?>
