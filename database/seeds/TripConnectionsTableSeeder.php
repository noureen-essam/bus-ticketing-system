<?php

use Illuminate\Database\Seeder;
use App\TripConnections;
use App\Stations;
use App\Trips;

class TripConnectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
//        TripConnections::truncate();

        // And now, let's create a few articles in our database:
        TripConnections::create([
            'trip_id' => Trips::where('tripName','Line 1')->first()['id'],
            'start_station_id' => Stations::where('stationName','Cairo')->first()['id'],
            'end_station_id'=>Stations::where('stationName','AlFayyum')->first()['id']
        ]);
        TripConnections::create([
            'trip_id' => Trips::where('tripName','Line 1')->first()['id'],
            'start_station_id' => Stations::where('stationName','AlFayyum')->first()['id'],
            'end_station_id'=>Stations::where('stationName','AlMinya')->first()['id']
        ]);
        TripConnections::create([
            'trip_id' => Trips::where('tripName','Line 1')->first()['id'],
            'start_station_id' => Stations::where('stationName','AlMinya')->first()['id'],
            'end_station_id'=>Stations::where('stationName','Asyut')->first()['id']
        ]);
    }
}
