-- =============================================================================
-- SHOLA GHAR — SEED DATA
-- =============================================================================

USE `shola_ghar`;

-- +----------------------------------------------------------------------------
-- 1. COUNTRIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `phone_code`, `currency_code`, `currency_symbol`, `locale`, `status`, `sort_order`) VALUES
(1, 'France',          'FR', 'FRA', '+33', 'EUR', '€', 'fr_FR', 1, 1),
(2, 'Belgique',        'BE', 'BEL', '+32', 'EUR', '€', 'fr_BE', 1, 2),
(3, 'Suisse',          'CH', 'CHE', '+41', 'CHF', 'CHF', 'fr_CH', 1, 3),
(4, 'Canada',          'CA', 'CAN', '+1',  'CAD', 'C$', 'fr_CA', 1, 4),
(5, 'Maroc',           'MA', 'MAR', '+212','MAD', 'MAD', 'fr_MA', 1, 5),
(6, 'Tunisie',         'TN', 'TUN', '+216','TND', 'TND', 'fr_TN', 1, 6),
(7, 'Sénégal',         'SN', 'SEN', '+221','XOF', 'CFA', 'fr_SN', 1, 7),
(8, 'Côte d\'Ivoire',  'CI', 'CIV', '+225','XOF', 'CFA', 'fr_CI', 1, 8);

-- +----------------------------------------------------------------------------
-- 2. CURRENCIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_currencies` (`id`, `name`, `code`, `symbol`, `symbol_position`, `decimal_places`, `decimal_sep`, `thousand_sep`, `exchange_rate`, `is_default`, `status`) VALUES
(1, 'Euro',       'EUR', '€', 'before', 2, ',', ' ', 1.000000, 1, 1),
(2, 'Franc Suisse','CHF','CHF','before', 2, '.', '\'', 1.050000, 0, 1),
(3, 'Dollar Canadien','CAD','C$','before', 2, '.', ',', 1.480000, 0, 1),
(4, 'Dirham Marocain','MAD','MAD','before', 2, '.', ',', 10.850000, 0, 1),
(5, 'Franc CFA',  'XOF', 'CFA', 'after', 0, '-', ' ', 655.957000, 0, 1);

-- +----------------------------------------------------------------------------
-- 3. LANGUAGES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_languages` (`id`, `name`, `code`, `locale`, `direction`, `is_default`, `status`, `sort_order`) VALUES
(1, 'Français', 'fr', 'fr_FR', 'ltr', 1, 1, 1),
(2, 'English',  'en', 'en_US', 'ltr', 0, 1, 2),
(3, 'العربية',  'ar', 'ar_MA', 'rtl', 0, 1, 3);

-- +----------------------------------------------------------------------------
-- 4. ROLES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_roles` (`id`, `name`, `slug`, `description`, `is_system`) VALUES
(1, 'Super Admin',  'super-admin',  'Full system access', 1),
(2, 'Admin',        'admin',        'Backend administrator', 1),
(3, 'Manager',      'manager',      'Store manager', 1),
(4, 'Customer',     'customer',     'Registered customer', 1);

-- +----------------------------------------------------------------------------
-- 5. PERMISSIONS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_permissions` (`id`, `name`, `slug`, `group`) VALUES
(1,  'Voir tableau de bord',       'dashboard.view',       'dashboard'),
(2,  'Gérer les produits',         'products.manage',      'products'),
(3,  'Créer des produits',         'products.create',      'products'),
(4,  'Modifier des produits',      'products.edit',        'products'),
(5,  'Supprimer des produits',     'products.delete',      'products'),
(6,  'Gérer les catégories',       'categories.manage',    'categories'),
(7,  'Gérer les commandes',        'orders.manage',        'orders'),
(8,  'Voir les commandes',         'orders.view',          'orders'),
(9,  'Modifier les commandes',     'orders.edit',          'orders'),
(10, 'Gérer les clients',          'customers.manage',     'customers'),
(11, 'Gérer les coupons',          'coupons.manage',       'marketing'),
(12, 'Gérer les utilisateurs',     'users.manage',         'users'),
(13, 'Gérer les paramètres',       'settings.manage',      'settings'),
(14, 'Voir les rapports',          'reports.view',         'reports'),
(15, 'Gérer le contenu',           'content.manage',       'content'),
(16, 'Gérer les avis',             'reviews.manage',       'reviews'),
(17, 'Exporter les données',       'export.data',          'system'),
(18, 'Voir les logs',              'logs.view',            'system');

