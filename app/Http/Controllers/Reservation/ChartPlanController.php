<?php

namespace App\Http\Controllers\Reservation;

use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;
use App\ReservationGroup;
use Carbon\Carbon;
use DateTime;

class ChartPlanController extends Controller
{
    public function calendar()
    {   
        $reservations = Reservation::get();

        $in_out = [];
        foreach($reservations as $reservation){
            $in_out[] = Calendar::event(
                $reservation->guestName,
                true,
                new DateTime($reservation->arrivaleDate),
                new DateTime($reservation->departureDate.'+1 day'),
                '$reservation->id',
                [
                    'url' => 'http://full-calendar.io'
                ]
            );
        }

        $calendar = Calendar::addEvents($in_out);
        return \view('frontOffice.reservation.chartPlan.calendar', \compact('calendar'));
    }

    public function betweenDate()
    {   
        $from = date('2020-09-20');
        $to = date('2020-10-05');

        $checkReser = Reservation::whereBetween('arrivaleDate', [$from, $to])->get()->toArray();
        $checkReserGroup = ReservationGroup::whereBetween('arrivaleDate', [$from, $to])->get()->toArray();
        // dd($checkReser);
        // dd($checkReserGroup);
        $data = \array_merge($checkReser, $checkReserGroup);
        // \dd(\collect($data));
        return view('frontOffice.reservation.chartPlan.betweenDate', \compact('data'));
    }
}
