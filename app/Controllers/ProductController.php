<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;

class ProductController extends Controller
{
    public function index(Request $request, Response $response): string
    {
        $filters = [
            'category'    => $request->query('category'),
            'subcategory' => $request->query('subcategory'),
            'brand'       => $request->query('brand'),
            'search'      => $request->query('q'),
            'sort'        => $request->query('sort', 'newest'),
            'min_price'   => $request->query('min_price'),
            'max_price'   => $request->query('max_price'),
            'rating'      => $request->query('rating'),
            'in_stock'    => $request->query('in_stock'),
            'featured'    => $request->query('featured'),
            'on_sale'     => $request->query('on_sale'),
        ];

        $page = $this->getPage();
        $result = Product::getFiltered($filters, $page, PAGINATION_PER_PAGE);
        $filterOptions = Product::getFilterOptions();

        $title = 'Tous nos produits';
        $description = 'Découvrez notre collection complète de mukut, topor et accessoires de mariage.';
        if ($filters['category']) {
            $cat = Category::findBySlug($filters['category']);
            if ($cat) {
                $title = $cat['name'];
                $description = $cat['description'] ?: $description;
                $this->setBreadcrumb([
                    ['label' => 'Accueil', 'url' => url('/')],
                    ['label' => $cat['name']],
                ]);
            }
        } elseif ($filters['search']) {
            $title = 'Recherche : ' . e($filters['search']);
        } else {
            $this->setBreadcrumb([
                ['label' => 'Accueil', 'url' => url('/')],
                ['label' => 'Boutique'],
            ]);
        }

        $this->setMeta($title, $description);

        return $this->view('products.index', array_merge($result, [
            'filterOptions' => $filterOptions,
            'filters' => $filters,
            'currentCategory' => $filters['category'] ?: '',
            'searchQuery' => $filters['search'] ?: '',
            'sortBy' => $filters['sort'],
        ]));
    }

    public function show(Request $request, Response $response): string
    {
        $slug = $request->param('slug');
        $product = Product::findBySlug($slug);

        if (!$product) {
            $this->notFound('Produit introuvable');
        }

        $this->setMeta(
            $product['name'],
            $product['short_description'] ?: '',
            $product['meta_keywords'] ?? ''
        );

        $this->setBreadcrumb([
            ['label' => 'Accueil', 'url' => url('/')],
            ['label' => 'Boutique', 'url' => url('products')],
            ['label' => $product['category_name'] ?? '', 'url' => url('products?category=' . ($product['category_slug'] ?? ''))],
            ['label' => $product['name']],
        ]);

        $relatedProducts = Product::getRelated($product['id'], $product['category_id'], 4);
        $reviews = Review::getApprovedForProduct($product['id']);
        $ratingStats = Review::getStats($product['id']);

        if ($this->isAjax()) {
            $this->json(compact('product', 'relatedProducts', 'reviews', 'ratingStats'));
        }

        return $this->view('products.show', compact('product', 'relatedProducts', 'reviews', 'ratingStats'));
    }

    public function search(Request $request, Response $response): void
    {
        $query = $request->query('q', '');
        if (strlen($query) < 2) {
            $this->json(['results' => []]);
            return;
        }
        $products = Product::searchAjax($query, 5);
        $this->json(['results' => $products]);
    }

    public function getProduct(Request $request, Response $response): void
    {
        $id = (int)$request->query('id');
        $product = Product::find($id);
        if (!$product) {
            $this->json(['error' => 'Produit introuvable'], 404);
            return;
        }
        $this->json(['product' => $product->toArray()]);
    }

    public function checkPincode(Request $request, Response $response): void
    {
        $productId = (int)$request->query('product_id');
        $pincode = trim($request->query('pincode', ''));
        if (!$productId || !$pincode) {
            $this->json(['available' => false, 'message' => 'Invalid request.']);
            return;
        }
        $available = Product::checkPincode($productId, $pincode);
        if ($available) {
            $this->json(['available' => true, 'message' => '✓ Available for delivery at ' . e($pincode)]);
        } else {
            $this->json(['available' => false, 'message' => '✗ We do not deliver to ' . e($pincode) . ' yet.']);
        }
    }
}
