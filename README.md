<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/badge/WeddingYour-v2.0-FF69B4?style=for-the-badge&logo=wedding&labelColor=1a1a2e">
    <img src="https://img.shields.io/badge/WeddingYour-v2.0-800080?style=for-the-badge&logo=wedding&labelColor=1a1a2e" alt="WeddingYour">
  </picture>
</p>

<h1 align="center">💍 WeddingYour — <em>Shola Ghar</em></h1>

<p align="center">
  <b>Premium Bengali Wedding E‑Commerce Platform</b><br>
  <sub>Handcrafted Sholapith artistry — Mukut, Topor &amp; traditional wedding accessories</sub>
</p>

<p align="center">
  <a href="https://github.com/Omar-khecharem/WeddingYour/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-Non--Commercial-red?style=flat-square" alt="License"></a>
  <a href="https://www.php.net/releases/8_2_0.php"><img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.2"></a>
  <a href="https://dev.mysql.com/doc/relnotes/mysql/8.0/en/"><img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL 8.0"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-3.4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3.4"></a>
  <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript"><img src="https://img.shields.io/badge/JavaScript-Vanilla%20ES6%2B-F7DF1E?style=flat-square&logo=javascript&logoColor=black" alt="Vanilla JS"></a>
  <br>
  <a href="https://github.com/Omar-khecharem"><img src="https://img.shields.io/badge/Author-Omar%20Khecharem-181717?style=flat-square&logo=github" alt="Author"></a>
  <a href="#installation"><img src="https://img.shields.io/badge/🚀%20Installation-blue?style=flat-square" alt="Installation"></a>
  <a href="#documentation"><img src="https://img.shields.io/badge/📖%20Documentation-green?style=flat-square" alt="Documentation"></a>
</p>

<br>

---

## 📋 Table of Contents

