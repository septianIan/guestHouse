<div class="row">
   @foreach($registrationCheckOut->registration->masterBills as $masterBill)
   <div class="col-sm-6">
      <div class="card card-success">
         <div class="card-header">
            <h3 class="card-title">Master bill</h3>
         </div>
         <div class="card-body">
            <div class="col-sm-6 invoice-col">
               <p>
                  Method Payment : {{ $masterBill->methodPayment }} <br>
                  Number account : {{ $masterBill->numberAccount }} <br>
                  Exp date : {{ $masterBill->expDate }} <br>
                  Type charge : {{ $masterBill->typeCharge }} <br>
                  Charge to : {{ $masterBill->chargeTo }} <br>
               </p>
            </div>
            <button class="btn btn-primary btn-flat float-right mb-2"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
            <table class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Date</th>
                     <th>Description</th>
                     <th>Charge</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($masterBill->detailMasterBills as $detailMasterBill)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detailMasterBill->date }}</td>
                        <td>
                           {{ $detailMasterBill->description }}
                        </td>
                        <td>Rp. {{ number_format($detailMasterBill->charge, 0, ',', '.') }}</td>
                     </tr>
                  @endforeach
                     <tr>
                        <td colspan="3"><center><b>Total</b></center></td>
                        <td>Rp. {{ number_format($masterBill->detailMasterBills->sum('charge'), 0, ',', '.') }}</td>
                     </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endforeach
</div>