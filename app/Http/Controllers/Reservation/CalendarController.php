<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Reservation;
use App\ReservationGroup;
use Illuminate\Http\Request;
use Calendar;
use DateTime;

class CalendarController extends Controller
{
    public function index()
    {   
        $reservations = Reservation::get();
        $in_out = [];
        foreach($reservations as $reservation){
            $in_out[] = Calendar::event(
                $reservation->guestName,
                true,
                new DateTime($reservation->arrivaleDate),
                new DateTime($reservation->departureDate.'+1 day'),
                $reservation->id
            );
        }

        $calendar = Calendar::addEvents($in_out);
        // return $in_out;
        return \view('frontOffice.calender.index', \compact('calendar'));
    }
}
