<?php

namespace App\Http\Controllers\Reservation\DataTable;

use App\Http\Controllers\Controller;
use App\Reservation;
use Illuminate\Http\Request;

class DataTableCancelGuestReservation extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $reservation = Reservation::onlyTrashed()->where('status', 0)->latest()->get();
        return \datatables()->of($reservation)
                ->addColumn('detail', function($reservation){
                    $btn = '<a href="reservation/detailCancelReservation/'.$reservation->id.'" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['detail'])
                ->make(true);
    }
}
