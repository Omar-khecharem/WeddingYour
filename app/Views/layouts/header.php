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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>.scrollbar-hide::-webkit-scrollbar{display:none}
    [data-wishlist] svg{fill:none;stroke:currentColor}
    [data-wishlist].is-active{color:#E63946 !important}
    [data-wishlist].is-active svg{fill:#E63946 !important;stroke:#E63946 !important}
    [data-wishlist].is-inactive{color:inherit !important}
    [data-wishlist].is-inactive svg{fill:none !important}
    [data-compare] svg{fill:none;stroke:currentColor}
    [data-compare].is-active{color:#E63946 !important}
    [data-compare].is-active svg{fill:#E63946 !important;stroke:#E63946 !important}
    [data-compare].is-inactive{color:inherit !important}
    [data-compare].is-inactive svg{fill:none !important}
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                        'cormorant': ['Cormorant Garamond', 'serif'],
                    },
                    colors: {
                        'premium': {
                            'charcoal': '#1A1A2E',
                            'navy': '#2C3E7B',
                            'burgundy': '#E63946',
                            'cabernet': '#C1121F',
                            'crimson': '#D90429',
                            'rose': '#E91E63',
                            'blush': '#FFB5C2',
                            'champagne': '#FFD700',
                            'gold': '#FFA500',
                            'ivory': '#FFF8E7',
                            'cream': '#FFFDF5',
                            'warm-gray': '#F0E6D3',
                            'stone': '#E8D5C4',
                            'taupe': '#A9907E',
                            'mink': '#5C4033',
                            'dark': '#1A1A2E',
                            'emerald': '#2ECC71',
                            'saffron': '#FF7F00',
                            'royal': '#3498DB',
                        }
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
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        }
                    },
                    animation: {
                        slideInRight: 'slideInRight 0.3s ease-out',
                        fadeIn: 'fadeIn 0.3s ease-out',
                        fadeInUp: 'fadeInUp 0.5s ease-out',
                        shimmer: 'shimmer 1.5s infinite',
                    }
                }
            }
        }
    </script>

    <script>window.CSRF_TOKEN = '<?= \App\Helpers\Session::csrfToken() ?>'; window.APP_CURRENCY = '<?= APP_CURRENCY ?>';</script>
    
    <!-- Custom Styles -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Montserrat', sans-serif; 
            line-height: 1.7; 
            background: #FFF8E7; 
            color: #333333;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        ::selection { background: #E63946; color: #FFFFFF; }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F0E6D3; }
        ::-webkit-scrollbar-thumb { background: #E63946; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #C1121F; }

        .heading-serif { font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.02em; }
        .heading-cormorant { font-family: 'Cormorant Garamond', serif; font-weight: 600; letter-spacing: 0.02em; }
        .text-premium { font-family: 'Montserrat', sans-serif; font-weight: 300; letter-spacing: 0.05em; }

        /* Luxury divider */
        .divider-gold {
            height: 2px;
            background: linear-gradient(90deg, transparent, #FFD700, #E63946, #FFD700, transparent);
        }
        .divider-gold-vertical {
            width: 2px;
            background: linear-gradient(180deg, transparent, #FFD700, transparent);
        }

        /* Search */
        .search-premium {
            border: 2px solid #E8D5C4;
            border-radius: 9999px;
            padding: 2px 4px 2px 20px;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .search-premium:focus-within {
            border-color: #E63946;
            box-shadow: 0 0 0 4px rgba(230, 57, 70, 0.12);
        }
        .search-premium input {
            border: none;
            outline: none;
            width: 100%;
            padding: 10px 0;
            font-size: 13px;
            background: transparent;
            color: #1A1A2E;
        }
        .search-premium input::placeholder { color: #A9907E; }
        .search-btn-premium {
            background: #E63946;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-btn-premium:hover { background: #C1121F; transform: scale(1.08); box-shadow: 0 4px 12px rgba(230, 57, 70, 0.3); }

        /* Navigation */
        .nav-link {
            position: relative;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #A9907E;
            transition: color 0.3s;
            padding: 8px 0;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #FFD700;
            transition: width 0.3s ease;
        }
        .nav-link:hover { color: #FFFFFF; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: #FFD700; }
        .nav-link.active::after { width: 100%; background: #FFD700; }

        /* Category dropdown refined */
        .category-trigger {
            background: #E63946;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.08em;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }
        .category-trigger:hover { background: #C1121F; box-shadow: 0 4px 16px rgba(230, 57, 70, 0.3); }
        .dropdown-panel {
            background: white;
            border: 1px solid #F0E6D3;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border-radius: 0 0 8px 8px;
        }
        .dropdown-item {
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
            color: #5C4033;
            transition: all 0.2s;
            border-bottom: 1px solid #F5F0EB;
        }
        .dropdown-item:hover {
            background: #FFF8E7;
            color: #E63946;
            padding-left: 24px;
        }

        /* Icon button */
        .icon-btn-premium {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5C4033;
            transition: all 0.3s;
            position: relative;
        }
        .icon-btn-premium:hover {
            background: #FFD700;
            color: #1A1A2E;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }
        .badge-premium {
            position: absolute;
            top: -3px;
            right: -4px;
            background: #E63946;
            color: white;
            font-size: 9px;
            font-weight: 800;
            min-width: 18px;
            height: 18px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FFF8E7;
            padding: 0 3px;
            box-shadow: 0 2px 6px rgba(230, 57, 70, 0.3);
        }

        /* Product card premium */
        .card-premium {
            background: white;
            border: 1px solid #F0E6D3;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.1, 0.25, 1);
        }
        .card-premium:hover {
            border-color: #FFD700;
            box-shadow: 0 12px 40px rgba(230, 57, 70, 0.08);
            transform: translateY(-3px);
        }

        /* Section title premium */
        .section-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #1A1A2E;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .section-subtitle-premium {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #A9907E;
        }

        /* CTA button */
        .btn-primary-premium {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #E63946;
            color: #FFFFFF;
            padding: 16px 40px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary-premium:hover {
            background: #C1121F;
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(230, 57, 70, 0.35);
        }

        .btn-secondary-premium {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #FFD700;
            color: #1A1A2E;
            padding: 14px 36px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-secondary-premium:hover {
            background: #FFC300;
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(255, 215, 0, 0.35);
        }

        /* Legacy class aliases (compatibility) */
        .section-title { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 700; color: #E63946; }
        .section-subtitle { font-size: 11px; color: #A9907E; text-transform: uppercase; letter-spacing: 0.15em; font-weight: 600; }
        .maroon-btn {
            display: inline-flex; align-items: center; gap: 10px;
            background: #E63946; color: #FFFFFF;
            padding: 16px 40px; border-radius: 9999px;
            font-weight: 700; font-size: 13px; letter-spacing: 0.08em;
            text-transform: uppercase; transition: all 0.3s ease;
            border: none; cursor: pointer;
        }
        .maroon-btn:hover { background: #C1121F; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(230, 57, 70, 0.35); }

        /* WhatsApp float */
        .whatsapp-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: #25D366;
            color: white;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .whatsapp-float:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
        }

        /* Footer premium */
        .footer-premium {
            background: #1A1A2E;
            color: #A9907E;
        }
        .footer-premium h3 {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: #FFD700;
            margin-bottom: 20px;
            letter-spacing: 0.02em;
        }
        .footer-premium a {
            transition: all 0.3s;
        }
        .footer-premium a:hover {
            color: #FFD700;
            padding-left: 4px;
        }
        .footer-premium .social-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #5C4033;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #A9907E;
            transition: all 0.3s;
        }
        .footer-premium .social-circle:hover {
            border-color: #FFD700;
            color: #FFD700;
            background: rgba(255, 215, 0, 0.1);
        }

        /* Line clamp */
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* Premium card overlay */
        .overlay-premium {
            background: linear-gradient(180deg, transparent 40%, rgba(26,26,46,0.85) 100%);
        }

        @media (max-width: 768px) {
            .section-title-premium { font-size: 24px; }
            .btn-primary-premium { padding: 12px 28px; font-size: 11px; }
        }
        
        @media (max-width: 640px) {
            .whatsapp-float { width: 48px; height: 48px; font-size: 24px; bottom: 20px; right: 20px; }
        }
    </style>
</head>
<body>
