<?php

namespace App\Http\Controllers\Reservation\DataTable;

use App\Http\Controllers\Controller;
use App\ReservationGroup;

class DataTableReservationGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $reservationGroup = ReservationGroup::where('status', 0)->latest()->get();
        return \datatables()->of($reservationGroup)
        ->addColumn('action', 'frontOffice.template.components.action.DT-action')
        ->addIndexColumn()
        ->toJson();
    }
}
