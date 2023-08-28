# Random Game
This repository contains a web application for generating unique links to a special game called "Random Game." The main page offers users to sign up by providing their Username and Phonenumber. After registration, the user receives a unique link that grants access to the game page for a certain period of time.

## Installation and Setup
### Step 1
Clone this repository to your local machine:
```console
https://github.com/ArtemPleskachov/DP22082023-01.git
````

### Step 2
Create a copy of the `.env.example` file and name it `.env`. 
Change `APP_NAME` in `.env`.
Configure your database access and other configurations.

### Step 3
Build and start the Docker containers:
```console
docker-compose up --build
```

### Step 4
Access the PHP container (Use {APP_NAME} from `.env` file):
```console
 docker exec -i -t "php_${APP_NAME}" /bin/bash
```
### Step 5
Install Laravel dependencies:

```console
composer install
```

### Step 6
Generate a key using the command:
```console
php artisan key:generate
```

### Step 7
Run migrations to create the necessary database tables:
```console
php artisan migrate
```

### Step 8
Open a web browser and go to http://localhost to view the app and play the game.

## Troubleshooting
In case of encountering errors, you can try the following commands to clear cache and configuration:

```console
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```
or simple
```console
php artisan cache:optimize
```

## Technologies Used
- Laravel
- PHP
- MySQL
- Docker

## Author
- Artem Pleskachov
