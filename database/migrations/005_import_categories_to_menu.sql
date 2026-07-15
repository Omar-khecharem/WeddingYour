-- =============================================================================
-- IMPORT CATEGORIES INTO MENU
-- Links menu items to actual categories/subcategories in the database
-- =============================================================================

USE `shola_ghar`;

-- +----------------------------------------------------------------------------
-- 1. Add missing subcategories for BRIDE (category_id = 2 - Mukut Mariée)
-- +----------------------------------------------------------------------------
INSERT IGNORE INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(6,  2, 'Bridal Patashi / Mukut',  'mukut-bridal-patashi',  1, 1),
(7,  2, 'Sithi / Small Mukut',     'mukut-sithi-small',     2, 1),
(8,  2, 'Crown & 3 Pieces Set',    'mukut-crown-3-pieces',  3, 1);

-- +----------------------------------------------------------------------------
-- 2. Add missing subcategories for GROOM (category_id = 3 - Topor Marié)
-- +----------------------------------------------------------------------------
INSERT IGNORE INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(9,  3, 'Topor Mukut Set',      'topor-mukut-set',      1, 1),
(10, 3, 'Topor (Without Mukut)', 'topor-without-mukut',  2, 1),
(11, 3, 'Dorpon',               'topor-dorpon',         3, 1),
(12, 3, 'Kunke',                'topor-kunke',          4, 1),
(13, 3, 'Boron / Khoidan Kulo', 'topor-boron-khoidan',  5, 1);

-- +----------------------------------------------------------------------------
-- 3. Add missing subcategories for BABY (category_id = 1 - Bébé Mukut)
-- +----------------------------------------------------------------------------
INSERT IGNORE INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(14, 1, 'Baby Topor (Boy)',   'baby-topor-boy',   1, 1),
(15, 1, 'Baby Mukut (Girl)',  'baby-mukut-girl',  2, 1),
(16, 1, 'Nitbor Topor (Boy)', 'nitbor-topor-boy', 3, 1);

-- +----------------------------------------------------------------------------
-- 4. Add missing subcategories for WEDDING ITEMS (category_id = 4 - Articles Mariage)
-- +----------------------------------------------------------------------------
INSERT IGNORE INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(17, 4, 'Panpata',              'articles-panpata',       1, 1),
(18, 4, 'Piri',                 'articles-piri',          2, 1),
(19, 4, 'Boron / Khoidan Kulo', 'articles-boron-khoidan', 3, 1),
(20, 4, 'Tattwa Suchi',         'tattwa-suchi',           4, 1),
(21, 4, 'Tattwa Tray',          'tattwa-tray',            5, 1),
(22, 4, 'Haldi Platter',        'haldi-platter',          6, 1),
(23, 4, 'Haldi Jewellery',      'haldi-jewellery',        7, 1);

-- +----------------------------------------------------------------------------
-- 5. Add missing subcategories for SHOLA'S JEWELLERY (category_id = 5 - Gachhkouto & Dorpon)
-- +----------------------------------------------------------------------------
INSERT IGNORE INTO `sg_subcategories` (`id`, `category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(24, 5, 'Matha Patti',            'matha-patti',               1, 1),
(25, 5, 'Mini Crown',             'mini-crown',                2, 1),
(26, 5, 'Bridal Sithi / Small Mukut', 'shola-sithi-small',     3, 1),
(27, 5, 'Crown & 3 Pieces Set',   'shola-crown-3-pieces',     4, 1);

-- +----------------------------------------------------------------------------
-- 6. Link parent menu items to categories
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 2 WHERE `id` = 11; -- BRIDE → Mukut Mariée
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 3 WHERE `id` = 12; -- GROOM → Topor Marié
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 1 WHERE `id` = 13; -- BABY → Bébé Mukut
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 4 WHERE `id` = 14; -- WEDDING ITEMS → Articles Mariage
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 5 WHERE `id` = 15; -- SHOLA'S JEWELLERY → Gachhkouto & Dorpon

-- +----------------------------------------------------------------------------
-- 7. Link BRIDE child items to subcategories (parent_id = 11)
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 6  WHERE `id` = 18; -- Bridal Patashi / Mukut
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 7  WHERE `id` = 19; -- Sithi / Small Mukut
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 8  WHERE `id` = 20; -- Crown & 3 Pieces Set
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 19 WHERE `id` = 21; -- Boron / Khoidan Kulo (Articles Mariage)
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 24 WHERE `id` = 22; -- Gach kouto → Matha Patti
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 17 WHERE `id` = 23; -- Panpata
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 18 WHERE `id` = 24; -- Piri

-- +----------------------------------------------------------------------------
-- 8. Link GROOM child items to subcategories (parent_id = 12)
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 9  WHERE `id` = 25; -- Topor Mukut Set
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 10 WHERE `id` = 26; -- Topor (Without Mukut)
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 11 WHERE `id` = 27; -- Dorpon
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 12 WHERE `id` = 28; -- Kunke
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 13 WHERE `id` = 29; -- Boron / Khoidan Kulo

-- +----------------------------------------------------------------------------
-- 9. Link BABY child items to subcategories (parent_id = 13)
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 14 WHERE `id` = 30; -- Baby Topor (Boy)
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 15 WHERE `id` = 31; -- Baby Mukut (Girl)
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 16 WHERE `id` = 32; -- Nitbor Topor (Boy)

-- +----------------------------------------------------------------------------
-- 10. Link WEDDING ITEMS child items to subcategories (parent_id = 14)
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 17 WHERE `id` = 33; -- Panpata
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 18 WHERE `id` = 34; -- Piri
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 19 WHERE `id` = 35; -- Boron / Khoidan Kulo
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 20 WHERE `id` = 36; -- Tattwa Suchi
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 21 WHERE `id` = 37; -- Tattwa Tray
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 22 WHERE `id` = 38; -- Haldi Platter
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 23 WHERE `id` = 39; -- Haldi Jewellery

-- +----------------------------------------------------------------------------
-- 11. Link SHOLA'S JEWELLERY child items to subcategories (parent_id = 15)
-- +----------------------------------------------------------------------------
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 24 WHERE `id` = 40; -- Matha Patti
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 25 WHERE `id` = 41; -- Mini Crown
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 26 WHERE `id` = 42; -- Bridal Sithi / Small Mukut
UPDATE `sg_menu_items` SET `type` = 'category', `reference_id` = 27 WHERE `id` = 43; -- Crown & 3 Pieces Set
