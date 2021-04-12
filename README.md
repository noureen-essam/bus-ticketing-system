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
DB_PASSWORD=xxxxx<br>

## Run the database migrations

php artisan migrate

## Run the database seeder

php artisan db:seed

## Start the local development server

php artisan serve


## APIs
Don't forget to send the api_token with the request <br>
The token must be equal to the APP_KEY in .env file to authorize the request<br><br>

'/book/ticket/line/{trip_id}/from/{start_station_id}/to/{end_station_id}'<br>
Route to book a seat in trip <br><br>

'/get/trip/{trip_id}/available/seats/from/{start_station_id}/to/{end_station_id}'<br>
Route to get a list of available seats in trip <br><br>

'/get/all/trips'<br>
Route to get all available trips<br><br>

'/get/trip/{trip_id}/stations'<br>
Route to get stations of trip<br>

