<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Compare;

class CompareController extends Controller
{
    public function index(Request $request, Response $response): string
    {
        $userId = $this->getUserId();
        $sessionId = $this->getSessionId();
        $products = Compare::getList($userId, $sessionId);
        $count = Compare::getCount($userId, $sessionId);

        $this->setMeta('Comparer des produits - Shola Ghar', 'Comparez vos produits favoris côte à côte.');
        $this->setBreadcrumb([
            ['label' => 'Accueil', 'url' => url('/')],
            ['label' => 'Comparer'],
        ]);

        return $this->view('products.compare', compact('products', 'count'));
    }

    public function toggle(Request $request, Response $response): void
    {
        $productId = (int)$request->input('product_id', 0);
        if (!$productId) {
            $this->json(['success' => false, 'message' => 'Produit invalide.']);
            return;
        }

        $userId = $this->getUserId();
        $sessionId = $this->getSessionId();
        $result = Compare::toggle($userId, $sessionId, $productId);

        $this->json(['success' => true, 'action' => $result['action'], 'count' => $result['count']]);
    }

    public function count(Request $request, Response $response): void
    {
        $userId = $this->getUserId();
        $sessionId = $this->getSessionId();
        $this->json(['count' => Compare::getCount($userId, $sessionId)]);
    }

    public function clear(Request $request, Response $response): void
    {
        $userId = $this->getUserId();
        $sessionId = $this->getSessionId();
        Compare::clear($userId, $sessionId);
        $this->json(['success' => true]);
    }

    private function getUserId(): ?int
    {
        return \App\Helpers\Session::get('user_id') ?: null;
    }

    private function getSessionId(): ?string
    {
        return session_id() ?: null;
    }
}
