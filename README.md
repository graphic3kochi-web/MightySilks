# Mighty Silks (Laravel)

The Mighty Silks storefront (formerly the static site one folder up) on Laravel 13 + MySQL, with an
admin panel at `/admin`.

## Run it locally (XAMPP)

1. Start MySQL from the XAMPP control panel. The app uses the `mightysilk` database (`root`, no password; see `.env`).
2. First time only:
   ```
   php artisan migrate --seed            # catalogue, collections, blog, careers, coupons, admin
   php artisan db:seed --class=DemoSeeder # optional: sample customers/orders for the dashboard
   php artisan storage:link
   ```
3. `php artisan serve` and open http://127.0.0.1:8000. The admin panel is at http://127.0.0.1:8000/admin.

Admin login: `admin@mightysilks.ae` / `password`. **Change it in Admin › Settings.**

To start over with a clean database: `php artisan migrate:fresh --seed`.

## How it fits together

- **Pages** keep their old URLs (`about.html`, `sarees.html`…), rendered from `resources/views/pages`
  with a shared layout (`layouts/site`) and partials (header, footer, cart drawer, account menu).
- **Shop grids** on the 26 shop pages list their collection's products from the database
  (`partials/product-card`). Admin › Collections sets which products each page shows, and in what order.
- **`js/products.js`, `js/blogs.js` and `js/jobs.js`** are generated from the database
  (`SiteController`), so the product page, cart, blog and careers pages show what the admin manages.
- **The storefront scripts** (`public/js/main.js`, `product.js`) post to `api/*`:
  - checkout: prices, stock, coupons and shipping are checked on the server;
  - order details and tracking: tracking shows the status set in Admin › Orders;
  - sign-up, login (email/password or phone code) and log-out;
  - newsletter, bulk enquiries, job applications (CV kept privately) and reviews (held for approval).
- **Store settings** (shipping rates, featured coupon, careers benefits) feed checkout via `window.SHOP`.

## Not connected yet

- **Payments**: no gateway. Orders are recorded with payment "pending", and only a card's last 4 digits are kept.
- **SMS**: phone-login codes are written to `storage/logs/laravel.log` (and shown on screen while `APP_DEBUG=true`).
- **Email**: no order or enquiry emails are sent.
- The home page sliders and the product page's "You May Also Like" are still static.

Before going live, set `APP_ENV=production` and `APP_DEBUG=false`, and use a MySQL user with a password.
