# Shared Hosting Deployment Notes

This Laravel project is prepared for hosting providers such as Hostinger where Node.js may not be available.

## Important

- Use PHP 8.3 or newer for Laravel 13.
- Run Composer locally or on the hosting server.
- Do not run npm commands for this project.
- The public web root must point to the `public` folder.
- If your host does not let you set the web root to `public`, upload the contents of `public` into `public_html` and carefully update `public_html/index.php` paths to point back to the Laravel project folders.

## Production Commands

Run these after uploading and configuring `.env`:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Use your hosting panel to create a MySQL database, then replace the placeholder database values in `.env`.
