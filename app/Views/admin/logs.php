<?php
$logLines = $logLines ?? [];
$logFile = $logFile ?? '';
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
            <a href="<?= url('admin/settings') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors"><i class="fa-solid fa-gear w-5 text-center"></i> Paramètres</a>
            <a href="<?= url('admin/logs') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-primary-red/10 text-primary-red transition-colors"><i class="fa-solid fa-list w-5 text-center"></i> Logs</a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-[1400px] mx-auto py-6 px-4 lg:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Logs d'erreurs</h1>
                    <p class="text-sm text-gray-500">Fichier : <?= e(basename($logFile ?: 'error.log')) ?></p>
                </div>
                <div class="flex gap-2">
                    <button onclick="location.reload()" class="border border-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                        <i class="fa-solid fa-rotate"></i> Actualiser
                    </button>
                    <form method="POST" action="<?= url('admin/logs/clear') ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir effacer tous les logs ? Cette action est irréversible.')">
                        <button type="submit" class="border border-red-300 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors inline-flex items-center gap-2">
                            <i class="fa-solid fa-trash"></i> Effacer les logs
                        </button>
                    </form>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-sm font-medium text-gray-700">Dernières <?= count($logLines) ?> lignes</span>
                    </div>
                    <span class="text-xs text-gray-400">Auto-actualisation : <button id="auto-refresh-btn" class="text-primary-red hover:underline font-medium" onclick="toggleAutoRefresh()">Activer</button></span>
                </div>
                <div class="overflow-x-auto">
                    <?php if (empty($logLines)): ?>
                    <div class="p-12 text-center">
                        <i class="fa-solid fa-check-circle text-4xl text-green-400 mb-3 block"></i>
                        <p class="text-gray-500 font-medium">Aucune erreur trouvée</p>
                        <p class="text-sm text-gray-400 mt-1">Le fichier de logs est vide ou inexistant.</p>
                    </div>
                    <?php else: ?>
                    <div class="p-0">
                        <pre class="text-xs leading-6 font-mono text-gray-300 bg-gray-900 p-5 overflow-x-auto max-h-[600px] overflow-y-auto whitespace-pre-wrap break-all"><?php
                            $lines = array_slice($logLines, -200);
                            foreach ($lines as $index => $line):
                            $severity = '';
                            if (stripos($line, 'error') !== false || stripos($line, 'fatal') !== false) $severity = 'text-red-400';
                            elseif (stripos($line, 'warning') !== false) $severity = 'text-yellow-400';
                            elseif (stripos($line, 'notice') !== false) $severity = 'text-blue-400';
                            else $severity = 'text-gray-300';
                            ?><span class="<?= $severity ?>"><?= e($line) ?></span>
<?php endforeach; ?></pre>
                    </div>
                    <div class="bg-white border-t border-gray-200 px-5 py-3 text-xs text-gray-400 flex items-center justify-between">
                        <span>Affichage des <?= count($logLines) ?> dernières lignes</span>
                        <span>Dernière actualisation : <span id="last-refresh"><?= date('H:i:s') ?></span></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
let autoRefreshInterval = null;

function toggleAutoRefresh() {
    const btn = document.getElementById('auto-refresh-btn');
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
        btn.textContent = 'Activer';
        btn.classList.remove('text-red-600');
        btn.classList.add('text-primary-red');
    } else {
        autoRefreshInterval = setInterval(function() {
            location.reload();
        }, 10000);
        btn.textContent = 'Désactiver (10s)';
        btn.classList.remove('text-primary-red');
        btn.classList.add('text-red-600');
    }
}
</script>