- [About](#-about)
- [Architecture](#-architecture)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Database](#-database)
- [Installation](#-installation)
- [Configuration](#%EF%B8%8F-configuration)
- [Screenshots](#-screenshots)
- [Security](#-security)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🏛️ About

**WeddingYour (Shola Ghar)** is a **full-featured, production-grade e-commerce platform** purpose-built for the Bengali wedding industry. It delivers a seamless shopping experience for handcrafted Sholapith wedding items — from bridal Mukut (crowns) and groom Topor (headdresses) to complete wedding sets and accessories.

Born from a deep understanding of Bengali wedding traditions and modern e-commerce best practices, the platform serves both customers browsing premium wedding accessories and administrators managing inventory, orders, and content — all through a single, cohesive application.

> *"It's your day, you are the celebrity..."*

---

## 🏗️ Architecture

```
┌─────────────────────────────────────────────────────────┐
│                     Frontend (Browser)                    │
│  ┌───────────┐  ┌──────────┐  ┌──────────────────────┐  │
│  │ Tailwind  │  │   Font   │  │  Vanilla ES6+ JS     │  │
│  │   CSS 3.4 │  │ Awesome 6│  │  (AJAX, Fetch, DOM)  │  │
│  └───────────┘  └──────────┘  └──────────────────────┘  │
└──────────────────────┬──────────────────────────────────┘
                       │ HTTP / AJAX
┌──────────────────────▼──────────────────────────────────┐
│               Custom PHP MVC Framework                    │
│  ┌──────────┐  ┌──────────┐  ┌────────┐  ┌──────────┐  │
│  │  Router  │→ │   Ctrl   │→ │  Model │→ │    DB    │  │
│  │ (Regex)  │  │  (MVC)   │  │  (AR)  │  │  (PDO)   │  │
│  └──────────┘  └────┬─────┘  └────────┘  └──────────┘  │
│                     │                                    │
│              ┌──────▼──────┐                             │
│              │    View     │                             │
│              │  (PHP + H)  │                             │
│              └─────────────┘                             │
│  ┌──────────┐  ┌──────────┐  ┌────────────────────────┐ │
│  │Middleware│  │  Helpers │  │  Services (Email, PDF, │ │
│  │(CSRF,    │  │(Security,│  │  WhatsApp, Cart, Auth, │ │
│  │ Auth,    │  │ Session, │  │  Cache, Coupon, Order) │ │
│  │ RateLim) │  │ Format)  │  │                        │ │
│  └──────────┘  └──────────┘  └────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────────┐
│                  MySQL 8.0 — InnoDB                       │
│             48 tables with full relational integrity       │
└─────────────────────────────────────────────────────────┘
```

**Key architectural decisions:**
- **Zero external framework dependency** — every layer is handcrafted for maximum control and minimal bloat
- **Custom MVC** with a regex-based router supporting middleware chains, named routes, route groups, and RESTful conventions
- **Active Record pattern** via a base Model class with CRUD, pagination, query builder, and relationship support
- **PSR-4 autoloading** — clean namespace mapping (`App\` → `app/`)
- **Layout system** with named sections, component includes, and view composers

---

## ✨ Features

### 🛍️ Customer-Facing (Frontend)

| Category | Features |
|----------|----------|
| **Homepage** | Dynamic hero section with video/image banners · Category step-carousel (8 per slide) · Popular products with image cycling · Flash sale banners · Video showcase · Google Reviews carousel · Recent products slider · "Shola's Outlets" with drag-scroll · Coupon marquee bar · WhatsApp floating button |
| **Product Catalog** | Filterable grid (category, subcategory, price range, rating, stock status) · Sortable (price, name, popularity, discount) · AJAX instant search (300ms debounce) · 4-column responsive layout · Per-page selector · "Showing X–Y of Z results" |
| **Product Detail** | Vertical thumbnail gallery (desktop) / horizontal strip (mobile) · Price with discount badge · Specs table · Quantity selector · Pincode availability checker · Compare / Wishlist / Share actions · "People watching" live counter · 3‑tab layout (Description / Specification / Reviews) with star-rating distribution · Related products grid · JSON‑LD structured data |
| **Cart** | Full AJAX cart management · Quantity +/- controls · Coupon code application · Real‑time price summary |
| **Checkout** | Multi‑step flow (shipping info → payment) · Order confirmation · PDF invoice generation |
| **Compare** | Side‑by‑side product comparison · Toggle remove · Count badge |
| **Wishlist** | Add/remove products · Persistent per user |
| **Search** | AJAX instant search with dropdown results |
| **User Account** | Dashboard · Profile editing · Order history with detail view · Address book · Password change |
| **Order Tracking** | Public order tracking by order number |
| **Newsletter** | AJAX email subscription |
| **Outlets** | Physical store locator with address, phone, map links |

### 🔧 Admin Panel (Backend)

| Module | Capabilities |
|--------|-------------|
| **Dashboard** | Revenue charts · Sales stats · Order counts · Recent orders · Low stock alerts |
| **Orders** | Full CRUD · Status management (pending → confirmed → processing → shipped → delivered) · Tracking number · Customer info |
| **Products** | CRUD with multi-image upload (independent, not replaced) · Stock & pricing · Categories, brands, variants, tags · Pincode availability per product · SEO meta fields · Discount auto‑calculation |
| **Categories** | Hierarchical CRUD · Image upload · SEO meta |
| **Banners** | 4 positions: hero_left (video), hero_right (image carousel), promotional (image), bride_video (video) |
| **Gallery** | Simplified image-only upload · Auto-generated title from filename |
| **Outlets** | Physical store CRUD with Google Maps link |
| **Deals** | Flash sale management |
| **Coupons** | Discount codes (percentage, fixed amount, free shipping) |
| **Reviews** | Approve / reject / delete customer reviews |
| **Users** | Customer list with order history |
| **Settings** | Site name, logo, social links, header banners, contact info, WhatsApp number |
| **Logs** | System activity viewer |
| **Cache** | One-click view & data cache clearing |

### 📧 Automated Communications

- **Order confirmation** — customer + admin notification
- **Shipping confirmation** — with tracking link
- **Welcome email** — on registration
- **Password reset** — secure token-based flow
- **PDF Invoice** — generated via TCPDF with HTML fallback

---

## 🛠 Tech Stack

### Core

| Layer | Technology | Rationale |
|-------|-----------|-----------|
| **Language** | PHP 8.2 | Mature, widely supported, excellent for e-commerce |
| **Database** | MySQL 8.0 (InnoDB) | Transactional integrity, fulltext search, foreign keys |
| **Frontend** | Tailwind CSS 3.4 + Vanilla ES6+ JS | Zero build step, utility-first styling, no framework overhead |
| **Icons** | Font Awesome 6 (Free) | Comprehensive icon set |
| **Typography** | Google Fonts — Montserrat + Playfair Display | Modern sans-serif + elegant serif |

### Infrastructure

| Component | Implementation |
|-----------|---------------|
| **Autoloader** | Custom PSR-4 autoloader (composer-free) |
| **Router** | Custom regex-based — supports parameters, named routes, groups, middleware binding, RESTful methods |
| **ORM** | Custom Active Record — base `Model` class with CRUD, pagination, query builder |
| **Database** | PDO with prepared statements — singleton connection manager |
| **View Engine** | Native PHP — layout system with sections, components, helpers |
| **Security** | CSRF tokens (per-session), XSS escaping (`e()` helper), bcrypt (cost 12), prepared statements, SameSite=Lax cookies, rate limiting, login throttling |
| **Emails** | PHP `mail()` with HTML templates |
| **PDF** | TCPDF (Composer) with auto-fallback to HTML |

---

## 🗄 Database

**48 InnoDB tables** — fully normalized with foreign key cascades and strategic indexes.

```
📦 sg_                  # All tables prefixed with sg_
├── 👥 Users (4)        # sg_users, sg_addresses, sg_user_tokens, sg_password_resets
├── 📦 Products (6)     # sg_products, sg_product_images, sg_product_variants,
│                       # sg_tags, sg_product_tags, sg_product_pincodes
├── 📂 Categories (2)   # sg_categories, sg_subcategories
├── 🏷️ Brands (1)      # sg_brands
├── 🛒 Orders (5)       # sg_orders, sg_order_items, sg_order_status_history, sg_carts, sg_cart_items
├── 📣 Marketing (6)    # sg_coupons, sg_wishlists, sg_compare, sg_reviews, sg_newsletter
├── 📄 Content (6)      # sg_pages, sg_banners, sg_gallery, sg_deals, sg_category_cards, sg_settings
├── 🏪 Outlets (1)      # sg_outlets
├── ⚙️ System (6)       # sg_sessions, sg_activity_logs, sg_email_queue, sg_countries, sg_currencies
├── 🔐 RBAC (7)         # sg_roles, sg_permissions, sg_role_permissions, sg_user_roles
└── 🔗 Relations (4)    # Pivot tables for many-to-many
```

> Full schema: `database/migrations/001_create_all_tables.sql`

---

## 🚀 Installation

### Prerequisites

- **PHP 8.2+** — extensions: `pdo_mysql`, `mbstring`, `gd`, `zip`, `json`
- **MySQL 8.0+** — with InnoDB support
- **Git**
- **Composer** (optional — only for TCPDF PDF generation)

### Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/Omar-khecharem/WeddingYour.git
cd WeddingYour

# 2. Create database
mysql -u root -p -e "CREATE DATABASE shola_ghar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Run migrations + seed data
mysql -u root -p shola_ghar < database/migrations/001_create_all_tables.sql
mysql -u root -p shola_ghar < database/seed.sql

# 4. Configure database credentials
#    Edit config/database.php with your MySQL connection details

# 5. Configure app URL
#    Edit config/app.php — set APP_URL to 'http://localhost:8080'

# 6. Start the development server
php -S localhost:8080 -t public public/router.php

# 7. Open in browser
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
| **Admin Panel** | `http://localhost:8080/admin` | admin@sholaghar.com / password (see seed.sql) |

---

## ⚙️ Configuration

| File | Key Settings |
|------|-------------|
| `config/app.php` | `APP_URL`, `APP_NAME`, `APP_CURRENCY`, `APP_TAGLINE`, social links, `SESSION_LIFETIME` (480 min), `MAX_UPLOAD_SIZE` (50MB), tax & shipping defaults |
| `config/database.php` | `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` |
| `config/constants.php` | Directory paths (`UPLOADS_DIR`, `VIEWS_DIR`, etc.), status constants |
| `config/autoload.php` | Session configuration (SameSite, save path, GC lifetime), PHP limits, error handler |

---

## 🎨 Screenshots

> *(Replace with actual screenshots from your deployed site)*

| Page | Preview |
|------|---------|
| **Homepage** | `docs/screenshots/home.png` |
| **Product Catalog** | `docs/screenshots/products.png` |
| **Product Detail** | `docs/screenshots/detail.png` |
| **Cart & Checkout** | `docs/screenshots/cart.png` |
| **Admin Dashboard** | `docs/screenshots/admin.png` |

---

## 🛡️ Security

| Measure | Implementation |
|---------|---------------|
| **CSRF Protection** | Per-session tokens validated via middleware on all POST/PUT/DELETE requests |
| **XSS Prevention** | All output escaped through `e()` helper (`htmlspecialchars`) |
| **SQL Injection** | Prepared statements with parameter binding (PDO) |
| **Password Hashing** | bcrypt with cost factor 12 |
| **Session Security** | HTTP-only cookies, SameSite=Lax, configurable lifetime, dedicated save path |
| **Rate Limiting** | Middleware-based throttling for API endpoints |
| **Brute Force** | Login throttling — 5 attempts, 15-minute lockout |
| **SSL** | Enforced in production via config flag |
| **File Uploads** | Type validation, size limits (50MB max), sanitized filenames |

---

## 🤝 Contributing

We welcome contributions that improve the platform for the Bengali wedding community.

### Getting Started

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

### Guidelines

- Follow **PSR-1/PSR-4** for PHP code
- Use **4 spaces** for PHP, **2 spaces** for HTML/Tailwind views
- Keep views **logic-free** — extract to helpers/components
- Use the **`e()` helper** for all output escaping
- Add **meaningful comments** for non-obvious business logic
- Test all changes with the built-in server before submitting

---

## 📄 License

**Shola Ghar — Non-Commercial License**

Copyright © 2026 **Omar Khecharem**

This software is licensed for **non-commercial use only**. You are free to use, copy, modify, and distribute this software for personal, educational, or evaluation purposes. **Commercial use** — including but not limited to selling the software, hosting it as a paid service, or using it to operate a revenue-generating business — requires prior written permission from the copyright holder.

See the [LICENSE](LICENSE) file for full terms.

For commercial licensing inquiries: **khcharem.omar@gmail.com**

---

## 📬 Contact

**Omar Khecharem** — Full-Stack Developer & Creator

<p align="left">
  <a href="mailto:khcharem.omar@gmail.com"><img src="https://img.shields.io/badge/Email-khcharem.omar%40gmail.com-EA4335?style=flat-square&logo=gmail&logoColor=white" alt="Email"></a>
  <a href="https://github.com/Omar-khecharem"><img src="https://img.shields.io/badge/GitHub-Omar--khecharem-181717?style=flat-square&logo=github" alt="GitHub"></a>
  <a href="https://linkedin.com/in/omar-khecharem"><img src="https://img.shields.io/badge/LinkedIn-Connect-0A66C2?style=flat-square&logo=linkedin" alt="LinkedIn"></a>
</p>

---

<p align="center">
  <sub>Built with ❤️ for Bengali weddings — Mukut, Topor &amp; Sholapith artistry.</sub>
  <br>
  <sub>© 2026 Shola Ghar. All rights reserved.</sub>
</p>
