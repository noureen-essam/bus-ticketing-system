<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    protected $table = 'stations';

    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = ['stationName'];

}
