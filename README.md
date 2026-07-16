<div align="center">
  <img src="public/assets/images/logo_wedding.png" alt="WeddingYour — Shola Ghar" width="160" height="160">
  <br><br>
  <h1>WeddingYour — <em>Shola Ghar</em></h1>
  <p><strong>Premium Bengali Wedding E-Commerce Platform</strong></p>
  <p><sub>Handcrafted Sholapith artistry — Mukut, Topor &amp; traditional wedding accessories</sub></p>
  <br>
  <p>
    <a href="https://www.php.net/releases/8_2_0.php"><img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2"></a>
    <a href="https://dev.mysql.com/doc/relnotes/mysql/8.0/en/"><img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.0"></a>
    <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3.4"></a>
    <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript"><img src="https://img.shields.io/badge/JavaScript-Vanilla%20ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="Vanilla JS"></a>
  </p>
  <p>
    <img src="https://img.shields.io/github/repo-size/Omar-khecharem/WeddingYour?style=flat-square&label=repo%20size" alt="Repo Size">
    <img src="https://img.shields.io/github/last-commit/Omar-khecharem/WeddingYour?style=flat-square" alt="Last Commit">
    <img src="https://img.shields.io/github/issues/Omar-khecharem/WeddingYour?style=flat-square" alt="GitHub Issues">
    <img src="https://img.shields.io/github/license/Omar-khecharem/WeddingYour?style=flat-square&color=red" alt="License">
    <img src="https://img.shields.io/badge/PRs-welcome-brightgreen?style=flat-square" alt="PRs Welcome">
  </p>
