<?php
/**
 * Application Configuration
 * 
 * Central configuration for the Shola Ghar e-commerce platform.
 * All environment-specific settings are managed here.
 */

define('APP_NAME', 'Shola Ghar');
define('APP_TAGLINE', 'It\'s your day you are the celebrity...');
define('APP_URL', 'http://localhost:8080');
define('APP_ENV', 'development'); // development | production | staging
define('APP_DEBUG', true);
define('APP_TIMEZONE', 'Asia/Kolkata');
define('APP_CURRENCY', '₹');
define('APP_CURRENCY_CODE', 'INR');
define('APP_LOCALE', 'en');

// Contact Information
define('CONTACT_EMAIL', 'support@sholaghar.com');
define('CONTACT_PHONE', '+91 89616 86776');
define('CONTACT_ADDRESS', 'Shobhabazar, Kalighat, Barrackpore, Chinar Park, Siliguri, Kolkata, India.');
define('WHATSAPP_NUMBER', '918961686776');
define('WHATSAPP_LINK', 'https://wa.me/918961686776');

// Social Media
define('SOCIAL_FACEBOOK', '#');
define('SOCIAL_INSTAGRAM', '#');
define('SOCIAL_YOUTUBE', '#');

// Security
define('CSRF_TOKEN_NAME', '_csrf_token');
define('SESSION_LIFETIME', 120); // minutes
define('PASSWORD_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_COST', 12);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 15); // minutes

// Upload
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
define('IMAGE_QUALITY', 80);
// Pagination
define('PAGINATION_PER_PAGE', 12);
define('PAGINATION_ADMIN_PER_PAGE', 20);

// Cache
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // 1 hour in seconds

// Tax
define('TAX_RATE', 18); // GST percentage
define('TAX_NAME', 'GST');

// Shipping
define('FREE_SHIPPING_MIN', 500); // Free shipping above this amount
define('STANDARD_SHIPPING', 49);
define('EXPRESS_SHIPPING', 99);

// SEO defaults
define('DEFAULT_META_TITLE', 'Shola Ghar - Premium Wedding Mukut, Topor & Wedding Accessories');
define('DEFAULT_META_DESCRIPTION', 'India\'s leading designer and online marketplace for premium handmade Sholapith wedding items, bridal accessories, and traditional religious items.');
define('DEFAULT_META_KEYWORDS', 'shola ghar, wedding mukut, topor, sholapith, wedding accessories, bridal mukut, groom topor, baby mukut');

// Invoices
define('INVOICES_DIR', ROOT_DIR . DS . 'invoices');
define('INVOICE_PREFIX', 'INV');
