<?php

use Illuminate\Database\Seeder;
use App\Trips;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
//        Trips::truncate();

        // And now, let's create a few articles in our database:
        Trips::create([
            'tripName' => 'Line 1'
        ]);
        Trips::create([
            'tripName' => 'Line 2'
        ]);
    }
}
