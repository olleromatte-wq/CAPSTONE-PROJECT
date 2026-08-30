# NCBII Laravel Migration

The original HTML, CSS, JavaScript, and image files remain in place as the visual source of truth. The Laravel application uses the same class names and markup style while moving navigation and authentication to Blade, routes, and server sessions.

## Setup

1. Install PHP 8.2+, Composer, and Laravel requirements.
2. From this folder run `composer install`.
3. Copy `.env.example` to `.env` and run `php artisan key:generate`.
4. Run `php artisan serve` and open `http://127.0.0.1:8000`.

Student login accepts an ID in the format `2026-0001`. Existing prototype staff accounts are available through the staff access option; replace these demo credentials with database-backed users before production deployment.

## Converted routes

- `/` home portal
- `/login` login and session creation
- `/dashboard` student dashboard
- `/faculty` faculty dashboard
- `/administrator` administrator dashboard
- `/about` and `/features` public portal pages

The compatibility asset routes serve the existing root `style.css`, `mock-data.js`, and `images` directory without changing the design.
