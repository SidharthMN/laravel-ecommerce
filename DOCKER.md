# Docker Setup Guide

This Laravel ecommerce project is now Dockerized! Follow these steps to get it running.

## Prerequisites

- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Quick Start

### 1. Clone or navigate to your project
```bash
cd d:\SIDSOID\ecommerce
```

### 2. Copy environment file
```bash
cp .env.docker .env
```

Or update your `.env` file with Docker database credentials:
```
DB_HOST=mysql
DB_DATABASE=ecommerce
DB_USERNAME=ecommerce
DB_PASSWORD=secret
REDIS_HOST=redis
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### 3. Generate APP_KEY (if not set)
```bash
docker-compose run --rm app php artisan key:generate
```

### 4. Build and start containers
```bash
docker-compose up -d
```

This will start:
- **Laravel App** on `http://localhost`
- **phpMyAdmin** on `http://localhost:8080`
- **Mailhog** (Email UI) on `http://localhost:8025`
- **MySQL** database
- **Redis** cache

### 5. Run migrations
```bash
docker-compose exec app php artisan migrate
```

### 6. Seed database (optional)
```bash
docker-compose exec app php artisan db:seed
```

### 7. Install frontend dependencies
```bash
docker-compose exec app npm install
```

### 8. Build frontend assets
```bash
docker-compose exec app npm run build
```

## Common Commands

### View logs
```bash
docker-compose logs -f app
```

### Run Artisan commands
```bash
docker-compose exec app php artisan [command]
```

### Access database
```bash
docker-compose exec mysql mysql -u ecommerce -p ecommerce
```

### Stop containers
```bash
docker-compose stop
```

### Remove containers
```bash
docker-compose down
```

### Remove containers and volumes (careful!)
```bash
docker-compose down -v
```

## Services

| Service    | URL / Port    | Credentials |
|------------|---------------|-------------|
| Laravel    | http://localhost | - |
| phpMyAdmin | http://localhost:8080 | user: `ecommerce`, pass: `secret` |
| Mailhog    | http://localhost:8025 | - |
| MySQL      | localhost:3306 | user: `ecommerce`, pass: `secret` |
| Redis      | localhost:6379 | - |

## Troubleshooting

### Port already in use
Change the port in `docker-compose.yml`:
```yaml
ports:
  - "8000:80"  # Changes port from 80 to 8000
```

### Permission denied
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Database connection error
Ensure MySQL container is healthy:
```bash
docker-compose ps
```

### Rebuild containers
```bash
docker-compose build --no-cache
docker-compose up -d
```

## Production Deployment

For production, use:
```bash
docker build -t ecommerce:latest .
docker run -d --name ecommerce_app -e APP_ENV=production ecommerce:latest
```

Update your `.env` with production database credentials before deploying.

## File Structure
```
ecommerce/
├── docker/
│   ├── nginx/
│   │   └── conf.d/
│   │       └── app.conf
│   └── php/
│       └── php.ini
├── Dockerfile
├── docker-compose.yml
├── .dockerignore
└── .env.docker
```

---

For more info, see [Laravel Docker documentation](https://laravel.com/docs/deployment#docker)