-- +----------------------------------------------------------------------------
-- 6. ROLE-PERMISSION
-- +----------------------------------------------------------------------------
INSERT INTO `sg_role_permission` (`role_id`, `permission_id`) VALUES
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),
(2,1),(2,2),(2,3),(2,4),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,13),(2,14),(2,15),(2,16),
(3,1),(3,2),(3,3),(3,4),(3,7),(3,8),(3,10),(3,14),(3,16);

-- +----------------------------------------------------------------------------
-- 7. USERS (passwords: admin123 / customer123)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_users` (`id`, `role_id`, `name`, `email`, `phone`, `password`, `status`, `locale`) VALUES
(1, 1, 'Admin',     'admin@sholaghar.com',   '+33 6 12 34 56 78', '$2y$12$LJ3m4ys3Lk0TSwHnbfOMiOXPm1Qlq5GzVxY0y8Jqh1kR7f5dKz9uS', 1, 'fr'),
(2, 4, 'Sophie Martin', 'sophie@example.com','+33 6 98 76 54 32', '$2y$12$LJ3m4ys3Lk0TSwHnbfOMiOXPm1Qlq5GzVxY0y8Jqh1kR7f5dKz9uS', 1, 'fr');

-- +----------------------------------------------------------------------------
-- 8. CUSTOMERS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_customers` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `newsletter`, `status`) VALUES
(1, 2, 'Sophie', 'Martin', 'sophie@example.com', '+33 6 98 76 54 32', 1, 1);

-- +----------------------------------------------------------------------------
-- 9. CATEGORIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_categories` (`id`, `parent_id`, `name`, `slug`, `description`, `sort_order`, `featured`, `status`) VALUES
(1, NULL, 'Bébé Mukut',       'bebe-mukut',       'Mukut traditionnel pour bébé',             1, 1, 1),
(2, NULL, 'Mukut Mariée',     'mukut-mariee',     'Mukut de mariée élégant',                   2, 1, 1),
(3, NULL, 'Topor Marié',      'topor-marie',      'Topor traditionnel pour le marié',          3, 1, 1),
(4, NULL, 'Articles Mariage', 'articles-mariage', 'Accessoires complets de mariage',           4, 1, 1),
(5, NULL, 'Gachhkouto & Dorpon','gachhkouto-dorpon','Articles traditionnels Gachhkouto',        5, 0, 1);

-- +----------------------------------------------------------------------------
-- 10. SUBCATEGORIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 2, 'Mukut Blanc',  'mukut-blanc',  1, 1),
(2, 2, 'Mukut Rouge',  'mukut-rouge',  2, 1),
(3, 2, 'Mukut Doré',   'mukut-dore',   3, 1),
(4, 3, 'Topor Simple', 'topor-simple', 1, 1),
(5, 3, 'Topor Royal',  'topor-royal',  2, 1);

-- +----------------------------------------------------------------------------
-- 11. BRANDS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_brands` (`id`, `name`, `slug`, `description`, `featured`, `status`) VALUES
(1, 'Shola Ghar',    'shola-ghar',    'Marque premium Shola Ghar',    1, 1),
(2, 'Artisan Bengal','artisan-bengal','Artisans du Bengale',          0, 1),
(3, 'Traditional Luxe','trad-luxe',   'Collection luxe traditionnelle',1, 1);

