<?php

namespace App\Http\Controllers\Reception\bill;

use App\DetailMasterBill;
use App\DetailMasterBillIndividual;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reception\CashierController;
use App\MasterBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterBillController extends Controller
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
        // \dd($request->all());
        $dataMasterBill = $request->only('registration_id', 'methodPayment', 'numberAccount', 'expDate', 'typeCharge', 'chargeTo') ;

        $master = MasterBill::updateOrCreate([
            'methodPayment' => $request->methodPayment,
            'chargeTo' => $request->chargeTo
        ],$dataMasterBill);
        if ($request->checkBill > 0) {
            $temporaryBills = DB::table('temporary_bills')->whereIn('id', $request->checkBill)
            ->get();
            foreach($temporaryBills as $v){
                $dataTemporar = [
                    'masterBill_id' => $master->id,
                    'description' => $v->description,
                    'date' => $v->date,
                    'charge' => $v->amount,
                    'idTemporary' => $v->id
                ];
                DetailMasterBill::insert($dataTemporar);
            }
            $temporaryBills = DB::table('temporary_bills')->whereIn('id', $request->checkBill)
            ->update([
                'chargeTo' => $request->chargeTo,
                'status' => 1
            ]);
        }

        return \redirect()->back()->with('alert', 'The master bill payment has been made');
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
        //
    }

    public function deleteMasterBill($id)
    {
        $detMasterBill = DetailMasterBill::find($id);
        $detMasterBill->delete();
        DB::table('temporary_bills')->where('id', $detMasterBill->idTemporary)
            ->update([
                'chargeTo' => '',
                'status' => 0
            ]);
        return \redirect()->back()->with('alert', 'Deleted success');
    }

    public function deleteMasterBillPerRoom($id)
    {
        $masterBill = MasterBill::find($id);
        foreach($masterBill->detailMasterBills as $v){
            $idDetailMBill[] = $v->idTemporary;
        }
        DB::table('temporary_bills')->whereIn('id', $idDetailMBill)
        ->update([
            'chargeTo' => '',
            'status' => 0
        ]);
        $masterBill->delete();
        return \response()->json(['sukses' => true]);
    }

    public function printVoucher($id)
    {
        $masterBill = MasterBill::find($id);
        return view('frontOffice.reception.cashier.guestBill.voucherBill.voucherBill', \compact('masterBill'));
    }
}
