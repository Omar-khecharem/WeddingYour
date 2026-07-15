<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= e($metaTitle ?? DEFAULT_META_TITLE) ?></title>
    <meta name="description" content="<?= e($metaDescription ?? DEFAULT_META_DESCRIPTION) ?>">
    <meta name="keywords" content="<?= e($metaKeywords ?? DEFAULT_META_KEYWORDS) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonicalUrl ?? APP_URL . $_SERVER['REQUEST_URI']) ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($metaTitle ?? DEFAULT_META_TITLE) ?>">
    <meta property="og:description" content="<?= e($metaDescription ?? DEFAULT_META_DESCRIPTION) ?>">
    <meta property="og:url" content="<?= e(APP_URL . $_SERVER['REQUEST_URI']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e(\App\Models\Setting::get('site_name', APP_NAME)) ?>">
    <meta property="og:locale" content="en_IN">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($metaTitle ?? DEFAULT_META_TITLE) ?>">
    <meta name="twitter:description" content="<?= e($metaDescription ?? DEFAULT_META_DESCRIPTION) ?>">
    
    <!-- Favicon -->
    <?php $siteFavicon = \App\Models\Setting::get('site_favicon', ''); if (empty($siteFavicon) && file_exists(PUBLIC_DIR . DS . 'uploads' . DS . 'site_favicon.png')) $siteFavicon = 'site_favicon.png'; ?>
    <?php if ($siteFavicon): ?>
    <link rel="icon" href="<?= uploadUrl($siteFavicon) ?>">
    <?php else: ?>
    <link rel="icon" type="image/svg+xml" href="<?= asset('images/favicon.svg') ?>">
    <?php endif; ?>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>.scrollbar-hide::-webkit-scrollbar{display:none}</style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                    },
                    colors: {
                        'maroon': '#800020',
                        'primary-red': '#b30d1b',
                        'accent-orange': '#e65100',
                        'dark-red': '#5c0017',
                        'light-pink': '#fcc2d7',
                        'soft-pink': '#fff0f5',
                        'gold': '#d4af37',
                        'dark-gray': '#2d2d2d',
                        'medium-gray': '#666666',
                        'light-gray': '#f9f9f9',
                        'border-color': '#e0d0c0',
                    },
                    keyframes: {
                        slideInRight: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        pulseRing: {
                            '0%': { boxShadow: '0 0 0 0 rgba(255,255,255,0.4)' },
                            '70%': { boxShadow: '0 0 0 20px rgba(255,255,255,0)' },
                            '100%': { boxShadow: '0 0 0 0 rgba(255,255,255,0)' },
                        }
                    },
                    animation: {
                        slideInRight: 'slideInRight 0.3s ease-out',
                        fadeIn: 'fadeIn 0.3s ease-out',
                        pulseRing: 'pulseRing 2s infinite',
                    }
                }
            }
        }
    </script>

    <script>window.CSRF_TOKEN = '<?= \App\Helpers\Session::csrfToken() ?>';</script>
    
    <!-- Custom Styles -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; line-height: 1.6; background: #fafafa; }
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f9f9f9; }
        ::-webkit-scrollbar-thumb { background: #b30d1b; border-radius: 4px; }

        .logo-text { font-size: 28px; font-weight: 800; color: #b30000; letter-spacing: 1px; text-transform: uppercase; line-height: 1.2; }
        .logo-sub { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #888; font-weight: 600; }

        .search-container { border: 2px solid #91005a; border-radius: 30px; padding: 2px 4px 2px 18px; background: white; transition: all 0.3s; }
        .search-container:focus-within { border-color: #b30d1b; box-shadow: 0 0 8px rgba(179, 13, 27, 0.15); }
        .search-container input { border: none; outline: none; width: 100%; padding: 8px 0; font-size: 14px; background: transparent; }
        .search-btn { background: #91005a; color: white; width: 38px; height: 38px; border-radius: 50%; border: none; cursor: pointer; transition: transform 0.3s; }
        .search-btn:hover { transform: scale(1.05); }

        .nav-categories { background: #990011; color: white; font-weight: 700; padding: 12px 24px; display: flex; align-items: center; gap: 16px; cursor: pointer; transition: background 0.3s; border-radius: 4px 0 0 4px; }
        .nav-categories:hover { background: #7a000d; }

        .nav-links { background: #83868c; border-bottom: 1px solid #6a6d73; }
        .nav-links a { color: #e8e8e8; font-weight: 600; font-size: 13px; padding: 12px 0; transition: color 0.3s; }
        .nav-links a:hover { color: white; }
        .nav-links .active { border-bottom: 2px solid #990011; }

        .icon-btn { width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #444; font-size: 18px; border: 1px solid #ddd; transition: background 0.3s; }
        .icon-btn:hover { background: #f0f0f0; }

        .cart-badge { position: absolute; top: -4px; right: -6px; background: #990011; color: white; font-size: 10px; font-weight: 700; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; }

        .category-circle { text-align: center; cursor: pointer; min-width: 100px; }
        .category-circle .circle-img { width: 110px; height: 110px; border-radius: 40% 40% 40% 40%; overflow: hidden; border: 3px solid #e2e2e2; transition: all 0.3s; margin: 0 auto 10px; }
        .category-circle:hover .circle-img { transform: translateY(-5px); border-color: #b30d1b; box-shadow: 0 6px 15px rgba(179, 13, 27, 0.15); }
        .category-circle .circle-img img { width: 100%; height: 100%; object-fit: cover; }
        .category-circle p { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #333; letter-spacing: 0.3px; }

        .hero-video-card { background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1200'); background-size: cover; background-position: center; border-radius: 16px; overflow: hidden; height: 280px; display: flex; align-items: center; justify-content: center; position: relative; }
        .play-btn { width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #b30d1b; cursor: pointer; box-shadow: 0 4px 20px rgba(0,0,0,0.25); transition: all 0.3s; animation: pulseRing 2s infinite; }
        .play-btn:hover { transform: scale(1.1); background: #b30d1b; color: white; }

        .hero-banner-card { background: linear-gradient(135deg, #f57c00, #e65100); border-radius: 16px; overflow: hidden; height: 280px; padding: 30px; display: flex; flex-direction: column; justify-content: center; color: white; position: relative; }
        .hero-banner-card .banner-img { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 35%; opacity: 0.85; }
        .hero-banner-card .banner-img img { border-radius: 50%; box-shadow: 0 8px 25px rgba(0,0,0,0.2); }

        .section-title { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 700; color: #5c0017; }
        .section-subtitle { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }

        .quick-grid-card { background: white; border: 1px solid #e8e8e8; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .quick-grid-card h3 { font-size: 17px; font-weight: 700; color: #222; margin-bottom: 15px; padding-bottom: 8px; position: relative; }
        .quick-grid-card h3::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 2px; background: #b30d1b; }

        .trending-card { background: white; border-radius: 40px; border: 3px solid #ffdde1; padding: 15px; text-align: center; box-shadow: 0 8px 24px rgba(0,0,0,0.04); transition: all 0.3s; }
        .trending-card:hover { transform: translateY(-5px); border-color: #b30d1b; box-shadow: 0 12px 30px rgba(179,13,27,0.08); }
        .trending-card .trending-img { height: 200px; border-radius: 30px; overflow: hidden; margin-bottom: 18px; }
        .trending-card .trending-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .trending-card:hover .trending-img img { transform: scale(1.06); }
        .trending-btn { display: inline-block; background: linear-gradient(135deg, #f57c00, #e65100); color: white; padding: 10px 30px; border-radius: 25px; font-weight: 700; font-size: 13px; box-shadow: 0 4px 12px rgba(230,81,0,0.3); transition: all 0.3s; width: 85%; }
        .trending-btn:hover { background: linear-gradient(135deg, #e65100, #bf360c); box-shadow: 0 6px 18px rgba(230,81,0,0.45); transform: scale(1.03); }

        .product-card { background: white; border: 1px solid #e6e6e6; border-radius: 12px; padding: 15px; text-align: center; transition: all 0.3s; position: relative; }
        .product-card:hover { transform: translateY(-5px); border-color: #b30d1b; box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .product-card .discount-badge { position: absolute; top: 12px; left: 12px; background: #b30d1b; color: white; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; z-index: 2; }
        .product-card .prod-img { height: 160px; border-radius: 8px; overflow: hidden; margin-bottom: 12px; background: #fafafa; }
        .product-card .prod-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .product-card:hover .prod-img img { transform: scale(1.06); }
        .product-card .prod-name { font-size: 13.5px; font-weight: 700; color: #222; margin-bottom: 4px; text-transform: capitalize; }
        .product-card .prod-category { font-size: 10px; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 8px; }
        .product-card .stock-status { color: #2e7d32; font-size: 11px; font-weight: 700; margin-bottom: 6px; }
        .product-card .stars { color: #ffd54f; font-size: 12px; margin-bottom: 10px; }
        .product-card .old-price { text-decoration: line-through; color: #999; font-size: 12px; margin-right: 6px; }
        .product-card .new-price { color: #b30d1b; font-size: 14px; font-weight: 700; }

        .maroon-btn { display: inline-block; background: linear-gradient(135deg, #b30d1b, #800000); color: white; padding: 14px 45px; border-radius: 30px; font-weight: 700; font-size: 13.5px; text-transform: uppercase; box-shadow: 0 5px 15px rgba(179,13,27,0.3); transition: all 0.3s; }
        .maroon-btn:hover { transform: scale(1.05); box-shadow: 0 8px 22px rgba(179,13,27,0.45); }

        .review-card { background: white; border: 1px solid #e2e2e2; border-radius: 12px; padding: 25px; transition: all 0.3s; }
        .review-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.05); }
        .review-card .avatar { width: 46px; height: 46px; border-radius: 50%; overflow: hidden; background: #eaeaea; flex-shrink: 0; }
        .review-card .avatar img { width: 100%; height: 100%; object-fit: cover; }

        footer { background: #1a1a1a; color: #ccc; padding: 60px 5% 30px; font-size: 13.5px; }
        .footer-col h3 { color: white; font-size: 15px; font-weight: 700; text-transform: uppercase; margin-bottom: 20px; padding-bottom: 8px; position: relative; }
        .footer-col h3::after { content: ''; position: absolute; bottom: 0; left: 0; width: 35px; height: 2px; background: #b30d1b; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul li a { transition: all 0.3s; }
        .footer-col ul li a:hover { color: white; padding-left: 5px; }

        .security-banner { background: #2b2b2b; border-left: 4px solid #b30d1b; padding: 15px 25px; border-radius: 4px; }
        .security-banner h4 { color: white; font-size: 14px; font-weight: 700; margin-bottom: 5px; }

        .payment-methods img { height: 22px; filter: grayscale(100%); opacity: 0.6; transition: all 0.3s; }
        .payment-methods img:hover { filter: grayscale(0%); opacity: 1; }

        .whatsapp-float { position: fixed; bottom: 25px; right: 25px; background: #25d366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 1000; transition: all 0.3s; }
        .whatsapp-float:hover { transform: scale(1.1); background: #1ebea5; }

        .grid-img-item { height: 100px; border-radius: 6px; overflow: hidden; background: #f5f5f5; }
        .grid-img-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .grid-img-item:hover img { transform: scale(1.08); }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        @media (max-width: 768px) {
            .logo-text { font-size: 20px; }
            .hero-video-card, .hero-banner-card { height: 200px; }
            .hero-banner-card .banner-img { display: none; }
            .nav-links { overflow-x: auto; padding: 0 15px; }
            .nav-links a { font-size: 11px; padding: 10px 12px; white-space: nowrap; }
            .section-title { font-size: 22px; }
        }
        
        @media (max-width: 640px) {
            .whatsapp-float { width: 50px; height: 50px; font-size: 26px; bottom: 20px; right: 20px; }
        }
        [data-wishlist].is-active svg { fill: #dc2626 !important; stroke: #dc2626 !important; }
        [data-wishlist].is-inactive svg { fill: none !important; }
    </style>
</head>
<body>
