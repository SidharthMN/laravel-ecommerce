# Ecommerce Laravel Project

A Docker-ready Laravel ecommerce application scaffold. This repository includes the Laravel backend, frontend assets, database migrations, and Docker configuration needed to run the app locally using containers.

### IMPORTANT THINGS TO CARE OF

1) Disable the web shields of Avast (or any) for proper working as it doesn't allow to run.

2) The shields doesnt allow to run if you use composer.phar instead of direct composer 
installation that is crucial for many devices and it blocks server.php for unproper installation.

3) Make user to install XAMPP Control Panel and turn on
  Apache and Mysql 
You can see the ports there in case of connection related problems
Check on database



##  GitHub + Docker 

### ✅ 1. YOUR PROJECT STRUCTURE (IMPORTANT)

Make sure your repo includes:

```text
ecommerce/
│── app/
│── bootstrap/
│── config/
│── database/
│── public/
│── resources/
│── routes/
│── docker-compose.yml
│── Dockerfile
│── nginx.conf
│── .env.example
│── composer.json
│── package.json
```

❌ DO NOT upload:

```text
vendor/
node_modules/
.env
```

---

## 🚀 2. PUSH TO GITHUB

Inside your project:

```bash
git add .
git commit -m "Docker Laravel ecommerce setup"
git push origin main
```

---

## 🚀 3. WHAT OTHER PERSON DOES (CLONE + RUN)

### Step 1: Clone project

```bash
git clone https://github.com/SidharthMN/laravel-ecommerce.git
cd ecommerce
```

---

### Step 2: Start Docker

```bash
docker compose up -d --build
```

---

### Step 3: Install Laravel inside container

```bash
docker compose exec app composer install
```

---

### Step 4: Setup environment

```bash
cp .env.example .env
```

Then edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

---

### Step 5: Generate key

```bash
docker compose exec app php artisan key:generate
```

---

### Step 6: Run migrations

```bash
docker compose exec app php artisan migrate
```

---

## 🌐 4. OPEN PROJECT

### Laravel App

```text
http://localhost
```

### phpMyAdmin

```text
http://localhost:8080
```

---

## ⚡ FINAL RESULT

Anyone can now run your project with:

```bash
git clone 
docker compose up -d --build
```

## Project Overview

This ecommerce app is built on Laravel and includes:

- Laravel MVC structure in `app/`, `routes/`, and `resources/`
- Database migrations in `database/migrations`
- Docker and Docker Compose configuration for local development
- Nginx and PHP setup for containerized hosting
- Frontend tooling via `package.json`

## Deep Dive: How This Project Works

### Technology stack

- **PHP 8.2**: the server-side language powering Laravel and the backend logic.
- **Laravel 12**: the framework used for routing, controllers, Blade views, Eloquent models, authentication, and business logic.
- **Blade + Alpine.js + Tailwind CSS**: the UI stack used in this repo for server-rendered pages with lightweight client-side interactions.
- **Vite**: the build tool for compiling CSS and JavaScript assets.
- **MySQL / MariaDB**: the intended database engine for ecommerce data, configured through Docker.
- **Docker + Docker Compose**: containerization for reproducible local development, including PHP, database, and web server services.

### Backend
- PHP 8.2
- Laravel 12
- MySQL (Docker)
- Eloquent ORM
### Frontend
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite
### DevOps
- Docker
- Docker Compose
- Nginx
- phpMyAdmin
- Redis (optional)

> Note: This project does not currently include a React frontend implementation. It is built with Laravel Blade templates and Alpine.js, which keeps the UI fast and simple.

### Why Laravel and PHP?

- Laravel gives you a strong, structured backend with routing, middleware, validation, and security built in.
- PHP is a mature server language with huge hosting support and tight integration with Laravel.
- Laravel makes CRUD easy using Eloquent models, mass assignment, and database migrations.
- Built-in auth scaffolding and middleware help protect user and admin routes quickly.

### How the app is structured

- `app/Http/Controllers/`: holds the controller logic for products, orders, admin actions, reviews, wishlists, and profile management.
- `app/Models/`: holds the Eloquent models such as `Product`, `Order`, `Review`, `Wishlist`, and `User`.
- `routes/web.php`: defines public, authenticated, and admin routes for the entire application.
- `resources/views/`: contains Blade templates for pages such as products, cart, checkout, wishlist, orders, and admin screens.
- `database/migrations/`: defines the database schema for users, products, orders, reviews, categories, coupons, banners, and related tables. Helps in creating db

### Main user flows

