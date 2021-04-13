<?php

namespace App\Http\Controllers\Reception\bill;

use App\GuestBill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
|   Controller ini untuk masterbill tamu 
|--------------------------------------------------------------------------
|   master bill meliputi
|   minibar, laundry, telephone voucher, miscellaneous, coffe shop, room reservice
*/

class GuestBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temporaryBills = DB::table('temporary_bills')->where('registration_id', $request->registration_id)
            ->first();
        // jika temporary bill belum dibuat, maka belum bisa post bill tamu
        if ($request->description > 0 && !empty($temporaryBills)) {
            foreach($request->description as $key => $v){
                $data = [
                    'room_id' => $request->rooms[$key],
                    'date' => $request->date[$key],
                    'description' => $request->description[$key],
                    'amount' => $request->amount[$key]
                ];
                $guestBill = GuestBill::create($data);
                DB::table('temporary_bills')->insert([
                    'registration_id' => $request->registration_id,
                    'date' => $request->date[$key],
                    'description' => $request->description[$key],
                    'amount' => $request->amount[$key],
                    'typeBill' => 'otherCash',
                    'idGuestBill' => $guestBill->id
                ]);
            }
        } else {
            return \redirect()->back()->with('alert', 'The master bill has not been created');
        }

        return \redirect()->back()->with('alert', 'Success!!! The post has been created');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = GuestBill::find($id);
        DB::table('temporary_bills')->where('idGuestBill', $bill->id)->delete();
        $bill->delete();
        return response()->json(['sukses' => true]);
    }
}
