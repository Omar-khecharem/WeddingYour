-- Browse Categories Menu for navbar
INSERT IGNORE INTO `sg_menus` (`id`, `name`, `slug`, `location`, `is_active`) VALUES
(3, 'Browse Categories', 'browse-categories', 'categories_dropdown', 1);

-- Menu items for Browse Categories (parent items linking to categories)
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(11, 3, NULL, 'BRIDE',             NULL, 'category', 2, 1, 1),
(12, 3, NULL, 'GROOM',             NULL, 'category', 3, 2, 1),
(13, 3, NULL, 'BABY',              NULL, 'category', 1, 3, 1),
(14, 3, NULL, 'WEDDING ITEMS',     NULL, 'category', 4, 4, 1),
(15, 3, NULL, "SHOLA'S JEWELLERY", NULL, 'category', 5, 5, 1),
(16, 3, NULL, 'Best Seller',       '/products?sort=popular', 'custom', NULL, 6, 1),
(17, 3, NULL, 'Exclusive',         '/products?featured=1',   'custom', NULL, 7, 1);

-- BRIDE sub-items (parent_id = 11) linking to subcategories
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(18, 3, 11, 'Bridal Patashi / Mukut',  NULL, 'category', 6,  1, 1),
(19, 3, 11, 'Sithi / Small Mukut',     NULL, 'category', 7,  2, 1),
(20, 3, 11, 'Crown & 3 Pieces Set',    NULL, 'category', 8,  3, 1),
(21, 3, 11, 'Boron / Khoidan Kulo',    NULL, 'category', 19, 4, 1),
(22, 3, 11, 'Gach kouto',              NULL, 'category', 24, 5, 1),
(23, 3, 11, 'Panpata',                 NULL, 'category', 17, 6, 1),
(24, 3, 11, 'Piri',                    NULL, 'category', 18, 7, 1);

-- GROOM sub-items (parent_id = 12)
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(25, 3, 12, 'Topor Mukut Set',      NULL, 'category', 9,  1, 1),
(26, 3, 12, 'Topor (Without Mukut)', NULL, 'category', 10, 2, 1),
(27, 3, 12, 'Dorpon',               NULL, 'category', 11, 3, 1),
(28, 3, 12, 'Kunke',                NULL, 'category', 12, 4, 1),
(29, 3, 12, 'Boron / Khoidan Kulo', NULL, 'category', 13, 5, 1);

-- BABY sub-items (parent_id = 13)
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(30, 3, 13, 'Baby Topor (Boy)',   NULL, 'category', 14, 1, 1),
(31, 3, 13, 'Baby Mukut (Girl)',  NULL, 'category', 15, 2, 1),
(32, 3, 13, 'Nitbor Topor (Boy)', NULL, 'category', 16, 3, 1);

-- WEDDING ITEMS sub-items (parent_id = 14)
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(33, 3, 14, 'Panpata',              NULL, 'category', 17, 1, 1),
(34, 3, 14, 'Piri',                 NULL, 'category', 18, 2, 1),
(35, 3, 14, 'Boron / Khoidan Kulo', NULL, 'category', 19, 3, 1),
(36, 3, 14, 'Tattwa Suchi',         NULL, 'category', 20, 4, 1),
(37, 3, 14, 'Tattwa Tray',          NULL, 'category', 21, 5, 1),
(38, 3, 14, 'Haldi Platter',        NULL, 'category', 22, 6, 1),
(39, 3, 14, 'Haldi Jewellery',      NULL, 'category', 23, 7, 1);

-- SHOLA'S JEWELLERY sub-items (parent_id = 15)
INSERT IGNORE INTO `sg_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `type`, `reference_id`, `sort_order`, `is_active`) VALUES
(40, 3, 15, 'Matha Patti',            NULL, 'category', 24, 1, 1),
(41, 3, 15, 'Mini Crown',             NULL, 'category', 25, 2, 1),
(42, 3, 15, 'Bridal Sithi / Small Mukut', NULL, 'category', 26, 3, 1),
(43, 3, 15, 'Crown & 3 Pieces Set',   NULL, 'category', 27, 4, 1);
