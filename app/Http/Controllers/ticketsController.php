<?php

namespace App\Http\Controllers;

use App\Stations;
use App\TicketDetails;
use App\Tickets;
use App\TripConnections;
use App\Trips;
use Illuminate\Support\Str;

class ticketsController extends Controller
{

    public function bookTrip(int $trip_id,int $start_station_id, int $end_station_id)
    {
        $trip=Trips::find($trip_id);
        if(!$trip){
            return response()->json(['error' => 'Trip id not exist'], 404);
        }
        $startStation=Stations::find($start_station_id);
        if(!$startStation){
            return response()->json(['error' => 'Start Stations id not exist'], 404);
        }
        $endStation=Stations::find($end_station_id);
        if(!$endStation){
            return response()->json(['error' => 'End Stations id not exist'], 404);
        }

        $destinationId=$start_station_id;
        $connectionIds=[];

        while($destinationId <> $end_station_id) {
            $TripConnections = TripConnections::where('trip_id',$trip_id)->where('start_station_id',$destinationId)->first();
            $destinationId = $TripConnections['end_station_id'];
            array_push($connectionIds, $TripConnections['id']);
        }
        $ticketIds=[];

        foreach ($connectionIds as $connectionId) {
            $ticketDetails = TicketDetails::where('trip_connection_id',$connectionId)->get();
            if(count($ticketDetails) >= 12){
                return response()->json(['error' => 'No Available seats'], 200);
            }
            $ticketIds = array_unique (array_merge ($ticketIds, $ticketDetails->pluck('ticket_id')->toArray()));
        }
        $bookedSeatNumbers=Tickets::whereIn('id',$ticketIds)->pluck('seatNumber')->toArray();
        $availableSeats=array_diff(range(1, 12), $bookedSeatNumbers);

        $uuid = Str::uuid()->toString();
        $ticketCode = strtoupper(substr($uuid, 0, 5));
        $newTicket = new Tickets();
        $newTicket->ticketCode = $ticketCode;
        $newTicket->seatNumber = $availableSeats[0];
        $newTicket->save();
        foreach ($connectionIds as $connectionId) {
            $newTicketDetails = new TicketDetails();
            $newTicketDetails->ticket_id = $newTicket['id'];
            $newTicketDetails->trip_connection_id = $connectionId;
            $newTicketDetails->save();
        }
        return response()->json(['success' => 'Done','ticket' =>$newTicket], 200);
    }

    public function getAvailableSeats(int $trip_id,int $start_station_id, int $end_station_id){

        $trip=Trips::find($trip_id);
        if(!$trip){
            return response()->json(['error' => 'Trip id not exist'], 404);
        }

        $startStation=Stations::find($start_station_id);
        if(!$startStation){
            return response()->json(['error' => 'Start Stations id not exist'], 404);
        }

        $endStation=Stations::find($end_station_id);
        if(!$endStation){
            return response()->json(['error' => 'End Stations id not exist'], 404);
        }

        $destinationId=$start_station_id;
        $connectionIds=[];

        while($destinationId <> $end_station_id) {
            $TripConnections = TripConnections::where('trip_id',$trip_id)->where('start_station_id',$destinationId)->first();
            $destinationId = $TripConnections['end_station_id'];
            array_push($connectionIds, $TripConnections['id']);
        }
        $ticketIds=[];

        foreach ($connectionIds as $connectionId) {
            $ticketDetails = TicketDetails::where('trip_connection_id',$connectionId)->get();
            if(count($ticketDetails) >= 12){
                return response()->json(['error' => 'No Available seats'], 200);
            }
            $ticketIds = array_unique (array_merge ($ticketIds, $ticketDetails->pluck('ticket_id')->toArray()));
        }
        $bookedSeatNumbers=Tickets::whereIn('id',$ticketIds)->pluck('seatNumber')->toArray();

        return array_diff(range(1, 12), $bookedSeatNumbers)[0];

    }
}
