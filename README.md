# NOTE SPESE BACKEND

This project is based on Laravel 9.19 and provides some APIs for authenticate users, read and create categories and movements.

Report bug or simply give me suggestions to improve my skills at my [GITHUB REPO](https://github.com/tommaso-cisternino/notespese_backend)

## BASIC INSTALLATION (RECOMMENDED)
Install and configure
- Apache
- MySQL

Create a new database named notespese

In .env set the following VARIABLE:

    DB_HOST=127.0.0.1  


If you need you can edit DB_USERNAME and DB_PASSWORD too.

Run via terminal:

    composer install  
	php artisan jwt:secret 
	php artisan serve  

## INSTALLATION WITH DOCKER (may give some permission problems,I'm fixing dockerfile)
In .env set the following VARIABLE:

	DB_HOST=db  
then run

	docker-compose up -d --build
