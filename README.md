<h1><p align="center" ><b>
Bus Booking System
</b>
</p></h1>

## Create new Database

Create Database <DB_name> <br>
ex: Create Database FLEET


## Update .env file

Update .env file with used database configuration<br>

DB_CONNECTION=sqlsrv<br>
DB_HOST=127.0.0.1<br>
DB_PORT=1433<br>
DB_DATABASE=FLEET<br>
DB_USERNAME=sa<br>
DB_PASSWORD=ArkansasHeartHospital!<br>

## Run the database migrations

php artisan migrate

## Run the database seeder

php artisan db:seed

## Start the local development server

php artisan serve

