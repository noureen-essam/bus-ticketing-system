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

        $validateInfo = $this->validateInfo($trip_id, $start_station_id, $end_station_id);
        if(!$validateInfo['isValid']){
            return response()->json(['error' => $validateInfo['errorMsg']], 404);
        }

        $connectionIds = $this->getTripConnections($trip_id, $start_station_id, $end_station_id);
        if($connectionIds == 'error'){
            return response()->json(['error' => 'Trip does not pass by the sent stations'], 404);
        }
        $bookedSeatNumbers = $this->getBookedSeats($connectionIds);
        if($bookedSeatNumbers == 'error'){
            return response()->json(['error' => 'No Available seats'], 200);
        }
        $availableSeats=array_values(array_diff(range(1, 12), $bookedSeatNumbers));

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
        return response()->json(['success' => 'Done','ticket' => $newTicket], 200);
    }

    public function getAvailableSeats(int $trip_id,int $start_station_id, int $end_station_id){
        $validateInfo = $this->validateInfo($trip_id, $start_station_id, $end_station_id);
        if(!$validateInfo['isValid']){
            return response()->json(['error' => $validateInfo['errorMsg']], 404);
        }
        $connectionIds = $this->getTripConnections($trip_id, $start_station_id, $end_station_id);
        if($connectionIds == 'error'){
            return response()->json(['error' => 'Trip does not pass by the sent stations'], 404);
        }
        $bookedSeatNumbers = $this->getBookedSeats($connectionIds);
        if($bookedSeatNumbers == 'error'){
            return response()->json(['error' => 'No Available seats'], 200);
        }
        return response()->json(['available seats' => array_values(array_diff(range(1, 12), $bookedSeatNumbers))], 200);
    }

    // check if trip, start/end stations ids exists
    public function validateInfo($trip_id, $start_station_id, $end_station_id){
        $isValid=true;
        $errorMsg='';
        $trip=Trips::find($trip_id);
        if(!$trip){
            $isValid = false;
            $errorMsg = 'Trip id not exist';
        }
        $startStation=Stations::find($start_station_id);
        if(!$startStation){
            $isValid = false;
            $errorMsg = 'Start Stations id not exist';
        }
        $endStation=Stations::find($end_station_id);
        if(!$endStation){
            $isValid = false;
            $errorMsg = 'End Stations id not exist';
        }
        return ["isValid"=>$isValid,"errorMsg"=>$errorMsg];
    }

    // Get all trip connections between start and end
    public function getTripConnections($trip_id, $start_station_id, $end_station_id){
        $destinationId = $start_station_id;
        $connectionIds = [];
        while($destinationId <> $end_station_id) {
            $TripConnections = TripConnections::where('trip_id',$trip_id)->where('start_station_id',$destinationId)->first();
            if(!$TripConnections){
                return 'error';
            }
            $destinationId = $TripConnections['end_station_id'];
            array_push($connectionIds, $TripConnections['id']);
        }
        return $connectionIds;
    }

    //Get list of booked seats
    public function getBookedSeats($connectionIds){
        $ticketIds=[];
        foreach ($connectionIds as $connectionId) {
            $ticketDetails = TicketDetails::where('trip_connection_id',$connectionId)->get();
            if(count($ticketDetails) >= 12){
                return 'error';
            }
            $ticketIds = array_unique (array_merge ($ticketIds, $ticketDetails->pluck('ticket_id')->toArray()));
        }
        $bookedSeatNumbers=Tickets::whereIn('id',$ticketIds)->pluck('seatNumber')->toArray();
        return $bookedSeatNumbers;
    }
}
