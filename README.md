# 🛒 Laravel Ecommerce Project (Docker Ready)

A full-stack Laravel ecommerce application built with Blade, MySQL, and Docker.  
This project includes product management, cart system, orders, wishlist, reviews, and a complete admin panel.

It is fully containerized using Docker, so anyone can run it with a single command.



---

# ⚡ QUICK START (DOCKER)

## 1. Clone the project

```bash
git clone https://github.com/your-username/ecommerce.git
cd ecommerce
```

---

## 2. Start Docker

```bash
docker compose up -d --build
```

---

## 3. Install dependencies

```bash
docker compose exec app composer install
```

---

## 4. Setup environment

```bash
cp .env.example .env
```

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=ecommerce
DB_PASSWORD=secret
```

---

## 5. Generate app key

```bash
docker compose exec app php artisan key:generate
```

---

## 6. Run migrations

```bash
docker compose exec app php artisan migrate
```

---

## 🌐 OPEN APPLICATION

| Service | URL |
|---------|-----|
| Laravel App | [http://localhost](http://localhost) |
| phpMyAdmin | [http://localhost:8080](http://localhost:8080) |

---

# 🧠 PROJECT OVERVIEW

This is a **Laravel-based ecommerce system** designed for learning and production-level architecture practice.

It includes:

- Product listing & details
- Shopping cart (session-based)
- Wishlist system
- Order placement system
- Review & rating system
- Admin dashboard (products, orders, users)
- Dockerized development environment

---

# 🏗️ TECHNOLOGY STACK

## Backend

- PHP 8.2
- Laravel 12
- MySQL (via Docker)
- Eloquent ORM

## Frontend

- Blade templates (server-side rendering)
- Tailwind CSS
- Alpine.js (light interactivity)
- Vite (asset bundler)

## DevOps

- Docker
- Docker Compose
- Nginx
- phpMyAdmin
- Redis (optional caching)

---

# 📁 PROJECT STRUCTURE

```
app/
├── Http/
│   ├── Controllers/       → Business logic (products, orders, admin)
│   └── Requests/          → Form validation
├── Models/                → Database models (User, Product, Order)
│
routes/
├── web.php                → All web routes
│
resources/
├── views/                 → Blade UI pages
│
database/
├── migrations/            → Database schema
├── factories/             → Model factories
├── seeders/               → Database seeders
│
public/
├── storage/               → User uploads (images, files)
```

---

# 🛍️ MAIN FEATURES

## 🛒 Product System

- Add / Edit / Delete products (admin)
- Product images support
- Categories & stock management
- Product listing page with search

---

## 🛍️ Shopping Cart

- Session-based cart system
- Add/remove products
- Increase/decrease quantity
- Automatic total calculation

---

## 📦 Orders System

- Place order from cart
- Store order history
- Order status tracking:
  - Pending
  - Processing
  - Shipped
  - Delivered
  - Cancelled

---

## ❤️ Wishlist

- Save favorite products
- Move wishlist items to cart

---

## ⭐ Reviews & Ratings

- Users can rate products
- Admin approval system for reviews

---

## 🛠️ Admin Panel

- Manage products
- Manage orders
- Manage users
- Manage categories
- Update order status
- Control inventory

---

# 🔄 HOW THE SYSTEM WORKS

## 1. User Flow

1. User visits products page
2. Adds items to cart
3. Proceeds to checkout
4. Order is stored in database
5. Stock is reduced automatically

---

## 2. Cart System

- Stored in Laravel session
- No login required for cart
- Converted into order during checkout

---

## 3. Admin System

- Admin has full access to:
  - Products
  - Orders
  - Users
  - Reviews

---

# 🧱 DATABASE STRUCTURE

Main tables:

- `users` - User accounts and admin status
- `products` - Product catalog
- `product_images` - Product gallery images
- `orders` - Customer orders
- `wishlists` - User saved items
- `reviews` - Product ratings and comments
- `categories` - Product categories
- `banners` - Marketing banners
- `coupons` - Discount codes

---

# 🐳 DOCKER ARCHITECTURE

Services:

- **app** (Laravel PHP-FPM) - Application container
- **nginx** - Web server (port 80)
- **mysql** - Database server (port 3306)
- **phpmyadmin** - Database UI (port 8080)
- **redis** - Cache server (optional)

---

# ⚠️ IMPORTANT NOTES

### 1. Environment file

Never push `.env` to GitHub.

Use `.env.example` instead.

---

### 2. Docker issues

If containers don't start:

```bash
docker compose down
docker compose up -d --build
```

---

### 3. Storage issue (images)

Run:

```bash
docker compose exec app php artisan storage:link
```

---

### 4. Database connection

If you get connection errors:

- Check `.env` file has correct `DB_HOST=mysql`
- Ensure containers are running: `docker compose ps`

---

# 🚀 FUTURE IMPROVEMENTS

- Stripe / Razorpay payment gateway
- JWT authentication / API version
- React frontend upgrade
- Product recommendation system
- Email notifications (Mailhog → production mail)
- Admin analytics dashboard
- Inventory notifications
- Advanced search & filtering
- Bulk operations

---

# 🎯 FINAL RESULT

This project is designed to be:

✔ Beginner friendly  
✔ Production scalable  
✔ Docker ready  
✔ Easy to extend  
✔ Real-world ecommerce simulation

---

# 💡 KEY IMPROVEMENTS

✔ Removed confusing setup warnings  
✔ Made Docker flow simple and clean  
✔ Added proper architecture explanation  
✔ Production-ready structure  
✔ Clear feature documentation  
✔ Future upgrade roadmap  

---

# 🚀 QUICK HELP

**Want to add a new feature?** Check the admin panel for existing CRUD operations.

**Need to debug?** Use `docker compose logs -f app` to view Laravel logs.

**Database issues?** Access phpMyAdmin at `http://localhost:8080` (admin/admin).

---

Happy coding! ✅
