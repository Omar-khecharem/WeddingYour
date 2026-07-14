<?php
/**
 * Home Controller
 * 
 * Handles the homepage display with categories, featured products,
 * trending products, recent products, and customer reviews.
 *
 * @package App\Controllers
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index(Request $request, Response $response): string
    {
        $this->setMeta(
            'Premium Wedding Mukut, Topor & Wedding Accessories',
            'India\'s leading designer for premium handmade Sholapith wedding items and bridal accessories.',
            'shola ghar, wedding mukut, topor, sholapith, wedding accessories'
        );

        // Fetch data
        $categories = Category::getActiveWithProductCount();
        $recentProducts = Product::getRecent(8);
        $featuredProducts = Product::getFeatured(4);
        $trendingProducts = Product::getTrending(4);
        $reviews = Review::getApproved(3);

        return $this->view('home.index', [
            'categories' => $categories,
            'recentProducts' => $recentProducts,
            'featuredProducts' => $featuredProducts,
            'trendingProducts' => $trendingProducts,
            'reviews' => $reviews,
        ]);
    }
}