-- +----------------------------------------------------------------------------
-- 12. PRODUCTS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_products` (`id`, `category_id`, `subcategory_id`, `brand_id`, `name`, `slug`, `short_description`, `description`, `sku`, `regular_price`, `sale_price`, `discount_percent`, `stock_quantity`, `stock_status`, `is_featured`, `is_new`, `is_trending`, `is_bestseller`, `rating_avg`, `rating_count`, `status`) VALUES
(1, 2, 1, 1, 'Mukut Noyoni',         'mukut-noyoni',         'Magnifique mukut de mariée Noyoni fait main',            '<p>Mukut Noyoni de haute qualité fabriqué en Sholapith traditionnel. Parfait pour les mariées qui souhaitent être élégantes.</p>',         'NM-001', 1499.00, 799.00, 47, 25, 'in_stock', 1, 1, 1, 1, 4.80, 24, 1),
(2, 2, 2, 1, 'Mukut Poddosree',      'mukut-poddosree',      'Mukut de mariée Poddosree exclusif',                     '<p>Mukut Poddosree avec travail traditionnel en shola. Un mélange parfait de tradition et d\'élégance.</p>',                              'PM-001', 1499.00, 799.00, 47, 20, 'in_stock', 1, 1, 1, 0, 4.50, 18, 1),
(3, 2, 3, 2, 'Mukut Purna',          'mukut-purna',          'Ensemble mukut Purna premium',                           '<p>Ensemble complet mukut Purna pour mariée. Travail traditionnel en shola avec accents dorés.</p>',                                       'PM-002', 1299.00, 799.00, 38, 15, 'in_stock', 1, 0, 1, 0, 4.30, 12, 1),
(4, 2, 1, 1, 'Mukut Lili',           'mukut-lili',           'Mukut Lili élégant pour mariée',                         '<p>Magnifique Mukut Lili avec délicat travail en shola. Léger et confortable.</p>',                                                         'LM-001', 1399.00, 799.00, 43, 30, 'in_stock', 1, 1, 1, 1, 4.60, 15, 1),
(5, 3, 4, 1, 'Topor Traditionnel',    'topor-traditionnel',   'Topor traditionnel classique pour marié',                '<p>Topor bengali traditionnel pour le marié. Fabriqué à la main en sholapith de première qualité.</p>',                                     'TT-001', 999.00, 599.00, 40, 35, 'in_stock', 1, 0, 1, 1, 4.90, 30, 1),
(6, 3, 5, 3, 'Ensemble Topor Royal', 'ensemble-topor-royal', 'Ensemble topor royal premium avec accessoires',          '<p>Ensemble complet topor royal pour le marié avec accessoires assortis.</p>',                                                              'RT-001', 1999.00, 1299.00, 35, 10, 'in_stock', 1, 1, 0, 0, 5.00, 8,  1),
(7, 1, NULL, 1, 'Mukut Bébé',         'mukut-bebe',          'Mukut traditionnel pour bébé',                           '<p>Magnifique mukut bébé en sholapith pour cérémonies traditionnelles.</p>',                                                                'BM-001', 899.00, 499.00, 45, 50, 'in_stock', 1, 1, 1, 0, 4.70, 22, 1),
(8, 1, NULL, 3, 'Mukut Bébé Premium', 'mukut-bebe-premium',  'Mukut bébé premium avec accents dorés',                  '<p>Mukut bébé premium avec travail complexe en shola et détails dorés.</p>',                                                               'BM-002', 1299.00, 799.00, 38, 20, 'in_stock', 0, 0, 0, 0, 4.40, 9,  1),
(9, 4, NULL, 1, 'Ensemble Mariage Mukut & Topor','ensemble-mariage-mukut-topor','Ensemble complet mariage mukut et topor','<p>Ensemble complet incluant mukut de mariée et topor de marié. Ensemble assorti parfait pour le couple.</p>',                            'WM-001', 2499.00, 1499.00, 40, 15, 'in_stock', 1, 1, 1, 1, 4.80, 16, 1),
(10,5, NULL, 2, 'Ensemble Gachhkouto','ensemble-gachhkouto', 'Ensemble Gachhkouto traditionnel',                       '<p>Ensemble Gachhkouto traditionnel fabriqué à la main en matériaux premium.</p>',                                                          'GS-001', 1799.00, 999.00, 44, 10, 'in_stock', 0, 0, 0, 0, 4.20, 5,  1);

-- +----------------------------------------------------------------------------
-- 13. PRODUCT IMAGES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_product_images` (`product_id`, `image`, `alt_text`, `is_primary`, `sort_order`) VALUES
(1, 'noyoni-mukut-1.jpg',    'Mukut Noyoni – Vue de face',  1, 0),
(2, 'poddosree-mukut-1.jpg', 'Mukut Poddosree – Vue de face',1, 0),
(3, 'purna-mukut-1.jpg',     'Mukut Purna – Vue de face',   1, 0),
(4, 'lili-mukut-1.jpg',      'Mukut Lili – Vue de face',    1, 0),
(5, 'topor-traditionnel-1.jpg','Topor – Vue de face',       1, 0),
(6, 'topor-royal-1.jpg',     'Ensemble Topor Royal',        1, 0),
(7, 'mukut-bebe-1.jpg',      'Mukut Bébé – Vue de face',   1, 0),
(8, 'mukut-bebe-premium-1.jpg','Mukut Bébé Premium',        1, 0),
(9, 'ensemble-mariage-1.jpg','Ensemble Mariage',             1, 0),
(10,'gachhkouto-1.jpg',      'Ensemble Gachhkouto',          1, 0);

