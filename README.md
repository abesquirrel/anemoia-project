# 🌌 Anem[o]ia – Photography Portfolio & Journal

[![Laravel Version](https://img.shields.io/badge/Laravel-12-orange)](https://laravel.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3+-blue)](https://www.php.net/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![Issues](https://img.shields.io/github/issues/yourusername/anemoia-project)](https://github.com/yourusername/anemoia-project/issues)
[![Stars](https://img.shields.io/github/stars/yourusername/anemoia-project)](https://github.com/yourusername/anemoia-project/stargazers)
[![Forks](https://img.shields.io/github/forks/yourusername/anemoia-project)](https://github.com/yourusername/anemoia-project/network)
[![Last Commit](https://img.shields.io/github/last-commit/yourusername/anemoia-project)](https://github.com/yourusername/anemoia-project/commits/main)

Anem[o]ia is a **dynamic photography portfolio and journal** built with Laravel 12. Showcase your galleries, blog stories, and manage everything through a modern admin panel.  
Featuring a **dark-themed responsive design**, integrated blog/gallery linking, and an intelligent storytelling experience.



## ✨ Features

### 🖼 Public Site
- **Dynamic Galleries** – Responsive masonry grid + GLightbox.
- **Journal / Blog** – Magazine-style posts with "Hero" images.
- **Storytelling** – Link posts to galleries with featured gallery cards.
- **Responsive Design** – Bootstrap 5 with custom "Grayscale" dark theme.

### 🔧 Admin Panel
- **Secure Dashboard** – Laravel Breeze + custom roles.
- **Gallery Management** – Create/edit/delete albums, bulk uploads with auto-resize & compression.
- **Photo Management**:
    - Drag & drop multiple images (max 1920px, JPG, 80% compressed).
    - Toggle visibility (drafts / hidden).
    - Set any photo as album cover.
- **Blog Management**:
    - Visual Hero Image selector from galleries.
    - Image priority: Custom Upload > Selected Photo > Album Cover.
    - Draft & scheduled posts support.



## 🛠 Technology Stack
- **Framework**: Laravel 12 (PHP 8.3+)
- **Frontend**: Blade + Bootstrap 5 (SB Admin 2 for Admin, Grayscale for Public)
- **Database**: MySQL / MariaDB
- **Image Processing**: Intervention Image v3
- **Server**: Optimized for cPanel / LiteSpeed



## 🚀 Installation & Setup

### Prerequisites
- PHP ≥ 8.3, Composer, Node.js & NPM, MySQL

### Local Development
```bash
git clone https://github.com/yourusername/anemoia-project.git
cd anemoia-project
composer install
npm install
cp .env.example .env
php artisan key:generate
# update .env with DB credentials
php artisan migrate
npm run dev
php artisan serve

Production (cPanel / Shared Hosting)
	1.	Build assets locally: npm run build
	2.	Push & pull to server via Git
	3.	Ensure document root → /public, PHP 8.3, fileinfo enabled
	4.	SSH Deployment Commands:

composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
pkill -9 php # LiteSpeed restart


📂 Key Project Structure
	•	app/Models – Gallery, Photo, Post
	•	app/Http/Controllers/Admin – Admin logic
	•	resources/views/layouts – site.blade.php, admin.blade.php
	•	resources/views/blog – Journal views
	•	routes/web.php – Public & Admin routes

👤 Default Admin User

$user = new App\Models\User();
$user->name = 'Admin Name';
$user->email = 'admin@example.com';
$user->password = Hash::make('YourPassword');
$user->is_admin = true;
$user->email_verified_at = now();
$user->save();

📸 Image Logic (Hero Priority)
	1.	Custom Upload – Directly uploaded to the post
	2.	Selected Photo – From linked gallery
	3.	Album Cover – Default gallery cover
	4.	Default – bg-masthead.webp

Remove any custom uploaded image to show the selected gallery photo.
