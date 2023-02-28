# NOTE SPESE BACKEND

This project is based on Laravel 9.19 and provides some APIs for authenticate users, read and create categories and movements.
You can find the REACT frontend [HERE](https://github.com/tommaso-cisternino/notespese_frontend) .

Report bug or simply give me suggestions to improve my skills at my [GITHUB REPO](https://github.com/tommaso-cisternino/notespese_backend)

## BASIC INSTALLATION (RECOMMENDED)
Install and configure
- Apache
- MySQL

Create a new database named **_notespese_**

In **.env** set the following VARIABLE:

    DB_HOST=127.0.0.1  


If you need you can edit _**DB_USERNAME**_ and _**DB_PASSWORD**_ too.

After this run via terminal:

    composer install  
    php artisan migrate
	php artisan jwt:secret 
	php artisan serve  

## INSTALLATION WITH DOCKER(may give some permission problems in some Linux distros,I'm fixing dockerfile)
In **.env.example** set the following VARIABLE:

	DB_HOST=notespese_db 
then run

	docker-compose up -d --build