-- +----------------------------------------------------------------------------
-- 14. TAGS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_tags` (`id`, `name`, `slug`) VALUES
(1, 'Meilleure vente',   'meilleure-vente'),
(2, 'Nouveauté',         'nouveaute'),
(3, 'Édition limitée',   'edition-limitee'),
(4, 'Fait main',         'fait-main'),
(5, 'Premium',           'premium');

-- +----------------------------------------------------------------------------
-- 15. PRODUCT-TAG
-- +----------------------------------------------------------------------------
INSERT INTO `sg_product_tag` (`product_id`, `tag_id`) VALUES
(1,1),(1,4),(2,1),(2,4),(3,1),(4,2),(4,4),(5,1),(5,4),
(6,3),(6,5),(7,2),(7,4),(8,5),(9,1),(9,5),(10,4);

-- +----------------------------------------------------------------------------
-- 16. COUPONS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_coupons` (`id`, `code`, `type`, `value`, `min_order_amount`, `max_discount`, `usage_limit`, `description`, `is_active`) VALUES
(1, 'BIENVENUE10', 'percentage', 10, 0,    300.00, 500, 'Bienvenue – 10% de réduction pour les nouveaux clients', 1),
(2, 'MARIAGE20',   'percentage', 20, 999.00, 500.00, 100, '20% DE RÉDUCTION sur Mukut & Topor',                  1),
(3, 'LIVRAISON',   'fixed',      49, 499.00, 49.00,  200, 'Livraison standard offerte',                           1);

-- +----------------------------------------------------------------------------
-- 17. ADDRESSES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_addresses` (`id`, `user_id`, `customer_id`, `type`, `label`, `full_name`, `phone`, `address_line1`, `city`, `state`, `postal_code`, `country_id`, `is_default`) VALUES
(1, 2, 1, 'both', 'Domicile', 'Sophie Martin', '+33 6 98 76 54 32', '15 Rue de la Paix', 'Paris', 'Île-de-France', '75001', 1, 1);

-- +----------------------------------------------------------------------------
-- 18. SHIPPING METHODS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_shipping_methods` (`id`, `name`, `slug`, `description`, `base_rate`, `free_above`, `estimated_days_min`, `estimated_days_max`, `has_tracking`, `status`, `sort_order`) VALUES
(1, 'Standard',   'standard',   'Livraison standard – 5 à 7 jours',    4.90,  49.00, 5, 7,  0, 1, 1),
(2, 'Express',    'express',    'Livraison express – 2 à 3 jours',     9.90,  99.00, 2, 3,  1, 1, 2),
(3, 'Point Relais','point-relais','Livraison en point relais – 4 à 6 jours', 3.90, 39.00, 4, 6, 0, 1, 3);

