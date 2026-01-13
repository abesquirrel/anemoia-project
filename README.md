# 🌌 Anem[o]ia – Nostalgic Photography & Journal

[![Laravel Version](https://img.shields.io/badge/Laravel-11-orange)](https://laravel.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue)](https://www.php.net/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Anem[o]ia is a **fine-art photography portfolio and storytelling platform**. It bridges the gap between visual galleries and narrative journaling, designed with a distinct "nostalgic" aesthetic that blends vintage sentiment with modern performance.

---

## ✨ Key Features

### 🎨 Visual & Experience
- **Cinematic "Noir" Admin Theme**: A custom-built admin interface featuring a **Dual Theme System**:
    - **Midnight Slate (Dark Mode)**: A professional, deep-slate interface for focused editing.
    - **Teal & Slate (Light Mode)**: A clean, airy workspace for daylight hours.
    - *Toggle instantly via the Sidebar.*
- **Responsive Galleries**: Masonry-style grids with `GLightbox` integration for immersive viewing.
- **Journaling Engine**: A dedicated blog section where specific photos can be highlighted as "Hero Images" for stories.

### 🛡️ Security & Performance
- **Enterprise-Grade Security**:
    - **CSP (Content Security Policy)**: Strict whitelist for scripts and styles to prevent XSS.
    - **HSTS**: Enforced HTTPS transport security.
    - **Permissions Policy**: Privacy-focused headers blocking camera/mic access.
    - **Activity Logging**: Tracks suspicious access attempts (e.g., `/wp-admin` probes).
- **SEO Optimized**:
    - **Dynamic Meta Tags**: Automated Title, Description, and OpenGraph (Facebook/Twitter) tags for every page.
    - **XML Sitemap**: Auto-generated at `/sitemap.xml` for instant Google indexing.

### 🔧 Powerful Admin Panel
- **Role-Based Access Control (RBAC)**:
    - **Admins**: Full control (Create, Delete, Manage Users).
    - **Editors**: Restricted "Editor Mode" (Can edit content, but cannot delete or create new system assets).
- **Dashboard Metrics**: Real-time stats on Storage Usage, Featured Galleries, and Recent Activity.
- **Media Management**:
    - Drag-and-drop uploads with mobile-friendly touch targets.
    - Automatic image resizing and optimization.
    - "Set as Cover" status for gallery management.

---

## 🛠 Technology Stack

- **Framework**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templates + Bootstrap 5 + Custom CSS Variables
- **Database**: MySQL / MariaDB
- **Assets**: Vite for bundling
- **Image Processing**: Intervention Image
- **Server**: Optimized for LiteSpeed / Apache

---

## 🚀 Installation & Setup

### Prerequisites
- PHP ≥ 8.2
- Composer
- Node.js & NPM
- MySQL

### Local Development
```bash
# 1. Clone the repository
git clone https://github.com/yourusername/anemoia-project.git
cd anemoia-project

# 2. Install Dependencies
composer install
npm install

# 3. Configure Environment
cp .env.example .env
php artisan key:generate
# Update .env with your DB credentials

# 4. Migrate Database
php artisan migrate

# 5. Run Server
npm run dev
php artisan serve
```

### Production Deployment
```bash
# Optimized for cPanel / Shared Hosting / VPS
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```
*For a detailed step-by-step guide, including server configuration and diagrams, please refer to [DEPLOYMENT.md](DEPLOYMENT.md).*

---

## 📸 Usage Guide

### Managing Galleries
1.  Navigate to **Galleries** in the Admin Sidebar.
2.  Create a nice Album (e.g., "Transylvanian Winters").
3.  Upload photos using the **drag-and-drop zone**.
4.  Star your favorite galleries to feature them on the Dashboard.

### Journal / Blog
1.  Go to **Posts**.
2.  Write your story using the rich editor.
3.  **Link a Gallery**: Select a gallery to automatically pull its cover image as the post header.
4.  **Editor Mode**: If you give a user "Editor" permissions, they can polish the text but cannot accidentally delete the post.

---

## 📂 Project Structure

- `app/Http/Controllers/Admin/*`: Logic for the secure dashboard.
- `app/Http/Middleware/SecurityHeaders.php`: Custom middleware for CSP/HSTS.
- `resources/views/layouts/site.blade.php`: The public face (SEO optimized).
- `public/admin_assets/css/custom.css`: The engine behind the **Dual Theme** system.

---

## 👤 Default User Setup

To create your first admin user manually via Tinker:

```php
php artisan tinker

$u = new App\Models\User();
$u->name = 'Admin';
$u->email = 'admin@anemoia.com';
$u->password = Hash::make('password');
$u->is_admin = true;
$u->save();
```

---

## 📈 Scaling Up: TO-DO List

As the platform grows, consider the following improvements for better performance and scalability:

- [ ] **Queueing System:** Offload heavy tasks like image resizing and email dispatching to a queue worker (Redis/Beanstalkd) instead of running them synchronously.
- [ ] **Cloud Storage:** Switch the filesystem disk from `local` to `s3` (AWS S3, DigitalOcean Spaces) to handle unlimited media storage and offload bandwidth.
- [ ] **Caching Layer:** Implement Redis or Memcached for session and cache drivers to reduce database load.
- [ ] **CDN Integration:** Serve static assets (images, CSS, JS) via a Content Delivery Network (Cloudflare, AWS CloudFront) for faster global loading times.
- [ ] **Image Formats:** Automate conversion of uploaded images to modern formats like WebP or AVIF for reduced file sizes.
- [ ] **Database Optimization:** Regularly monitor query performance and add indexes to frequently searched columns (e.g., `is_visible`, `featured_at`).
