<?php

namespace App\Http\Controllers\Reservation\DataTable;

use App\Http\Controllers\Controller;
use App\Reservation;
use Illuminate\Http\Request;
use DataTables;

class DataTableReservation extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $reservations = Reservation::where('status', 0)->latest()->get();
        return datatables()->of($reservations)
        ->addColumn('action', 'frontOffice.template.components.action.DT-action')
        ->addColumn('status', function(Reservation $reservation){
            return $reservation->getStatusReservation();
        })
        ->addIndexColumn()
        ->toJson();
    }
}
