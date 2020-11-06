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
        $reservationGroup = ReservationGroup::whereIn('status', ['checkIn','confirm','tentative', 'changed'])->latest()->get();
        return \datatables()->of($reservationGroup)
        ->addColumn('action', 'frontOffice.template.components.action.DT-action')
        ->addColumn('status', function(ReservationGroup $reservation){
            if ($reservation->status == 'confirm') {
                $data = '<font style="color:blue;font-weight:bold;">Confirm</font>';
            } elseif ($reservation->status == 'tentative') {
                $data = '<font style="color:red;font-weight:bold;">Tentative</font>';
            } elseif ($reservation->status == 'changed') {
                $data = '<font style="color:#2ecc71;font-weight:bold;">Changed</font>';
            } elseif($reservation->status == 'checkIn') {
                $data = '<font style="color:green;font-weight:bold;">Check In</font>';
            }
            return $data;
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action'])
        ->toJson();
    }
}
