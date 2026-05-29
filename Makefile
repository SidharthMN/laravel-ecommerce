.PHONY: help up down restart logs build install migrate seed tinker bash

help:
	@echo "Available commands:"
	@echo "  make up              Start all containers"
	@echo "  make down            Stop all containers"
	@echo "  make restart         Restart all containers"
	@echo "  make logs            View application logs"
	@echo "  make build           Build Docker images"
	@echo "  make install         Install PHP dependencies"
	@echo "  make migrate         Run database migrations"
	@echo "  make seed            Seed the database"
	@echo "  make tinker          Start Tinker shell"
	@echo "  make bash            Access app container bash"
	@echo "  make clean           Remove containers and volumes"

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose restart

logs:
	docker-compose logs -f app

build:
	docker-compose build

install:
	docker-compose exec app composer install

migrate:
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed

tinker:
	docker-compose exec app php artisan tinker

bash:
	docker-compose exec app bash

clean:
	docker-compose down -v

npm-install:
	docker-compose exec app npm install

npm-build:
	docker-compose exec app npm run build

npm-dev:
	docker-compose exec app npm run dev

key-generate:
	docker-compose exec app php artisan key:generate

cache-clear:
	docker-compose exec app php artisan cache:clear

config-cache:
	docker-compose exec app php artisan config:cache

optimize:
	docker-compose exec app php artisan optimize

fresh:
	docker-compose exec app php artisan migrate:fresh --seed
