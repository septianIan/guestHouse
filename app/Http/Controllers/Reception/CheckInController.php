<?php

namespace App\Http\Controllers\Reception;

use App\CheckIn;
use App\Http\Controllers\Controller;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\Room;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;

class CheckInController extends Controller
{
    public function index()
    {
        return view('frontOffice.reception.individualCheckIn.index');
    }

    public function dataTableIndividualReservation()
    {
        $reservations = Reservation::where('status', 'confirm')->latest()->get();
        return datatables()->of($reservations)
            ->addColumn('action', function ($reservation) {
                $btn = '<a href="/reception/detailIndividualCheckIn/' . $reservation->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function detailIndividualReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        //code mengambil selisih antara checkin dan checkout
        $checkIn = new Carbon($reservation->arrivaleDate);
        $checkOut = $reservation->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $rooms = Room::get();
        return view('frontOffice.reception.individualCheckIn.detailIndividualReservation', \compact('reservation', 'rooms', 'difference'));
    }

    public function checkIn($id)
    {
        $check = Registration::where('id', $id)->first();
        if ($check->status == 'checkIn') {
            $success = true;
            $message = 'Guest has checked in';
        } else {
            $regis = Registration::find($id);
            $regis->update(['status' => 'checkIn']);
            foreach ($regis->rooms as $walkInOrservation) {
                $walkIn = $walkInOrservation->pivot->walkInOrReservation;
            }
            if ($walkIn == 'walkIn') {
                CheckIn::create([
                    'registration_id' => $id,
                    'date' => Carbon::now()->isoFormat('D-M-Y'),
                ]);
            } else {
                $reservation = ReservationCheckInDetail::where('registration_id', $id)->first();
                $reservation->reservation->update(['status' => 'checkIn']);
                $regis->update(['status' => 'checkIn']);
                CheckIn::create([
                    'registration_id' => $id,
                    'date' => Carbon::now()->isoFormat('D-M-Y'),
                ]);
            }
            $success = false;
            $message = 'Check in is saved';
        }

        return \response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


    /**
     * 
     * GROUP FUNCTION
     */
    public function indexGroup()
    {
        return view('frontOffice.reception.groupCheckIn.index');
    }
}
