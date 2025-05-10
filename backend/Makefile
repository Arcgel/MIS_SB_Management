.PHONY: install build run test

install:
	 composer install
	 npm install

build:
	copy .env.example .env || echo ".env already exists, skipping copy"
	php artisan key:generate
	php artisan migrate --force
	php artisan db:seed --force

run:
	php artisan serve

test:
	php artisan migrate:fresh --env=testing
	php artisan test
