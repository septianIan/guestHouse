<?php

namespace App\Http\Controllers\Reception\vouchers;

use App\Http\Controllers\Controller;
use App\TelephoneVoucher;
use Illuminate\Http\Request;

class TelephoneVoucherController extends Controller
{
    public function store(Request $request)
    {
        TelephoneVoucher::create($request->except('_token'));
        return redirect()->back();
    }

    public function edit($id)
    {
        return \response()->json([
            'data' => TelephoneVoucher::findOrFail($id)
        ]);
    }

    public function update(Request $request)
    {
        // \dd($request->all());
        $telephoneVoucher = TelephoneVoucher::where('id', $request->id)->first();
        $telephoneVoucher->update([
            'registration_id' => $telephoneVoucher->registration_id,
            'room_id' => $request->room_id,
            'date' => $request->date,
            'noCalled' => $request->noCalled,
            'city' => $request->city,
            'country' => $request->country,
            'time' => $request->time,
            'connected' => $request->connected,
            'disconected' => $request->disconected,
            'minutes' => $request->minutes,
            'amount' => $request->amount
        ]);

        return \redirect()->back();
    }

    public function destroy($id)
    {
        $telephoneVoucher = TelephoneVoucher::findOrFail($id);
        $telephoneVoucher->delete();

        return \redirect()->back();
    }
}