-- +----------------------------------------------------------------------------
-- 19. PAYMENT METHODS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_payment_methods` (`id`, `name`, `slug`, `description`, `is_online`, `fee_type`, `status`, `sort_order`) VALUES
(1, 'Carte Bancaire',  'carte-bancaire',  'Paiement par carte bancaire (Visa, Mastercard)',      1, 'percentage', 1, 1),
(2, 'PayPal',          'paypal',          'Paiement sécurisé via PayPal',                         1, 'percentage', 1, 2),
(3, 'Virement Bancaire','virement',       'Virement bancaire direct',                             0, 'none',      1, 3),
(4, 'Paiement à la livraison','cod',      'Paiement à la livraison (COD)',                        0, 'fixed',     1, 4);

-- +----------------------------------------------------------------------------
-- 20. REVIEWS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_reviews` (`product_id`, `user_id`, `customer_id`, `name`, `email`, `rating`, `comment`, `is_verified`, `is_approved`) VALUES
(1, 2, 1, 'Sophie Martin',  'sophie@example.com',  5, 'Les collections sont magnifiques ! Le personnel a été très utile pour choisir le mukut parfait. Je recommande vivement !', 1, 1),
(2, 2, 1, 'Sophie Martin',  'sophie@example.com',  5, 'Expérience merveilleuse. L\'art traditionnel du shola est parfaitement préservé ici.',  1, 1),
(5, 2, 1, 'Sophie Martin',  'sophie@example.com',  5, 'Meilleur endroit pour acheter un Topor authentique. Finition excellente et prix raisonnables.', 1, 1);

-- +----------------------------------------------------------------------------
-- 21. BLOG CATEGORIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_blog_categories` (`id`, `name`, `slug`, `description`, `status`, `sort_order`) VALUES
(1, 'Conseils Mariage',   'conseils-mariage',   'Conseils et astuces pour votre mariage',      1, 1),
(2, 'Traditions',         'traditions',         'Articles sur les traditions bengalies',        1, 2),
(3, 'Tendances',          'tendances',          'Les dernières tendances en accessoires mariage',1, 3);

-- +----------------------------------------------------------------------------
-- 22. BLOGS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_blogs` (`id`, `category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `is_published`, `published_at`) VALUES
(1, 1, 1, 'Comment choisir son Mukut de mariée', 'comment-choisir-mukut-mariee', 'Guide complet pour choisir le mukut parfait pour votre mariage.', '<p>Le mukut est l\'accessoire le plus important pour une mariée bengalie. Voici comment choisir celui qui vous convient.</p>', 1, NOW()),
(2, 2, 1, 'Les traditions du Sholapith au Bengale', 'traditions-sholapith-bengale', 'Découvrez l\'art ancestral du travail du sholapith.', '<p>Le sholapith est un art traditionnel du Bengale occidental qui remonte à plusieurs siècles.</p>', 1, NOW()),
(3, 3, 1, 'Tendances 2026 : Mukut et Topor', 'tendances-2026-mukut-topor', 'Les tendances actuelles en matière de mukut et topor.', '<p>Découvrez les tendances de cette année pour les accessoires de mariage traditionnels.</p>', 1, NOW());

-- +----------------------------------------------------------------------------
-- 23. PAGES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_pages` (`id`, `title`, `slug`, `content`, `status`, `sort_order`) VALUES
(1, 'À propos',          'a-propos',        '<h2>Bienvenue chez Shola Ghar</h2><p>Shola Ghar est le leader français du Mukut et Topor de mariage en Sholapith fait main.</p>', 1, 1),
(2, 'Livraison & Retours','livraison-retours','<h2>Politique de livraison</h2><p>Nous livrons dans toute la France.</p><h2>Retours</h2><p>Retours acceptés sous 7 jours.</p>', 1, 2),
(3, 'Politique de confidentialité','confidentialite','<h2>Confidentialité</h2><p>Vos données sont protégées.</p>', 1, 3),
(4, 'CGV',               'cgv',             '<h2>Conditions générales de vente</h2>', 1, 4);

-- +----------------------------------------------------------------------------
-- 24. SLIDERS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_sliders` (`id`, `title`, `subtitle`, `description`, `image`, `sort_order`, `is_active`) VALUES
(1, 'Collection Mariage 2026', 'L\'élégance traditionnelle',   'Découvrez notre nouvelle collection de mukut et topor',  'slide-mariage-2026.jpg', 1, 1),
(2, 'Mukut de Mariée',         'Parfait pour votre jour J',   'Mukut faits main par nos artisans',                     'slide-mukut.jpg',        2, 1),
(3, 'Topor pour Marié',        'Soyez élégant',               'Topor traditionnel et moderne',                          'slide-topor.jpg',        3, 1);

-- +----------------------------------------------------------------------------
-- 25. BANNERS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_banners` (`id`, `name`, `title`, `description`, `image`, `position`, `is_active`) VALUES
(1, 'Bannière été',       'Promo été – 20%',     'Réduction sur tous les mukut', 'banner-ete.jpg',   'home_top', 1),
(2, 'Bannière livraison', 'Livraison offerte',   'Dès 49€ d\'achat',             'banner-livraison.jpg','sidebar', 1);

-- +----------------------------------------------------------------------------
-- 26. FAQ CATEGORIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_faq_categories` (`id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 'Commandes',   'commandes',   1, 1),
(2, 'Livraison',   'livraison',   2, 1),
(3, 'Produits',    'produits',    3, 1),
(4, 'Retours',     'retours',     4, 1);

