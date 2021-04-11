<?php

use Illuminate\Database\Seeder;
use App\Stations;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
//        Stations::truncate();

        // And now, let's create a few stations in our database:
        Stations::create([
            'stationName' => 'Alexandria'
        ]);
        Stations::create([
            'stationName' => 'Cairo'
        ]);
        Stations::create([
            'stationName' => 'AlFayyum'
        ]);
        Stations::create([
            'stationName' => 'AlMinya'
        ]);
        Stations::create([
            'stationName' => 'Asyut'
        ]);
    }
}
