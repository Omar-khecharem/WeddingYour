<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Services\OrderService;

class DashboardController extends BaseAdminController
{
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }

    public function index(Request $request, Response $response): string
    {
        $this->setMeta('Admin Dashboard');
        $pdo = \App\Core\Database::getInstance()->getConnection();

        $stats = $this->orderService->getStats();
        $stats['total_users'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_users")->fetchColumn();
        $stats['total_products'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_products WHERE status = 1")->fetchColumn();
        $stats['low_stock_count'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_products WHERE stock_status = 'in_stock' AND stock_quantity < 5")->fetchColumn();
        $stats['total_categories'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_categories WHERE status = 1")->fetchColumn();
        $stats['total_reviews'] = (int)$pdo->query("SELECT COUNT(*) FROM sg_reviews WHERE is_approved = 0")->fetchColumn();

        $lastMonthRevenue = (float)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM sg_orders WHERE MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND order_status NOT IN ('cancelled', 'refunded')")->fetchColumn();
        $stats['revenue_growth'] = $lastMonthRevenue > 0 ? round((($stats['total_revenue'] - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        $recentOrders = $pdo->query("SELECT o.*, u.name AS customer_name FROM sg_orders o LEFT JOIN sg_users u ON u.id = o.user_id ORDER BY o.created_at DESC LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function clearCache(Request $request, Response $response): void
    {
        $cacheService = new \App\Services\CacheService();
        $cacheService->clear();
        array_map('unlink', glob(VIEW_CACHE_DIR . DS . '*'));
        $this->flash('success', 'System cache cleared successfully.');
        $this->redirectBack();
    }

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
