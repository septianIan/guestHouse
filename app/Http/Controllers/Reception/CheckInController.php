<?php

namespace App\Http\Controllers\Reception;

use App\CheckIn;
use App\Http\Controllers\Controller;
use App\IndividualReservationRoom;
use App\Meal;
use App\Registration;
use App\Reservation;
use App\ReservationCheckInDetail;
use App\ReservationGroup;
use App\ReservationGroupCheckInDetail;
use App\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class CheckInController extends Controller
{
    /**
     * 
     * Individual Reservation
     */
    public function index()
    {
        return view('frontOffice.reception.individualCheckIn.index');
    }

    public function dataTableIndividualReservation()
    {
        $individualReservation = Reservation::where('status', 'confirm')->latest()->get();
        return datatables()->of($individualReservation)
            ->addColumn('action', function ($individualReservation) {
                $btn = '<a href="/reception/detailIndividualCheckIn/' . $individualReservation->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
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

        $individialReservationRoomWhereNotExtraBad = IndividualReservationRoom::select('id', 'typeOfRoom', 'totalRoomReserved', 'roomRate')->where('reservation_id', $id)->whereNotIn('typeOfRoom', ['extraBad'])->get();

        $extraBad = DB::table('individual_reservation_rooms')
                ->where('typeOfRoom', '=', 'extraBad')
                ->where('reservation_id', '=' ,$id)
                ->first();
        

        return view('frontOffice.reception.individualCheckIn.detailIndividualReservation', \compact('reservation', 'rooms', 'difference', 'individialReservationRoomWhereNotExtraBad', 'extraBad'));
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


            /**
             * jika checkIn tamu By reservation
             */
            //cek reservation individual
            $reservation = ReservationCheckInDetail::where('registration_id', $id)->first();
            // cek group individual
            $groupReservation = ReservationGroupCheckInDetail::where('registration_id', $id)->first();

            if ($reservation != '') {
                $reservation->reservation->update(['status' => 'checkIn']);
                //update status individual_reservation_rooms
                DB::table('individual_reservation_rooms')->whereIn('reservation_id', [$reservation->reservation_id])
                ->update(['status' => 2]);
            } elseif ($groupReservation != ''){
                $groupReservation->reservationGroup->update(['status' => 'checkIn']);
                DB::table('group_reservation_rooms')->whereIn(
                    'reservationgroup_id', [$groupReservation->reservationgroup_id]
                )->update(['status' => 2]);
            } else {
                $success = false;
                $message = 'Error! reservation individual or group not found!!!';
            }

            CheckIn::create([
                'registration_id' => $id,
                'date' => Carbon::now()->isoFormat('D-M-Y'),
            ]);

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

    public function dataTableGroupReservation()
    {
        $GroupReservation = ReservationGroup::where('status', 'confirm')->latest()->get();
        return datatables()->of($GroupReservation)
            ->addColumn('action', function ($GroupReservation) {
                $btn = '<a href="/reception/detailGroupCheckIn/' . $GroupReservation->id . '" class="btn btn-warning"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function detailGroupReservation($id)
    {
        $reservationGroup = ReservationGroup::findOrfail($id);
        $checkIn = new Carbon($reservationGroup->arrivaleDate);
        $checkOut = $reservationGroup->departureDate;
        $difference = ($checkIn->diff($checkOut)->days < -1)
            ? 'today'
            : $checkIn->diffInDays($checkOut);
        $rooms = Room::get();
        return \view('frontOffice.reception.groupCheckIn.detailGroupReservation', [
            'groupReservation' => $reservationGroup,
            'difference' => $difference,
            'rooms' => $rooms,
            'meals' => Meal::get()
        ]);
    }
}