1. **Browse products**
   - `GET /products` loads the product list with search and review averages.
   - `GET /products/{product}` loads detailed product information, images, and approved reviews.

2. **Shopping cart**
   - `POST /cart/add/{id}` adds items to the cart stored in the user session.
   - `POST /cart/remove/{id}`, `/cart/increase/{id}`, and `/cart/decrease/{id}` manage cart quantity and removal.

3. **Checkout and order placement**
   - `GET /checkout` shows the checkout page.
   - `POST /place-order` validates customer data, creates an `Order`, decrements product stock, and clears the cart.
   - Orders are stored with a `products` JSON array and cast back to an array on the model.

4. **Wishlist**
   - `POST /wishlist/{product}` adds an item while preventing duplicates.
   - `DELETE /wishlist/{product}` removes it.
   - `POST /wishlist/{product}/move-to-cart` transfers an item into the cart and removes it from the wishlist.

5. **Reviews**
   - `POST /products/{product}/reviews` allows an authenticated user to leave a rating/comment.
   - Reviews are saved with `is_approved` and only approved reviews show publicly.

6. **Admin management**
   - Admins can manage orders, products, users, categories, banners, coupons, and reviews.
   - Order status can be updated using values such as `Pending`, `Processing`, `Shipped`, `Delivered`, and `Cancelled`.
   - Product CRUD actions are handled by the admin controller, including image uploads and stock updates.

### CRUD in this project

- **Create**
  - Products can be created by admins with image upload support.
  - Categories, banners, and coupons can also be created from the admin panel.
  - Users can create reviews and wishlist items.

- **Read**
  - Product listings, product details, cart contents, order history, wishlist, and admin dashboards are all read operations.
  - Eloquent relationships load images, reviews, and wishlist data.

- **Update**
  - Admin updates to products, orders, users, and reviews happen through validated requests.
  - The cart quantity update is handled in session data.

- **Delete**
  - Products, orders, users, categories, banners, coupons, and reviews can be deleted by admin users.
  - Wishlist items can be removed by normal users.

## 🐳 DOCKER SERVICES
- app (Laravel PHP)
- nginx (web server)
- mysql (database)
- phpmyadmin (DB UI)
- redis (cache)

## ⚠️ IMPORTANT NOTES
1. **Environment file**
  - Never push .env to GitHub.
  - Use .env.example.
2. **If Docker fails**
  - docker compose down
  - docker compose up -d --build
3. **Fix storage images**
  - php artisan storage:link

## 🚀 FUTURE IMPROVEMENTS
- Payment gateway (Stripe / Razorpay)
- Email notifications
- React frontend upgrade
- Admin analytics dashboard
- API versioning
- AI product recommendations

### Why this architecture works

- The app uses Laravel middleware to protect routes and require authentication.
- Controllers are responsible for request validation, model actions, and returning views.
- Models define relationships and mass-assignable fields so data access stays clean.
- Blade templates render server-side HTML while Alpine.js gives interactive behavior without a heavy SPA.
- Docker ensures the app runs consistently across machines, so the same commands work for every developer.

## Final notes

This project is a complete Laravel ecommerce foundation with user shopping flows, an admin control panel, session cart handling, product and order management, review moderation, and wishlist support. It is well-suited to grow into a React-powered frontend later, but today it is implemented as a Laravel/Blade app with modern tooling.

Happy building! ✅

---

## Deploying to Render (Free plan)

Render's free tier does not provide SSH or pre-deploy hooks, so the container must perform any first-time setup at runtime. This repository includes a runtime entrypoint script `docker-entrypoint.sh` that:

- installs Composer dependencies if missing
- ensures `.env` exists (copies from `.env.example`)
- creates the storage symlink
- clears caches
- runs database migrations with a retry loop (waits for DB to become ready)

What to set in Render (Environment):

APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY
DB_CONNECTION=mysql
DB_HOST=<your-db-host>
DB_PORT=3306
DB_DATABASE=<your-db-name>
DB_USERNAME=<your-db-user>
DB_PASSWORD=<your-db-pass>

Notes:

- The Dockerfile now copies `docker-entrypoint.sh` and sets it as the container `ENTRYPOINT`. The default `CMD` remains `php-fpm` so the entrypoint finishes setup and then starts the server.
- Migrations are run automatically at container start with retries to handle database cold starts.
- Because the entrypoint runs `composer install` when `vendor` is missing, no manual pre-deploy commands are required on Render.

If you prefer a different strategy (eg. run migrations from CI or use an external DB migration tool), remove or modify the `docker-entrypoint.sh` accordingly.
