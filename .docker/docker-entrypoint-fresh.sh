#!/bin/sh

rm -f .env
cp .env.example .env
php artisan cache:clear
php artisan key:generate
chown -R apache:apache /var/www
php artisan migrate
#php artisan jwt:secret
exec "$@"
