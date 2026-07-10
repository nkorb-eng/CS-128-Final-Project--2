# Hotel Blue Bird — Hotel Management System (Laravel)

A hotel management system migrated from a raw PHP + MySQL project into the
**Laravel** framework (Laravel 13 / PHP 8.3). It provides a public booking
site plus an admin panel for managing rooms, reservations, payments/invoices
and staff.

Original PHP project: `tushar-2223/Hotel-Management-System`.

## Features

- **User side** – sign up / log in, browse rooms & facilities, submit a room
  reservation.
- **Admin side** – dashboard with booking/profit charts, manage room bookings
  (add / edit / confirm / delete / export to Excel), payments with printable
  invoices, room inventory, and staff.

## Tech

- Laravel 13, PHP 8.3
- SQLite (default, zero-config) — works with MySQL too
- Blade views, Eloquent models, Chart.js + Morris.js dashboards

## Setup

```bash
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
touch database/database.sqlite # Windows: New-Item database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Then open http://127.0.0.1:8000.

## Demo logins (created by the seeder)

| Role  | Email                            | Password |
|-------|----------------------------------|----------|
| Admin | `Admin@gmail.com`                | `1234`   |
| User  | `tusharpankhaniya2202@gmail.com` | `123`    |

- Admin login goes to `/admin` (the admin panel).
- User login goes to `/home` (the public site).

## Structure

| Area | Files |
|------|-------|
| Routes | `routes/web.php` |
| Auth | `app/Http/Controllers/AuthController.php`, `app/Http/Middleware/` |
| Public site | `app/Http/Controllers/HomeController.php`, `resources/views/home.blade.php` |
| Admin | `app/Http/Controllers/Admin/*`, `resources/views/admin/*` |
| Data | `app/Models/*`, `database/migrations/*_create_hotel_tables.php`, `database/seeders/DatabaseSeeder.php` |
| Assets | `public/css`, `public/image`, `public/javascript`, `public/adminassets` |

## Notes

- Passwords are stored/compared as plain text to match the behaviour of the
  original project. For production use, switch to Laravel's hashed
  authentication.