</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Key Differentiators](#-key-differentiators)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Project Structure](#-project-structure)
- [Database](#-database)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Security](#-security)
- [Performance](#-performance)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🚀 Overview

**WeddingYour (Shola Ghar)** is a **production-grade, zero-dependency PHP MVC e-commerce platform** purpose-built for the **Bengali wedding industry**. It delivers a seamless shopping experience for handcrafted Sholapith wedding items — from bridal Mukut (crowns) and groom Topor (headdresses) to complete wedding sets and accessories.

Built entirely from scratch without any external PHP framework, this platform demonstrates deep mastery of MVC architecture, database design, security best practices, and modern frontend development.

> *"It's your day, you are the celebrity..."*

---

## 🏆 Key Differentiators

| | |
|---|---|
| ✅ **100% Custom Framework** | Zero external PHP dependencies — no Laravel, Symfony, or any framework |
| ✅ **48 Normalized Tables** | Fully relational InnoDB schema with foreign keys, cascades, and strategic indexes |
| ✅ **Production-Grade Security** | CSRF tokens, bcrypt (cost 12), prepared statements, rate limiting, XSS escaping |
| ✅ **Full Admin Panel** | Complete CRUD for orders, products, categories, banners, coupons, users, reviews, outlets, deals |
| ✅ **Automated Communications** | HTML emails (order confirmations, shipping, password reset) + PDF invoices via TCPDF |
| ✅ **Modern Frontend** | Tailwind CSS 3.4 (zero build step), Vanilla ES6+ JS, Font Awesome 6, AJAX everywhere |
| ✅ **SEO Optimized** | JSON-LD structured data, meta fields per product/category, semantic HTML |

---

## ✨ Features

### 🛒 Customer-Facing (Frontend)

| Category | Features |
|----------|----------|
| **Homepage** | Dynamic hero with video/image banners • Category step-carousel (8 per slide) • Popular products with hover overlay • Flash sale banners • Video showcase • Recent products slider with dynamic ratings • Outlets drag-scroll • Coupon marquee bar • WhatsApp floating button |
| **Product Catalog** | Filterable grid (category, subcategory, price range, rating, stock) • Sortable (price, name, popularity, discount) • AJAX instant search (300 ms debounce) • 4-column responsive layout • Per-page selector • Dynamic star ratings on every product card |
| **Product Detail** | Vertical thumbnail gallery (desktop) / horizontal strip (mobile) • Price with discount badge • Specs table • Quantity selector • Pincode availability checker • Compare / Wishlist / Share • 3-tab layout (Description / Specs / Reviews) • Star-rating distribution with dynamic averages • Customer review submission form • Related products • JSON-LD structured data |
| **Cart** | Full AJAX • Quantity +/- • Coupon codes • Real-time price summary |
| **Checkout** | Multi-step (shipping → payment) • Order confirmation • PDF invoice |
| **Compare** | Side-by-side product comparison • Toggle remove • Count badge |
| **Wishlist** | Persistent per user • Add/remove • Count badge |
| **Search** | AJAX instant search with dropdown results (300 ms debounce) |
| **User Account** | Dashboard • Profile editing • Order history with detail • Address book • Password change |
| **Order Tracking** | Public tracking by order number |
| **Newsletter** | AJAX email subscription |
| **Outlets** | Physical store locator with Google Maps |

### 🔧 Admin Panel (Backend)

| Module | Capabilities |
|--------|-------------|
| **Dashboard** | Revenue charts • Sales stats • Order counts • Recent orders • Low stock alerts |
| **Orders** | Full CRUD • Status workflow (pending → confirmed → processing → shipped → delivered) • Tracking number • Customer info |
| **Products** | CRUD with multi-image upload (independent, not replaced) • Stock & pricing • Categories, brands, variants, tags • Pincode availability • SEO meta fields • Discount auto-calculation |
| **Categories** | Hierarchical CRUD • Image upload • SEO meta |
| **Banners** | 4 positions: hero_left (video), hero_right (image carousel), promotional (image), bride_video (video) |
| **Coupons** | Discount codes (percentage, fixed amount, free shipping) |
| **Reviews** | Approve / reject / delete customer reviews submitted from product pages |
| **Pages** | CMS-like static page management (About, Contact, custom pages) |
| **Blog** | Full blog post management with categories, featured image upload, SEO |
| **Users** | Customer list with order history |
| **Outlets** | Physical store CRUD with Google Maps |
| **Deals** | Flash sale management |
| **Settings** | Site name, logo, social links, header banners, contact info, WhatsApp |
| **Logs** | System activity viewer |
| **Cache** | One-click view & data cache clearing |

### 📧 Automated Communications

- **Order confirmation** — customer email + admin notification
- **Shipping confirmation** — with tracking link
- **Welcome email** — on user registration
- **Password reset** — secure token-based flow
- **PDF invoices** — generated via TCPDF with HTML fallback
- **WhatsApp notifications** — order updates via WhatsApp API

---

## 🛠 Tech Stack

### Core

| Layer | Technology | Rationale |
|-------|-----------|-----------|
| **Language** | PHP 8.2+ | Mature, widely supported, excellent for e-commerce |
| **Database** | MySQL 8.0+ (InnoDB) | Transactional integrity, fulltext search, foreign keys |
| **Frontend** | Tailwind CSS 3.4 + Vanilla ES6+ JS | Zero build step, utility-first, no framework overhead |
| **Icons** | Font Awesome 6 (Free) | Comprehensive icon set |
| **Typography** | Google Fonts — Montserrat + Playfair Display | Modern sans-serif + elegant serif |
| **PDF** | TCPDF | Reliable PDF generation with HTML fallback |

### Architecture Components

| Component | Implementation |
|-----------|---------------|
| **Router** | Custom regex-based — parameters, named routes, groups, middleware binding, RESTful methods |
| **ORM** | Custom Active Record — base `Model` class with CRUD, pagination, query builder |
| **Database Layer** | PDO with prepared statements — singleton connection manager |
| **View Engine** | Native PHP — layout system with sections, components, helpers |
| **Autoloader** | Custom PSR-4 autoloader (composer-free) |
| **Middleware** | Chainable — CSRF, Auth, Rate Limiting |
| **Mail** | PHP `mail()` with rich HTML templates |
| **Cache** | File-based view & data caching with configurable TTL |

---

## 🏗 Architecture

```
┌──────────────────────────────────────────────────────────────┐
│                       Browser (Client)                        │
│  ┌──────────────┐  ┌──────────────┐  ┌───────────────────┐  │
│  │  Tailwind 3.4 │  │ Font Awesome │  │  Vanilla ES6+ JS  │  │
│  │  (CDN)        │  │  6 (CDN)     │  │  (AJAX, Fetch)    │  │
│  └──────────────┘  └──────────────┘  └───────────────────┘  │
└──────────────────────────┬───────────────────────────────────┘
                           │ HTTP / AJAX
┌──────────────────────────▼───────────────────────────────────┐
│                   Custom PHP MVC Framework                     │
│                                                               │
│  ┌──────────┐   ┌───────────┐   ┌──────────┐   ┌──────────┐ │
│  │  Router   │──▶│Controller │──▶│  Model   │──▶│    DB    │ │
│  │ (Regex)   │   │   (MVC)   │   │  (AR)    │   │  (PDO)   │ │
│  └──────────┘   └─────┬─────┘   └──────────┘   └──────────┘ │
│                       │                                       │
│                ┌──────▼──────┐                                │
│                │    View     │                                │
│                │  (PHP + H)  │                                │
│                └─────────────┘                                │
│  ┌──────────┐   ┌──────────┐   ┌──────────────────────────┐  │
│  │Middleware│   │ Helpers  │   │  Services (Email, PDF,    │  │
│  │(CSRF,    │   │(Security,│   │  WhatsApp, Cart, Auth,    │  │
│  │ Auth,    │   │ Session, │   │  Cache, Coupon, Order)    │  │
│  │RateLim)  │   │ Format)  │   │                           │  │
│  └──────────┘   └──────────┘   └──────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
                           │
┌──────────────────────────▼───────────────────────────────────┐
│                    MySQL 8.0 — InnoDB                         │
│             48 tables with full relational integrity           │
└──────────────────────────────────────────────────────────────┘
```

---

## 📂 Project Structure

```
WeddingYour/
├── app/                        # Application source code
│   ├── Controllers/            # MVC Controllers
│   ├── Models/                 # Active Record models
│   ├── Views/                  # PHP view templates
│   ├── Core/                   # Framework core (Router, DB, View, etc.)
│   ├── Services/               # Business logic (Cart, Order, Invoice, etc.)
│   ├── Middleware/             # Auth, CSRF middleware
│   ├── Helpers/                # Utility helpers (Security, Session, Format)
│   └── Components/             # Reusable UI components
├── config/                     # Configuration files
├── database/                   # SQL migrations & seed data
├── public/                     # Web root
│   ├── assets/                 # CSS, JS, images
│   └── uploads/                # User uploads (gitignored)
├── routes/                     # Route definitions
├── cache/                      # File cache (gitignored)
├── storage/                    # Session files (gitignored)
├── logs/                       # Application logs (gitignored)
└── invoices/                   # Generated PDFs (gitignored)
```

---

## 🗄 Database

**48 InnoDB tables** — fully normalized with foreign key cascades and strategic indexes.

```
📦 shola_ghar (@sg_ prefix)
├── 👥 Users          (4)  ─  sg_users, sg_addresses, sg_user_tokens, sg_password_resets
├── 📦 Products       (6)  ─  sg_products, sg_product_images, sg_product_variants,
│                              sg_tags, sg_product_tags, sg_product_pincodes
├── 📂 Categories     (2)  ─  sg_categories, sg_subcategories
├── 🏷️ Brands         (1)  ─  sg_brands
├── 🛒 Orders         (5)  ─  sg_orders, sg_order_items, sg_order_status_history, sg_carts, sg_cart_items
├── 📣 Marketing      (6)  ─  sg_coupons, sg_wishlists, sg_compare, sg_reviews, sg_newsletter
├── 📄 Content        (6)  ─  sg_pages, sg_banners, sg_gallery, sg_deals, sg_category_cards, sg_settings
├── 🏪 Outlets        (1)  ─  sg_outlets
├── ⚙️ System         (6)  ─  sg_sessions, sg_activity_logs, sg_email_queue, sg_countries, sg_currencies
├── 🔐 RBAC           (7)  ─  sg_roles, sg_permissions, sg_role_permissions, sg_user_roles
└── 🔗 Relations      (4)  ─  Pivot tables for many-to-many
```

> Full schema: [`database/migrations/001_create_all_tables.sql`](database/migrations/001_create_all_tables.sql)

---

## ⚡ Installation

### Prerequisites

- **PHP 8.2+** — extensions: `pdo_mysql`, `mbstring`, `gd`, `zip`, `json`
- **MySQL 8.0+** — with InnoDB support
- **Git**
- **Composer** *(optional — only for TCPDF PDF generation)*

### Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/Omar-khecharem/WeddingYour.git
cd WeddingYour

# 2. Create the database
mysql -u root -p -e "CREATE DATABASE shola_ghar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Run migrations & seed data
mysql -u root -p shola_ghar < database/migrations/001_create_all_tables.sql
mysql -u root -p shola_ghar < database/seed.sql

# 4. Configure database credentials in config/database.php
# 5. Configure APP_URL in config/app.php

# 6. Start the built-in PHP server
php -S localhost:8080 -t public public/router.php

# 7. Open in your browser
open http://localhost:8080
```

### Apache Deployment

```apache
<VirtualHost *:80>
    DocumentRoot "/path/to/WeddingYour/public"
    ServerName yourdomain.com
    <Directory "/path/to/WeddingYour/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Admin Access

| Role | URL | Default Credentials |
|------|-----|-------------------|
| **Admin Panel** | `http://localhost:8080/admin` | `admin@sholaghar.com` / `password` *(see seed.sql)* |

---

## ⚙️ Configuration

| File | Key Settings |
|------|-------------|
| [`config/app.php`](config/app.php) | `APP_URL`, `APP_NAME`, `APP_CURRENCY`, `APP_TAGLINE`, `SESSION_LIFETIME` (480 min), `MAX_UPLOAD_SIZE` (50 MB), tax & shipping defaults |
| [`config/database.php`](config/database.php) | `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` |
| [`config/constants.php`](config/constants.php) | Directory paths, status constants |
| [`config/autoload.php`](config/autoload.php) | Session config (SameSite, save path, GC lifetime), PHP limits, error handler |

---

## 🔒 Security

| Measure | Implementation |
|---------|---------------|
| **CSRF Protection** | Per-session tokens validated via middleware on all POST/PUT/DELETE requests |
| **XSS Prevention** | All output escaped through `e()` helper (`htmlspecialchars` with UTF-8) |
| **SQL Injection** | Prepared statements with parameter binding (PDO) — no raw queries |
| **Password Hashing** | bcrypt with cost factor 12 |
| **Session Security** | HTTP-only cookies, SameSite=Lax, dedicated save path, 8-hour lifetime |
| **Rate Limiting** | Middleware-based throttling for API endpoints |
| **Brute Force Protection** | Login throttling — 5 attempts, 15-minute lockout |
| **SSL Enforcement** | HTTPS enforced in production via config flag |
| **File Uploads** | Type validation, size limits (50 MB max), sanitized filenames |

---

## 📈 Performance

- **File-based caching** — view & data cache with configurable TTL
- **Optimized images** — configurable compression quality (80%), multiple format support
- **AJAX lazy loading** — search with 300 ms debounce, lazy-loaded product sections
- **Efficient queries** — strategic database indexes, paginated results, eager loading
- **Minimal dependencies** — zero framework overhead, only essential Composer packages

---

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

### Workflow

1. **Fork** the repository
2. Create a feature branch: `git checkout -b feat/your-feature`
3. **Commit** using [Conventional Commits](https://www.conventionalcommits.org/):
   ```
   feat: add WhatsApp order sharing
   fix: resolve cart quantity overflow on mobile
   docs: update deployment instructions
   perf: optimize product image loading
   style: refine navbar scroll animation
   ```
4. **Push** to your fork: `git push origin feat/your-feature`
5. Open a **Pull Request**

### Code Standards

- Follow **PSR-1/PSR-4** for PHP code
- **4 spaces** for PHP, **2 spaces** for HTML/Tailwind views
- Keep views **logic-free** — use helpers/components
- Use the **`e()` helper** for all output escaping
- Test all changes with the built-in server before submitting

---

## 📄 License

**Shola Ghar — Non-Commercial License**

Copyright © 2026 **Omar Khecharem**

This software is licensed for **non-commercial use only**. You are free to use, copy, modify, and distribute this software for personal, educational, or evaluation purposes. **Commercial use** — including selling, hosting as a paid service, or operating a revenue-generating business — requires prior written permission.

See the [LICENSE](LICENSE) file for full terms.

For commercial licensing: **khcharem.omar@gmail.com**

---

## 📬 Contact

**Omar Khecharem** — Full-Stack Developer

<p align="left">
  <a href="mailto:khcharem.omar@gmail.com"><img src="https://img.shields.io/badge/Email-khcharem.omar%40gmail.com-EA4335?style=flat-square&logo=gmail&logoColor=white" alt="Email"></a>
  <a href="https://github.com/Omar-khecharem"><img src="https://img.shields.io/badge/GitHub-Omar--khecharem-181717?style=flat-square&logo=github" alt="GitHub"></a>
  <a href="https://linkedin.com/in/omar-khecharem"><img src="https://img.shields.io/badge/LinkedIn-Connect-0A66C2?style=flat-square&logo=linkedin" alt="LinkedIn"></a>
</p>

---

<p align="center">
  <sub>Built with ❤️ for Bengali weddings — Mukut, Topor &amp; Sholapith artistry</sub>
  <br>
  <sub>© 2026 Shola Ghar. All rights reserved.</sub>
</p>
