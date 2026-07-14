<?php
/**
 * Admin Product Controller
 * 
 * CRUD management for products in the admin panel.
 * Handles product creation, editing, image uploads,
 * stock management, and bulk operations.
 *
 * @package App\Controllers\Admin
 */

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\Security;
use App\Helpers\Image;

class ProductController extends Controller
{
    /**
     * Product list (admin)
     */
    public function index(Request $request, Response $response): string
    {
        $this->setMeta('Manage Products');
        $page = $this->getPage();

        $products = Product::paginate($page, PAGINATION_ADMIN_PER_PAGE);

        return $this->view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Create product form
     */
    public function create(Request $request, Response $response): string
    {
        $this->setMeta('Add Product');
        $categories = Category::getActive();

        return $this->view('admin.products.form', [
            'product' => null,
            'categories' => $categories,
        ]);
    }

    /**
     * Store new product
     */
    public function store(Request $request, Response $response): void
    {
        $data = [
            'category_id' => (int)$request->input('category_id'),
            'name' => Security::sanitize($request->input('name', '')),
            'slug' => slugify($request->input('name', '')),
            'short_description' => Security::sanitize($request->input('short_description', '')),
            'description' => $request->input('description', ''),
            'sku' => strtoupper($request->input('sku', '')),
            'regular_price' => (float)$request->input('regular_price', 0),
            'sale_price' => $request->input('sale_price') ? (float)$request->input('sale_price') : null,
            'stock_quantity' => (int)$request->input('stock_quantity', 0),
            'stock_status' => $request->input('stock_status', 'in_stock'),
            'is_featured' => (int)(bool)$request->input('is_featured'),
            'is_new' => (int)(bool)$request->input('is_new'),
            'is_trending' => (int)(bool)$request->input('is_trending'),
            'status' => (int)$request->input('status', 1),
            'meta_title' => Security::sanitize($request->input('meta_title', '')),
            'meta_description' => Security::sanitize($request->input('meta_description', '')),
        ];

        // Calculate discount percent
        if ($data['sale_price'] && $data['regular_price'] > 0) {
            $data['discount_percent'] = round((($data['regular_price'] - $data['sale_price']) / $data['regular_price']) * 100);
        }

        $product = Product::create($data);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $errors = Image::validate($file);
            if (empty($errors)) {
                $filename = Image::upload($file, PRODUCT_IMAGES_DIR, $data['name']);
                if ($filename) {
                    $pdo = \App\Core\Database::getInstance()->getConnection();
                    $pdo->prepare("INSERT INTO sg_product_images (product_id, image, is_primary) VALUES (:pid, :img, 1)")
                        ->execute([':pid' => $product->id, ':img' => $filename]);
                }
            }
        }

        $this->flash('success', 'Product created successfully.');
        $this->redirect(url('admin/products'));
    }

    /**
     * Edit product form
     */
    public function edit(Request $request, Response $response): string
    {
        $id = (int)$request->param('id');
        $product = Product::find($id);

        if (!$product) {
            $this->notFound('Product not found.');
        }

        $this->setMeta('Edit Product: ' . $product->name);
        $categories = Category::getActive();

        return $this->view('admin.products.form', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update product
     */
    public function update(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $product = Product::find($id);

        if (!$product) {
            $this->notFound('Product not found.');
        }

        $data = [
            'category_id' => (int)$request->input('category_id'),
            'name' => Security::sanitize($request->input('name', '')),
            'short_description' => Security::sanitize($request->input('short_description', '')),
            'description' => $request->input('description', ''),
            'regular_price' => (float)$request->input('regular_price', 0),
            'sale_price' => $request->input('sale_price') ? (float)$request->input('sale_price') : null,
            'stock_quantity' => (int)$request->input('stock_quantity', 0),
            'stock_status' => $request->input('stock_status', 'in_stock'),
            'is_featured' => (int)(bool)$request->input('is_featured'),
            'is_new' => (int)(bool)$request->input('is_new'),
            'is_trending' => (int)(bool)$request->input('is_trending'),
            'status' => (int)$request->input('status', 1),
        ];

        if ($data['sale_price'] && $data['regular_price'] > 0) {
            $data['discount_percent'] = round((($data['regular_price'] - $data['sale_price']) / $data['regular_price']) * 100);
        }

        $product->fill($data);
        $product->save();

        $this->flash('success', 'Product updated successfully.');
        $this->redirect(url('admin/products'));
    }

    /**
     * Delete product
     */
    public function destroy(Request $request, Response $response): void
    {
        $id = (int)$request->input('id');
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            $this->flash('success', 'Product deleted successfully.');
        } else {
            $this->flash('error', 'Product not found.');
        }

        $this->redirect(url('admin/products'));
    }
}
