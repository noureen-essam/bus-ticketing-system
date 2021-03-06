<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/book/ticket/line/{trip_id}/from/{start_station_id}/to/{end_station_id}','ticketsController@bookTrip')->middleware('api_token');
Route::get('/get/trip/{trip_id}/available/seats/from/{start_station_id}/to/{end_station_id}','ticketsController@getAvailableSeats')->middleware('api_token');


Route::get('/get/all/trips','ticketsController@getAllTrips')->middleware('api_token');
Route::get('/get/trip/{trip_id}/stations','ticketsController@getTripStations')->middleware('api_token');
