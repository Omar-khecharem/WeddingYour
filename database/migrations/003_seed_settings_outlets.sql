-- Store settings
INSERT IGNORE INTO `sg_settings` (`key`, `value`, `group`, `type`, `sort_order`, `is_public`) VALUES
('store_name', 'Shola Ghar', 'general', 'text', 1, 1),
('store_logo', '', 'general', 'image', 2, 1),
('store_favicon', '', 'general', 'image', 3, 0),
('store_email', 'contact@weddingyour.com', 'general', 'email', 4, 1),
('store_phone', '+33 1 23 45 67 89', 'general', 'text', 5, 1),
('store_address', '123 Rue de la Mode, Paris', 'general', 'textarea', 6, 1),
('social_facebook', 'https://facebook.com/weddingyour', 'social', 'url', 1, 1),
('social_instagram', 'https://instagram.com/weddingyour', 'social', 'url', 2, 1),
('social_youtube', 'https://youtube.com/@weddingyour', 'social', 'url', 3, 1),
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
('WeddingYour Kolkata', 'weddingyour-kolkata', 'Flagship store in the heart of Kolkata', '123 Park Street', 'Kolkata', 'West Bengal', '+91 33 1234 5678', 'kolkata@weddingyour.com', 22.5726, 88.3639, 'https://maps.google.com/?q=WeddingYour+Kolkata', 1),
('WeddingYour Delhi', 'weddingyour-delhi', 'Premium wedding accessories boutique', '45 Connaught Place', 'Delhi', 'Delhi', '+91 11 2345 6789', 'delhi@weddingyour.com', 28.6139, 77.2090, 'https://maps.google.com/?q=WeddingYour+Delhi', 2),
('WeddingYour Mumbai', 'weddingyour-mumbai', 'Mumbai wedding specialists', '78 Linking Road', 'Mumbai', 'Maharashtra', '+91 22 3456 7890', 'mumbai@weddingyour.com', 19.0760, 72.8777, 'https://maps.google.com/?q=WeddingYour+Mumbai', 3),
('WeddingYour Bangalore', 'weddingyour-bangalore', 'Elegant bridal collections', '12 MG Road', 'Bangalore', 'Karnataka', '+91 80 4567 8901', 'bangalore@weddingyour.com', 12.9716, 77.5946, 'https://maps.google.com/?q=WeddingYour+Bangalore', 4),
('WeddingYour Hyderabad', 'weddingyour-hyderabad', 'South India boutique', '56 Banjara Hills', 'Hyderabad', 'Telangana', '+91 40 5678 9012', 'hyderabad@weddingyour.com', 17.3850, 78.4867, 'https://maps.google.com/?q=WeddingYour+Hyderabad', 5);

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
