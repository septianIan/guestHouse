<?php

namespace App\Http\Controllers\Chart;

use Acaronlex\LaravelCalendar\Facades\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;
use App\ReservationGroup;
use App\Room;
use Carbon\Carbon;
use DateTime;

class ChartPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        return view('frontOffice.chartPlan.betweenDate', \compact('data'));
    }

    public function roomsStatus()
    {
        return view('frontOffice.fitur.roomsStatus', [
            'rooms' => Room::get()
        ]);
    }
}
