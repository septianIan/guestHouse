<?php

namespace App\Http\Controllers\Reception\vouchers;

use App\Http\Controllers\Controller;
use App\MiscellaneousVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiscellaneousVoucherController extends Controller
{
    public function store(Request $request)
    {
        // \dd($request->all());
        if (\count(array($request->descriptions)) > 0) {
            foreach ($request->descriptions as $description => $v){
                $data = [
                    'registration_id' => $request->registration_id,
                    'room_id' => $request->room_id,
                    'date' => $request->date,
                    'descriptions' => $request->descriptions[$description],
                    'amount' => $request->amount[$description],
                ];
                DB::table('miscellaneous_vouchers')->insert($data);
            }
        }
        return \redirect()->back();
    }

    public function edit($id)
    {
        return \response()->json([
            'data' => MiscellaneousVoucher::findOrFail($id)
        ]);
    }

    public function update(Request $request)
    {
        $dataMiscellaneous = MiscellaneousVoucher::where('id', $request->id)->first();
        $dataMiscellaneous->update([
            'room_id' => $request->room_id,
            'date' => $request->date,
            'descriptions' => $request->descriptions,
            'amount' => $request->amount,
        ]);

        return \redirect()->back();
    }

    public function destroy($id)
    {
        $data = MiscellaneousVoucher::findOrFail($id);
        $data->delete();
        return \redirect()->back();
    }
}
