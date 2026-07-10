# Vibe App

A clean Laravel 13 project prepared for shared hosting such as Hostinger.

## Requirements

- PHP 8.3 or newer
- Composer
- MySQL database

## Local Installation

```bash
composer create-project laravel/laravel vibe-app
cd vibe-app
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Open `http://localhost:8000` in your browser.

## Environment

Update `.env` with your MySQL credentials:

```env
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## Shared Hosting

This project does not require Node.js, npm, or Vite. Tailwind CSS is loaded from the CDN, and local CSS/JS files are served from the `public` folder with Laravel's `asset()` helper.

For production:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set your hosting web root to the `public` folder whenever your hosting panel allows it.
