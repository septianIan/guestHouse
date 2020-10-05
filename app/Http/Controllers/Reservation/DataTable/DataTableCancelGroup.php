<?php

namespace App\Http\Controllers\Reservation\DataTable;

use App\Http\Controllers\Controller;
use App\ReservationGroup;

class DataTableCancelGroup extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $reservationGroup = ReservationGroup::onlyTrashed()->latest()->get();
        return \datatables()->of($reservationGroup)
                            ->addColumn('detail', function($reservationGroup){
                                $btn = '<a href="reservation/detailCancelReservationGroup/'.$reservationGroup->id.'" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                                return $btn;
                            })
                            ->addIndexColumn()
                            ->rawColumns(['detail'])
                            ->rawColumns(['detail'])
                            ->make(true);
    }
}
