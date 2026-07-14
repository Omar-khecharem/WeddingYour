<div align="center">
  <br/>
  <a href="https://github.com/Omar-khecharem/WeddingYour">
    <img src="https://img.shields.io/badge/WeddingYour-v1.0-800080?style=for-the-badge&logo=wedding&labelColor=1a1a2e" alt="WeddingYour">
  </a>
  <br/>
  <h1 align="center" style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin: 0;">
    🎀 WeddingYour — <span style="color:#800080;">Shola Ghar</span>
  </h1>
  <p align="center">
    <i>Premium Bengali Wedding E‑Commerce Platform</i>
  </p>
  <br/>

  <p align="center">
    <a href="#-features"><img src="https://img.shields.io/badge/Features-8A2BE2?style=flat-square" alt="Features"/></a>
    <a href="#-tech-stack"><img src="https://img.shields.io/badge/Tech%20Stack-6A0DAD?style=flat-square" alt="Tech Stack"/></a>
    <a href="#-installation"><img src="https://img.shields.io/badge/Installation-5B0C9F?style=flat-square" alt="Installation"/></a>
    <a href="#-project-structure"><img src="https://img.shields.io/badge/Structure-4B0B8F?style=flat-square" alt="Structure"/></a>
    <a href="#-screenshots"><img src="https://img.shields.io/badge/Screenshots-3B0A7F?style=flat-square" alt="Screenshots"/></a>
    <a href="#-contributing"><img src="https://img.shields.io/badge/Contributing-2B096F?style=flat-square" alt="Contributing"/></a>
    <a href="#-license"><img src="https://img.shields.io/badge/License-MIT-1B0A5F?style=flat-square" alt="License"/></a>
  </p>

  <br/>
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white"/>
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white"/>
    <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white"/>
    <img src="https://img.shields.io/badge/MVC-Architecture-FF6F61?style=flat-square"/>
    <img src="https://img.shields.io/badge/InnoDB-48%20Tables-00A86B?style=flat-square"/>
  </p>
  <br/>
</div>

---

## 📋 Table of Contents