-- +----------------------------------------------------------------------------
-- 27. FAQ
-- +----------------------------------------------------------------------------
INSERT INTO `sg_faq` (`id`, `category_id`, `question`, `answer`, `sort_order`, `status`) VALUES
(1, 1, 'Comment passer une commande ?',         'Ajoutez vos articles au panier puis suivez les étapes de paiement.', 1, 1),
(2, 2, 'Quels sont les délais de livraison ?',  'Livraison standard : 5-7 jours. Express : 2-3 jours.',              1, 1),
(3, 3, 'Les mukut sont-ils faits main ?',       'Oui, 100% faits main par nos artisans.',                            1, 1),
(4, 4, 'Puis-je retourner un article ?',        'Oui, sous 7 jours après réception.',                                 1, 1);

-- +----------------------------------------------------------------------------
-- 28. GALLERY CATEGORIES
-- +----------------------------------------------------------------------------
INSERT INTO `sg_gallery_categories` (`id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 'Mariages',    'mariages',    1, 1),
(2, 'Produits',    'produits',    2, 1),
(3, 'Artisanat',   'artisanat',   3, 1);

-- +----------------------------------------------------------------------------
-- 29. GALLERY
-- +----------------------------------------------------------------------------
INSERT INTO `sg_gallery` (`id`, `category_id`, `title`, `image`, `type`, `sort_order`, `status`) VALUES
(1, 1, 'Mariage traditionnel bengali',  'galerie-mariage-1.jpg',  'image', 1, 1),
(2, 1, 'Cérémonie de mariage',          'galerie-mariage-2.jpg',  'image', 2, 1),
(3, 2, 'Collection Mukut',              'galerie-collection.jpg', 'image', 1, 1);

-- +----------------------------------------------------------------------------
-- 30. MENUS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_menus` (`id`, `name`, `slug`, `location`, `is_active`) VALUES
(1, 'Menu principal',  'menu-principal',  'primary',   1),
(2, 'Menu footer',     'menu-footer',     'footer',    1);

-- +----------------------------------------------------------------------------
-- 31. MENU ITEMS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `sort_order`, `is_active`) VALUES
(1,  1, NULL, 'Accueil',       '/',              'custom', 1,  1),
(2,  1, NULL, 'Boutique',      '/products',      'custom', 2,  1),
(3,  1, 2,    'Mukut Mariée',  '/category/mukut-mariee',  'category', 1, 1),
(4,  1, 2,    'Topor Marié',   '/category/topor-marie',   'category', 2, 1),
(5,  1, 2,    'Mukut Bébé',    '/category/bebe-mukut',    'category', 3, 1),
(6,  1, NULL, 'À propos',      '/a-propos',      'page',    3,  1),
(7,  1, NULL, 'Contact',       '/contact',       'custom',  4,  1),
(8,  2, NULL, 'Mentions légales','/cgv',         'page',    1,  1),
(9,  2, NULL, 'Confidentialité','/confidentialite','page',  2,  1),
(10, 2, NULL, 'Livraison',     '/livraison-retours','page',3,  1);

