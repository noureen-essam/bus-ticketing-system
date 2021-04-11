<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripConnections extends Model
{
    protected $table = 'trip_connections';

    protected $primaryKey = 'id';

    protected $fillable = ['trip_id', 'start_station_id', 'end_station_id'];
}
