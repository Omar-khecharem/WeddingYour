-- =============================================================================
-- UPDATE CATEGORIES & SUBCATEGORIES TO MATCH MENU STRUCTURE
-- =============================================================================

USE `shola_ghar`;

-- +----------------------------------------------------------------------------
-- 1. Update existing categories with English names matching the menu
-- +----------------------------------------------------------------------------
UPDATE `sg_categories` SET `name` = 'BRIDE',             `slug` = 'bride'             WHERE `id` = 2;
UPDATE `sg_categories` SET `name` = 'GROOM',             `slug` = 'groom'             WHERE `id` = 3;
UPDATE `sg_categories` SET `name` = 'BABY',              `slug` = 'baby'              WHERE `id` = 1;
UPDATE `sg_categories` SET `name` = 'WEDDING ITEMS',     `slug` = 'wedding-items'     WHERE `id` = 4;
UPDATE `sg_categories` SET `name` = "SHOLA'S JEWELLERY", `slug` = 'sholas-jewellery'  WHERE `id` = 5;

-- +----------------------------------------------------------------------------
-- 2. Update existing descriptions
-- +----------------------------------------------------------------------------
UPDATE `sg_categories` SET `description` = 'Bridal mukut, patashi, crowns and wedding accessories for the bride' WHERE `id` = 2;
UPDATE `sg_categories` SET `description` = 'Topor, dorpon and traditional items for the groom'                   WHERE `id` = 3;
UPDATE `sg_categories` SET `description` = 'Traditional mukut and topor for babies'                              WHERE `id` = 1;
UPDATE `sg_categories` SET `description` = 'Complete wedding accessories including panpata, piri and more'       WHERE `id` = 4;
UPDATE `sg_categories` SET `description` = 'Handcrafted shola jewellery including matha patti and mini crowns'   WHERE `id` = 5;

-- +----------------------------------------------------------------------------
-- 3. Detach products from old subcategories (FK: ON DELETE SET NULL)
-- +----------------------------------------------------------------------------
UPDATE `sg_products` SET `subcategory_id` = NULL WHERE `subcategory_id` IS NOT NULL;

-- +----------------------------------------------------------------------------
-- 4. Delete old subcategories (will be re-inserted with correct structure)
-- +----------------------------------------------------------------------------
DELETE FROM `sg_subcategories` WHERE `category_id` IN (1, 2, 3, 4, 5);

-- +----------------------------------------------------------------------------
-- 5. Insert BRIDE subcategories (category_id = 2)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(2, 'Bridal Patashi / Mukut',  'bridal-patashi-mukut',  1, 1),
(2, 'Sithi / Small Mukut',     'sithi-small-mukut',     2, 1),
(2, 'Crown & 3 Pieces Set',    'crown-3-pieces-set',    3, 1),
(2, 'Boron / Khoidan Kulo',    'boron-khoidan-kulo',    4, 1),
(2, 'Gach kouto',              'gach-kouto',            5, 1),
(2, 'Panpata',                 'bride-panpata',         6, 1),
(2, 'Piri',                    'bride-piri',            7, 1);

-- +----------------------------------------------------------------------------
-- 6. Insert GROOM subcategories (category_id = 3)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(3, 'Topor Mukut Set',      'topor-mukut-set',      1, 1),
(3, 'Topor (Without Mukut)', 'topor-without-mukut',  2, 1),
(3, 'Dorpon',                'groom-dorpon',         3, 1),
(3, 'Kunke',                 'groom-kunke',          4, 1),
(3, 'Boron / Khoidan Kulo',  'groom-boron-khoidan',  5, 1);

-- +----------------------------------------------------------------------------
-- 7. Insert BABY subcategories (category_id = 1)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(1, 'Baby Topor (Boy)',   'baby-topor-boy',   1, 1),
(1, 'Baby Mukut (Girl)',  'baby-mukut-girl',  2, 1),
(1, 'Nitbor Topor (Boy)', 'nitbor-topor-boy', 3, 1);

-- +----------------------------------------------------------------------------
-- 8. Insert WEDDING ITEMS subcategories (category_id = 4)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(4, 'Panpata',              'wedding-panpata',       1, 1),
(4, 'Piri',                 'wedding-piri',          2, 1),
(4, 'Boron / Khoidan Kulo', 'wedding-boron-khoidan', 3, 1),
(4, 'Tattwa Suchi',         'tattwa-suchi',          4, 1),
(4, 'Tattwa Tray',          'tattwa-tray',           5, 1),
(4, 'Haldi Platter',        'haldi-platter',         6, 1),
(4, 'Haldi Jewellery',      'haldi-jewellery',       7, 1);

-- +----------------------------------------------------------------------------
-- 9. Insert SHOLA'S JEWELLERY subcategories (category_id = 5)
-- +----------------------------------------------------------------------------
INSERT INTO `sg_subcategories` (`category_id`, `name`, `slug`, `sort_order`, `status`) VALUES
(5, 'Matha Patti',            'matha-patti',               1, 1),
(5, 'Mini Crown',             'mini-crown',                2, 1),
(5, 'Bridal Sithi / Small Mukut', 'shola-sithi-small',     3, 1),
(5, 'Crown & 3 Pieces Set',   'shola-crown-3-pieces',     4, 1);
