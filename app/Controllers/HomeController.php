<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Banner;
use App\Models\Deal;
use App\Models\CategoryCard;
use App\Models\GalleryItem;
use App\Models\Outlet;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index(Request $request, Response $response): string
    {
        $this->setMeta(
            'Premium Wedding Mukut, Topor & Wedding Accessories',
            'India\'s leading designer for premium handmade Sholapith wedding items and bridal accessories.',
            'shola ghar, wedding mukut, topor, sholapith, wedding accessories'
        );

        $categories = Category::getActiveWithProductCount();
        $recentProducts = Product::getRecent(8);
        $featuredProducts = Product::getFeatured(4);
        $trendingProducts = Product::getTrending(4);
        $reviews = Review::getApproved(3);
        $banners = Banner::getAllActive();
        $deals = Deal::getActive();
        $categoryCards = CategoryCard::getActive();
        $galleryItems = GalleryItem::getActive();
        $outlets = Outlet::getActive();
        $whatsappNumber = Setting::get('whatsapp_number', '+919830136355');

        $subcategories = [];
        try {
            $pdo = \App\Core\Database::getInstance()->getConnection();
            $subcategories = $pdo->query("SELECT sc.id, sc.name, sc.slug, sc.image, sc.category_id, c.slug AS cat_slug FROM sg_subcategories sc JOIN sg_categories c ON c.id = sc.category_id WHERE sc.status = 1 ORDER BY c.sort_order, sc.sort_order, sc.name")->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {}

        // Hero text from settings
        $heroTitle = Setting::get('hero_title', 'Premium Wedding Mukut');
        $heroSubtitle = Setting::get('hero_subtitle', 'New Collection 2026');
        $heroDescription = Setting::get('hero_description', '');
        $heroButtonText = Setting::get('hero_button_text', 'Shop Now');
        $heroButtonLink = Setting::get('hero_button_link', '/products');

        $allProductIds = array_merge(
            array_column($recentProducts, 'id'),
            array_column($featuredProducts, 'id'),
            array_column($trendingProducts, 'id')
        );
        $homeRatings = \App\Models\Review::getBatchRatings($allProductIds);

        return $this->view('home.index', compact(
            'categories', 'subcategories', 'recentProducts', 'featuredProducts', 'trendingProducts', 'reviews',
            'banners', 'deals', 'categoryCards', 'galleryItems', 'outlets',
            'whatsappNumber', 'heroTitle', 'heroSubtitle', 'heroDescription', 'heroButtonText', 'heroButtonLink',
            'homeRatings'
        ));
    }
}