- [✨ Features](#-features)
- [🛠 Tech Stack](#-tech-stack)
- [🚀 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [📁 Project Structure](#-project-structure)
- [🗄 Database](#-database)
- [🎨 Screenshots](#-screenshots)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)
- [📬 Contact](#-contact)

---

## ✨ Features

### 🛍️ Frontend (Customer-facing)
| Area | Details |
|------|---------|
| **Home** | Dynamic hero, category carousel (8‑per‑slide step animation), popular products with image cycling, flash sale banners, video showcase, Google Reviews carousel, "Checkout Our Recent Products" slider, "Shola's Outlets" with drag‑scroll |
| **Products** | Filterable grid (category, subcategory, price range, rating, stock), sort (price, name, popularity, discount), AJAX instant search (300ms debounce), "Load More" pagination, 4‑column responsive layout |
| **Product Detail** | Image gallery, variant selection, JSON‑LD structured data, reviews & ratings, stock status, discount badges, related products |
| **Cart** | Full cart management — quantity +/- (AJAX), coupon code, price summary, AJAX add/remove |
| **Checkout** | Multi‑step form (shipping info, payment method selection), order confirmation page |
| **Account** | Dashboard, profile edit, order history + detail view, wishlist, compare (toggle/count/clear), address book, password change |
| **Compare** | Side‑by‑side product comparison with remove toggle |
| **Search** | Instant AJAX search with results dropdown (300ms debounce) |

### 🔧 Backend (Admin)
- **Dashboard** — sales stats, order counts, charts
- **Orders** — list/detail view, status management
- **Products** — CRUD with image upload, stock management, categories, brands
- **Coupons** — discount code management (percentage, fixed, free shipping)
- **Reviews** — approve/reject/delete customer reviews
- **Users** — customer management
- **Settings** — site configuration, header banners, social links
- **Logs** — activity viewer

### 📧 Automated Emails
- Order confirmation (customer)
- Order confirmation (admin)
- Shipping confirmation
- Welcome email
- Password reset

### 📄 Invoice Generation
- PDF invoices via TCPDF (with HTML fallback)
- WhatsApp deep‑link sharing (`wa.me`)

### 🌐 Internationalization
- French frontend labels (UI), English codebase
- Bengali‑focused product catalog (Mukut, Topor, Sholapith items)

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Language** | PHP 8.2 (native, no framework) |
| **Architecture** | MVC (Model‑View‑Controller) |
| **Database** | MySQL 8.0 — InnoDB, 48 tables, foreign keys, indexes, fulltext |
| **Frontend** | Tailwind CSS 3.4 (CDN), Vanilla ES6+ JavaScript |
| **Templating** | Native PHP views with helpers |
| **Routing** | Custom regex‑based Router (parameterized, named routes, middleware) |
| **PDF** | TCPDF (with HTML fallback) |
| **Server** | PHP built‑in server (`php -S`) or Apache 2.4 with mod_rewrite |
| **Security** | CSRF tokens, XSS escaping, prepared statements, bcrypt (cost 12), session management |

---

## 🚀 Installation

### Prerequisites
- PHP 8.2+ (with PDO MySQL, mbstring, gd, zip extensions)
- MySQL 8.0+
- Composer _(optional, for TCPDF)_
- Git

### Step 1 — Clone
```bash
git clone https://github.com/Omar-khecharem/WeddingYour.git
cd WeddingYour
```

### Step 2 — Database
Create the database and run the migration & seed scripts:
```bash
mysql -u root -p -e "CREATE DATABASE shola_ghar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p shola_ghar < database/migrations/001_create_all_tables.sql
mysql -u root -p shola_ghar < database/seed.sql
```

### Step 3 — Configure
Edit `config/database.php` with your MySQL credentials:
```php
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'shola_ghar');
define('DB_USER', 'root');
define('DB_PASS', '');
```

Edit `config/app.php` to set your `APP_URL`:
```php
define('APP_URL', 'http://localhost:8080');
```

### Step 4 — Run
**Option A — PHP built-in server (recommended for development):**
```bash
php -S localhost:8080 -t public public/router.php
```

**Option B — Apache:**
Ensure `mod_rewrite` is enabled and `AllowOverride All` is set for the document root, then place the project under your web root.

### Step 5 — Open
Visit [`http://localhost:8080`](http://localhost:8080) in your browser.

---

## ⚙️ Configuration

All configuration lives in `config/`:

| File | Purpose |
|------|---------|
| `app.php` | App name, URL, currency, contact info, social links, security settings, pagination, tax, shipping |
| `database.php` | MySQL connection credentials |
| `autoload.php` | PSR‑4‑style autoloader configuration |
| `constants.php` | Directory constants, database prefix, status constants |

---

## 📁 Project Structure

```
WeddingYour/
├── app/
│   ├── Components/        # Reusable UI components (ProductCard, Breadcrumb, etc.)
│   ├── Controllers/       # MVC controllers (Home, Product, Cart, Checkout, Account, Admin…)
│   ├── Core/              # Framework core (Router, Database, Controller, Model, Request, Response, View)
│   ├── Helpers/           # Utility helpers (Security, Session, HTML)
│   ├── Middleware/        # Auth, CSRF, Admin middleware
│   ├── Models/            # Active‑Record‑style models (Product, Category, Order, User, etc.)
│   ├── Services/          # Business services (InvoiceService, WhatsAppService)
│   ├── Traits/            # PHP traits
│   └── Views/             # All templates
│       ├── admin/         # Admin panel views
│       ├── emails/        # Email templates (5 templates)
│       ├── errors/        # Error pages (404)
│       ├── home/          # Homepage
│       ├── layouts/       # Layouts (navbar, footer, sidebar)
│       └── products/      # Product listing, detail, compare
├── cache/                 # Data & view caches
├── config/                # Application configuration
├── database/
│   └── migrations/        # SQL migration files
├── logs/                  # Application logs
├── public/                # Web root
│   ├── assets/            # CSS, JS, images
│   ├── index.php          # Entry point
│   └── router.php         # Built‑in server router
├── routes/                # Route definitions (web.php, api.php, admin.php)
├── .htaccess              # Apache rewrite rules
├── .gitignore
└── README.md
```

---

## 🗄 Database

**48 InnoDB tables** with full relational integrity:

| Schema | Count | Highlights |
|--------|-------|------------|
| **Products** | 6 | `sg_products`, `sg_product_images`, `sg_product_variants`, `sg_product_tags` |
| **Categories** | 2 | `sg_categories`, `sg_subcategories` |
| **Orders** | 5 | `sg_orders`, `sg_order_items`, `sg_order_status_history` |
| **Users** | 4 | `sg_users`, `sg_addresses`, `sg_user_tokens` |
| **Marketing** | 5 | `sg_coupons`, `sg_wishlist`, `sg_compare`, `sg_reviews`, `sg_newsletter` |
| **Content** | 4 | `sg_pages`, `sg_banners`, `sg_settings`, `sg_brands` |
| **System** | 6 | `sg_sessions`, `sg_activity_logs`, `sg_email_queue` |
| **Relations** | 16 | Pivot & join tables |

- All tables use `sg_` prefix
- Foreign keys with `ON DELETE CASCADE`
- Indexes on slug, email, status, sort_order
- Fulltext indexes on product names & descriptions

---

## 🎨 Screenshots

> _(Add screenshots of your live site here)_

| Page | Preview |
|------|---------|
| **Home** | ![](docs/screenshots/home.png) |
| **Products** | ![](docs/screenshots/products.png) |
| **Product Detail** | ![](docs/screenshots/detail.png) |
| **Admin Dashboard** | ![](docs/screenshots/admin.png) |

---

## 🤝 Contributing

Contributions are welcome! Follow these steps:

1. **Fork** the repository
2. Create a feature branch: `git checkout -b feat/amazing-feature`
3. **Commit** your changes following [Conventional Commits](https://www.conventionalcommits.org/):
   ```
   feat: add WhatsApp sharing for orders
   fix: resolve cart quantity overflow on mobile
   docs: update installation steps for Apache
   style: refactor navbar hover transitions
   ```
4. **Push** to your fork: `git push origin feat/amazing-feature`
5. Open a **Pull Request**

### Coding Standards
- Follow PSR‑1/PSR‑4 for PHP
- Use 2 spaces for indentation (views) / 4 spaces (PHP)
- Keep views logic‑free — use helpers and components
- Comment non‑obvious business logic in English

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 📬 Contact

**Omar Khecharem** — Full‑Stack Developer

[![GitHub](https://img.shields.io/badge/GitHub-Omar--khecharem-181717?style=flat-square&logo=github)](https://github.com/Omar-khecharem)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-connect-0A66C2?style=flat-square&logo=linkedin)](https://linkedin.com/in/omar-khecharem)

---

<div align="center">
  <sub>Built with ❤️ for Bengali weddings — Mukut, Topor & Sholapith artistry.</sub>
  <br/>
  <sub>© 2026 Shola Ghar. All rights reserved.</sub>
</div>
