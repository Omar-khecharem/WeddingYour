<?php
/**
 * Admin Dashboard Controller
 * 
 * Main admin panel controller providing the dashboard overview
 * with statistics, charts, and quick access to management tools.
 *
 * @package App\Controllers\Admin
 */

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Services\OrderService;

class DashboardController extends Controller
{
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }

    /**
     * Admin dashboard
     */
    public function index(Request $request, Response $response): string
    {
        $this->setMeta('Admin Dashboard');

        $stats = $this->orderService->getStats();

        return $this->view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * Clear system cache
     */
    public function clearCache(Request $request, Response $response): void
    {
        $cacheService = new \App\Services\CacheService();
        $cacheService->clear();

        // Clear view cache
        array_map('unlink', glob(VIEW_CACHE_DIR . DS . '*'));

        $this->flash('success', 'System cache cleared successfully.');
        $this->redirectBack();
    }

    /**
     * System logs viewer
     */
    public function logs(Request $request, Response $response): string
    {
        $this->setMeta('System Logs');

        $logFile = LOGS_DIR . DS . 'error.log';
        $logs = [];

        if (file_exists($logFile)) {
            $content = file_get_contents($logFile);
            $lines = explode("\n", $content);
            $logs = array_reverse(array_filter($lines));
            $logs = array_slice($logs, 0, 200);
        }

        return $this->view('admin.logs', ['logs' => $logs]);
    }
}
