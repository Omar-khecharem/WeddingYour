-- Outlets (Shola Ghar's Store Locations)
CREATE TABLE IF NOT EXISTS `sg_outlets` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(100) NOT NULL,
    `slug`        VARCHAR(120) NOT NULL UNIQUE,
    `description` TEXT         NULL,
    `image`       VARCHAR(255) NULL,
    `address`     VARCHAR(255) NULL,
    `city`        VARCHAR(100) NULL,
    `state`       VARCHAR(100) NULL,
    `phone`       VARCHAR(20)  NULL,
    `email`       VARCHAR(191) NULL,
    `latitude`    DECIMAL(10,8) NULL,
    `longitude`   DECIMAL(11,8) NULL,
    `google_maps_link` VARCHAR(500) NULL,
    `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
    `sort_order`  INT          NOT NULL DEFAULT 0,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_outlet_active` (`is_active`),
    INDEX `idx_outlet_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Homepage Sections configuration
CREATE TABLE IF NOT EXISTS `sg_homepage_sections` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `section_key`   VARCHAR(50)  NOT NULL UNIQUE,
    `title`         VARCHAR(200) NULL,
    `subtitle`      VARCHAR(500) NULL,
    `type`          ENUM('products','categories','subcategories','gallery','custom') NOT NULL DEFAULT 'custom',
    `reference_ids` JSON         NULL,
    `sort_order`    INT          NOT NULL DEFAULT 0,
    `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_hs_key` (`section_key`),
    INDEX `idx_hs_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Best Deal items
CREATE TABLE IF NOT EXISTS `sg_deals` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `image`       VARCHAR(255) NOT NULL,
    `sort_order`  INT          NOT NULL DEFAULT 0,
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Category Cards (for Mukut & Topor, Wedding Items, Gachhkouto & Dorpon, Best Seller Items)
CREATE TABLE IF NOT EXISTS `sg_category_cards` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`         VARCHAR(200) NOT NULL,
    `subtitle`      VARCHAR(500) NULL,
    `section_key`   VARCHAR(50)  NOT NULL,
    `category_id`   INT UNSIGNED NULL,
    `subcategory_id` INT UNSIGNED NULL,
    `image`         VARCHAR(255) NOT NULL,
    `link`          VARCHAR(255) NULL,
    `sort_order`    INT          NOT NULL DEFAULT 0,
    `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_cc_section` (`section_key`),
    INDEX `idx_cc_active` (`is_active`),
    CONSTRAINT `fk_cc_category` FOREIGN KEY (`category_id`) REFERENCES `sg_categories`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_cc_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `sg_subcategories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