-- +----------------------------------------------------------------------------
-- 32. SEO
-- +----------------------------------------------------------------------------
INSERT INTO `sg_seo` (`entity_type`, `entity_id`, `title`, `description`, `og_title`, `og_description`) VALUES
('home',     0, 'Shola Ghar – Mukut et Topor de Mariage Premium', 'Le leader français du Mukut et Topor de mariage en Sholapith fait main.', 'Shola Ghar – Mukut Mariage', 'Découvrez notre collection exceptionnelle de mukut et topor traditionnels.'),
('page',    1, 'À propos – Shola Ghar', 'Découvrez l\'histoire de Shola Ghar', NULL, NULL),
('category',2, 'Mukut Mariée – Shola Ghar', 'Collection de mukut de mariée', NULL, NULL);

-- +----------------------------------------------------------------------------
-- 33. SETTINGS
-- +----------------------------------------------------------------------------
INSERT INTO `sg_settings` (`key`, `value`, `group`, `type`, `sort_order`, `is_public`) VALUES
('site_name',             'Shola Ghar',                                                   'general',  'text',     1, 1),
('site_tagline',          'C\'est votre jour, vous êtes la célébrité...',                 'general',  'text',     2, 1),
('site_email',            'contact@sholaghar.fr',                                         'general',  'email',    3, 1),
('site_phone',            '+33 6 12 34 56 78',                                            'general',  'text',     4, 1),
('site_address',          '15 Rue de la Paix, 75001 Paris, France',                       'general',  'textarea', 5, 1),
('whatsapp_number',       '33612345678',                                                  'social',   'text',     6, 1),
('whatsapp_message',      'Bonjour ! Je souhaite plus d\'informations.',                  'social',   'text',     7, 1),
('facebook_url',          'https://facebook.com/sholaghar',                               'social',   'url',      8, 1),
('instagram_url',         'https://instagram.com/sholaghar',                              'social',   'url',      9, 1),
('youtube_url',           'https://youtube.com/@sholaghar',                               'social',   'url',      10,1),
('tax_rate',              '20',                                                           'tax',      'number',   11,0),
('tax_name',              'TVA',                                                          'tax',      'text',     12,0),
('free_shipping_min',     '49',                                                           'shipping', 'number',   13,1),
('standard_shipping',     '4.90',                                                         'shipping', 'number',   14,1),
('express_shipping',      '9.90',                                                         'shipping', 'number',   15,1),
('meta_title',            'Shola Ghar – Mukut & Topor de Mariage Premium – France',       'seo',      'text',     16,1),
('meta_description',      'Le leader français du Mukut et Topor de mariage en Sholapith fait main. Livraison dans toute la France.', 'seo', 'textarea', 17,1),
('meta_keywords',         'shola ghar, mukut mariage, topor marié, sholapith, accessoires mariage', 'seo', 'text', 18,1),
('currency',              '€',                                                            'general',  'text',     19,1),
('currency_code',         'EUR',                                                          'general',  'text',     20,1),
('maintenance_mode',      '0',                                                            'system',   'boolean',  21,0),
('store_open',            '1',                                                            'system',   'boolean',  22,0);

-- +----------------------------------------------------------------------------
-- 34. PASSWORD RESETS (none by default)
-- +----------------------------------------------------------------------------

-- +----------------------------------------------------------------------------
-- 35. NEWSLETTER
-- +----------------------------------------------------------------------------
INSERT INTO `sg_newsletter` (`id`, `email`, `name`, `is_active`) VALUES
(1, 'sophie@example.com', 'Sophie Martin', 1);

-- +----------------------------------------------------------------------------
-- 36. CONTACT MESSAGES (sample)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`) VALUES
(1, 'Jean Dupont', 'jean@example.com', 'Question sur les délais', 'Bonjour, quels sont les délais pour un mukut personnalisé ? Merci.', 0);

-- +----------------------------------------------------------------------------
-- END OF SEED DATA
-- +----------------------------------------------------------------------------
