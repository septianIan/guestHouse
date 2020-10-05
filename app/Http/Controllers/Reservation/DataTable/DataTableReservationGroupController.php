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
        $reservationGroup = ReservationGroup::whereIn('status', [1,2,3])->latest()->get();
        return \datatables()->of($reservationGroup)
        ->addColumn('action', 'frontOffice.template.components.action.DT-action')
        ->addColumn('status', function(ReservationGroup $reservation){
            if ($reservation->getStatusGroupReservation() == 'Confirm') {
                $data = '<font style="color:blue;font-weight:bold;">'.$reservation->getStatusGroupReservation().'</font>';
            } elseif ($reservation->getStatusGroupReservation() == 'Tentative') {
                $data = '<font style="color:red;font-weight:bold;">'.$reservation->getStatusGroupReservation().'</font>';
            } elseif ($reservation->getStatusGroupReservation() == 'Changed') {
                $data = '<font style="color:#2ecc71;font-weight:bold;">'.$reservation->getStatusGroupReservation().'</font>';
            } else {
            }
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action'])
        ->toJson();
    }
}
