<?php
$settings = $settings ?? [];
$groups = [];
foreach ($settings as $setting) {
    $group = $setting['group'] ?? 'general';
    if (!isset($groups[$group])) $groups[$group] = [];
    $groups[$group][] = $setting;
}

$groupLabels = [
    'general' => ['Général', 'Paramètres généraux du site', 'fa-solid fa-globe'],
    'social' => ['Réseaux sociaux', 'Liens et paramètres des réseaux sociaux', 'fa-solid fa-share-nodes'],
    'tax' => ['Taxes', 'Paramètres de taxation', 'fa-solid fa-percent'],
    'shipping' => ['Livraison', 'Paramètres d\'expédition', 'fa-solid fa-truck'],
    'seo' => ['SEO', 'Paramètres de référencement', 'fa-solid fa-magnifying-glass-chart'],
];
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
            <a href="<?= url('admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-box w-5 text-center"></i> Produits</a>
            <a href="<?= url('admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-truck w-5 text-center"></i> Commandes</a>
            <a href="<?= url('admin/users') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-users w-5 text-center"></i> Clients</a>
            <a href="<?= url('admin/reviews') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-star w-5 text-center"></i> Avis</a>
            <a href="<?= url('admin/coupons') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-tag w-5 text-center"></i> Coupons</a>
            <a href="<?= url('admin/pages') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-file w-5 text-center"></i> Pages</a>
            <hr class="my-3 border-gray-200">
            <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-gear w-5 text-center"></i> Paramètres</a>
            <a href="<?= url('admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-list w-5 text-center"></i> Logs</a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-[1400px] mx-auto py-6 px-4 lg:px-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Paramètres</h1>
                    <p class="text-sm text-gray-500">Configurez les différents paramètres de votre site</p>
                </div>
            </div>
            <div class="flex gap-6 flex-col lg:flex-row">
                <div class="lg:w-56 flex-shrink-0">
                    <nav class="bg-white rounded-xl border border-gray-200 p-3 space-y-1 sticky top-6">
                        <?php foreach ($groups as $groupKey => $groupSettings): ?>
                        <?php $label = $groupLabels[$groupKey] ?? [ucfirst($groupKey), '', 'fa-solid fa-gear']; ?>
                        <a href="#group-<?= e($groupKey) ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                            <i class="<?= e($label[2]) ?> w-5 text-center"></i> <?= e($label[0]) ?>
                        </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
                <div class="flex-1 space-y-6">
                    <form method="POST" action="<?= url('admin/settings/update') ?>">
                        <?php foreach ($groups as $groupKey => $groupSettings): ?>
                        <?php $label = $groupLabels[$groupKey] ?? [ucfirst($groupKey), '', 'fa-solid fa-gear']; ?>
                        <div id="group-<?= e($groupKey) ?>" class="bg-white rounded-xl border border-gray-200 p-5">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-lg bg-primary-red/10 flex items-center justify-center text-primary-red"><i class="<?= e($label[2]) ?>"></i></div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-800"><?= e($label[0]) ?></h2>
                                    <p class="text-sm text-gray-500"><?= e($label[1]) ?></p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <?php foreach ($groupSettings as $setting): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="setting-<?= e($setting['key']) ?>">
                                        <?= e($setting['label'] ?? $setting['key']) ?>
                                    </label>
                                    <?php $type = $setting['type'] ?? 'text'; ?>
                                    <?php if ($type === 'textarea'): ?>
                                    <textarea name="setting[<?= e($setting['key']) ?>]" id="setting-<?= e($setting['key']) ?>" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none"><?= e($setting['value'] ?? '') ?></textarea>
                                    <?php elseif ($type === 'boolean'): ?>
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="hidden" name="setting[<?= e($setting['key']) ?>]" value="0">
                                        <input type="checkbox" name="setting[<?= e($setting['key']) ?>]" value="1" <?= ($setting['value'] ?? '') === '1' ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-red focus:ring-primary-red">
                                        <span class="text-sm text-gray-500">Activé</span>
                                    </label>
                                    <?php elseif ($type === 'select'): ?>
                                    <select name="setting[<?= e($setting['key']) ?>]" id="setting-<?= e($setting['key']) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                        <?php foreach (($setting['options'] ?? []) as $optVal => $optLabel): ?>
                                        <option value="<?= e($optVal) ?>" <?= ($setting['value'] ?? '') === $optVal ? 'selected' : '' ?>><?= e($optLabel) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php else: ?>
                                    <input type="<?= e($type) ?>" name="setting[<?= e($setting['key']) ?>]" id="setting-<?= e($setting['key']) ?>" value="<?= e($setting['value'] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:ring-2 focus:ring-primary-red/20 focus:border-primary-red outline-none">
                                    <?php endif; ?>
                                    <?php if (!empty($setting['description'])): ?>
                                    <p class="text-xs text-gray-400 mt-1"><?= e($setting['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-red text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:opacity-90 transition-all inline-flex items-center gap-2">
                                <i class="fa-solid fa-save"></i> Enregistrer les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
