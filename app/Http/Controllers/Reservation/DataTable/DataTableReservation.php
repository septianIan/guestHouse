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
        $reservations = Reservation::whereIn('status', [1,2,3])->latest()->get();
        return datatables()->of($reservations)
        ->addColumn('action', 'frontOffice.template.components.action.DT-action')
        ->addColumn('status', function(Reservation $reservation){
            if ($reservation->getStatusReservation() == 'Confirm') {
                $data = '<font style="color:blue;font-weight:bold;">'.$reservation->getStatusReservation().'</font>';
            } elseif ($reservation->getStatusReservation() == 'Tentative') {
                $data = '<font style="color:red;font-weight:bold;">'.$reservation->getStatusReservation().'</font>';
            } elseif ($reservation->getStatusReservation() == 'Changed') {
                $data = '<font style="color:#2ecc71;font-weight:bold;">'.$reservation->getStatusReservation().'</font>';
            } else {

            }
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action'])
        ->toJson();
    }
}
