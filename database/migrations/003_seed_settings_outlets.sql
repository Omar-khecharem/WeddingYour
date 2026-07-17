-- Store settings
INSERT IGNORE INTO `sg_settings` (`key`, `value`, `group`, `type`, `sort_order`, `is_public`) VALUES
('store_name', 'Shola Ghar', 'general', 'text', 1, 1),
('store_logo', '', 'general', 'image', 2, 1),
('store_favicon', '', 'general', 'image', 3, 0),
('store_email', 'contact@sholaghar.com', 'general', 'email', 4, 1),
('store_phone', '+33 1 23 45 67 89', 'general', 'text', 5, 1),
('store_address', '123 Rue de la Mode, Paris', 'general', 'textarea', 6, 1),
('social_facebook', 'https://facebook.com/sholaghar', 'social', 'url', 1, 1),
('social_instagram', 'https://instagram.com/sholaghar', 'social', 'url', 2, 1),
('social_youtube', 'https://youtube.com/@sholaghar', 'social', 'url', 3, 1),
('social_maps', 'https://maps.google.com/?q=Shola+Ghar+Paris', 'social', 'url', 4, 1),
('homepage_video_url', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'homepage', 'url', 1, 0),
('homepage_video_poster', '', 'homepage', 'image', 2, 0),
('homepage_banner_title', 'FLAT 20% OFF', 'homepage', 'text', 3, 1),
('homepage_banner_subtitle', 'On All Wedding Collection', 'homepage', 'text', 4, 1),
('homepage_banner_link', '/products?category=wedding', 'homepage', 'url', 5, 1),
('homepage_promotional_banner', '', 'homepage', 'image', 6, 1),
('homepage_promotional_link', '/products', 'homepage', 'url', 7, 1),
('homepage_memories_title', 'Have Some Memories!', 'homepage', 'text', 8, 1),
('homepage_video_section_url', '', 'homepage', 'url', 9, 0),
('homepage_video_section_title', 'Atelier de Création', 'homepage', 'text', 10, 1);

-- Sample outlets
INSERT IGNORE INTO `sg_outlets` (`name`, `slug`, `description`, `address`, `city`, `state`, `phone`, `email`, `latitude`, `longitude`, `google_maps_link`, `sort_order`) VALUES
('Shola Ghar Paris', 'shola-ghar-paris', 'Flagship store in the heart of Paris', '123 Rue de la Mode', 'Paris', 'Île-de-France', '+33 1 23 45 67 89', 'paris@sholaghar.com', 48.8566, 2.3522, 'https://maps.google.com/?q=Shola+Ghar+Paris', 1),
('Shola Ghar Lyon', 'shola-ghar-lyon', 'Premium wedding accessories boutique', '45 Rue du Commerce', 'Lyon', 'Auvergne-Rhône-Alpes', '+33 4 56 78 90 12', 'lyon@sholaghar.com', 45.7640, 4.8357, 'https://maps.google.com/?q=Shola+Ghar+Lyon', 2),
('Shola Ghar Marseille', 'shola-ghar-marseille', 'Mediterranean wedding specialists', '78 Canebière', 'Marseille', 'Provence-Alpes-Côte d\'Azur', '+33 4 91 23 45 67', 'marseille@sholaghar.com', 43.2965, 5.3698, 'https://maps.google.com/?q=Shola+Ghar+Marseille', 3),
('Shola Ghar Bordeaux', 'shola-ghar-bordeaux', 'Elegant bridal collections', '12 Rue Sainte-Catherine', 'Bordeaux', 'Nouvelle-Aquitaine', '+33 5 67 89 01 23', 'bordeaux@sholaghar.com', 44.8378, -0.5792, 'https://maps.google.com/?q=Shola+Ghar+Bordeaux', 4),
('Shola Ghar Lille', 'shola-ghar-lille', 'Northern France boutique', '56 Rue de Béthune', 'Lille', 'Hauts-de-France', '+33 3 20 12 34 56', 'lille@sholaghar.com', 50.6292, 3.0573, 'https://maps.google.com/?q=Shola+Ghar+Lille', 5);

-- Homepage sections config
INSERT IGNORE INTO `sg_homepage_sections` (`section_key`, `title`, `subtitle`, `type`, `sort_order`, `is_active`) VALUES
('popular_creations', 'Nos Créations Populaires', 'Découvrez nos créations les plus appréciées', 'products', 1, 1),
('top_categories', 'Top Catégories', 'Catégories les plus populaires', 'categories', 2, 1),
('recent_products', 'Produits Récents', 'Les derniers ajoutés à notre collection', 'products', 3, 1);

-- Category cards for Mukut & Topor sections
INSERT IGNORE INTO `sg_category_cards` (`title`, `subtitle`, `section_key`, `sort_order`, `is_active`) VALUES
('Mukut & Topor', 'Traditional wedding crowns and headpieces', 'wedding_crowns', 1, 1),
('Wedding Items for All', 'Complete wedding collection for everyone', 'wedding_items', 2, 1),
('Gachhkouto & Dorpon', 'Traditional Gachhkouto and Dorpon items', 'traditional', 3, 1),
('Best Seller Items', 'Our most popular wedding essentials', 'bestsellers', 4, 1);
