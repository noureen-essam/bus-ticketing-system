<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDetails extends Model
{

    protected $table = 'ticket_details';

    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = ['ticket_id', 'trip_connection_id'];

}
