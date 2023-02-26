#!/bin/sh

composer install

rm -f .env
cp .env.example .env

# Migrations
php artisan migrate --force
php artisan jwt:secret

php-fpm
