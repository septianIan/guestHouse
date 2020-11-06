<?php

namespace App\Http\Controllers\Reception\DataTable;

use App\Http\Controllers\Controller;
use App\Registration;
use Illuminate\Http\Request;

class DataTableRegistration extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $registration = Registration::with('rooms')->latest()->get();
        return \datatables()->of($registration)
            ->addColumn('action', 'frontOffice.template.components.action.DT-action-registration')
            ->addColumn('status', function(Registration $registration){
                if ($registration->status == 'checkIn') {
                    $data = '<font style="color:blue;font-weight:bold;">'.'Check In'.'</font>';
                } else {
                    $data = '<font style="color:red;font-weight:bold;">'.'Not checked in yet'.'</font>';
                }
                return $data;
            })
            ->addColumn('guestName', function(Registration $registration){
                return $registration->getGuestName();
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'action'])
            ->toJson();

    }
}
