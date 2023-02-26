# NOTE SPESE BACKEND

This project is based on Laravel 9 and provides some APIs for authenticate users, read and create categories and movements.

## BASIC INSTALLATION
Install and configure
- Apache
- MySQL DB

Create a new database named notespese

Set values to DB ENV VARIABLES in .env if needed.

Run via terminal:
'composer install'
'php artisan jwt:secret'
'php artisan serve --port 4000'

## INSTALLATION WITH DOCKER
Run  docker-compose up -d --build or docker run
