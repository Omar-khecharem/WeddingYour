<?php
$users = $users ?? [];
$pagination = $pagination ?? ['currentPage' => 1, 'totalPages' => 1, 'hasPrev' => false, 'hasNext' => false, 'prevPage' => 1, 'nextPage' => 1];
?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Clients</h1>
                    <p class="text-sm text-gray-500">Gérez les comptes de vos clients</p>
                </div>
                <span class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200"><?= $pagination['totalItems'] ?? count($users) ?> clients</span>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Client</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Téléphone</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Rôle</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Statut</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Commandes</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Inscrit le</th>
                                <th class="px-5 py-3 text-gray-500 font-medium text-xs uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-users text-3xl mb-2 block text-gray-300"></i>
                                    Aucun client trouvé
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-primary-red/10 flex items-center justify-center text-primary-red font-bold text-sm">
                                            <?= strtoupper(substr(e($user['name'] ?? '?'), 0, 1)) ?>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800"><?= e($user['name']) ?></span>
                                            <?php if (!empty($user['username'])): ?>
                                            <p class="text-xs text-gray-400">@<?= e($user['username']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-500"><?= e($user['email']) ?></td>
                                <td class="px-5 py-3 text-gray-500"><?= e($user['phone'] ?? '-') ?></td>
                                <td class="px-5 py-3">
                                    <?php $role = $user['role'] ?? 'customer'; ?>
                                    <?php if ($role === 'admin'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Admin</span>
                                    <?php elseif ($role === 'customer'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Client</span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"><?= e($role) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3">
                                    <?php $ustat = $user['status'] ?? 'active'; ?>
                                    <?php if ($ustat === 'active'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Actif</span>
                                    <?php elseif ($ustat === 'inactive'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactif</span>
                                    <?php elseif ($ustat === 'banned'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Banni</span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"><?= e($ustat) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3 text-gray-500 font-medium"><?= $user['orders_count'] ?? 0 ?></td>
                                <td class="px-5 py-3 text-gray-500 whitespace-nowrap"><?= formatDate($user['created_at'] ?? '') ?></td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="<?= url('admin/users/' . e($user['id']) . '/edit') ?>" class="p-1.5 text-gray-400 hover:text-primary-red transition-colors" title="Modifier"><i class="fa-solid fa-pen"></i></a>
                                        <?php if (($user['status'] ?? '') !== 'banned'): ?>
                                        <a href="<?= url('admin/users/' . e($user['id']) . '/ban') ?>" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Bannir"><i class="fa-solid fa-ban"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= \App\Core\View::component('Pagination', [
                'currentPage' => $pagination['currentPage'],
                'totalPages' => $pagination['totalPages'],
                'baseUrl' => url('admin/users?'),
            ]) ?>
<?php endSection() ?>
