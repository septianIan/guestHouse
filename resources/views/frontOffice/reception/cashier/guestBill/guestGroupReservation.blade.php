<form action="{{ route('reception.master-bill.store') }}" method="post">
@csrf
<input type="hidden" name="registration_id" value="{{ $registration->id }}">
<div class="row">
   <div class="col-lg-12">
      <div class="invoice p-3 mb-3">
         <div class="row">
            <div class="col-12">
               <h3>
                  <i class="fa fa-info-circle"></i>
                  &nbsp;Guest Bill
               </h3>
               <a href="#" class="mb-2 btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-postCharge"><i class="fa fa-plus px-1"></i>Post bill voucher</a>

               <a href="#" class="mb-2 btn btn-danger btn-xs float-right resetBill" data-id="{{ $registration->id }}"><i class="fas fa-sync-alt"></i> Reset Bill</a>
            </div>
         </div>
         <div class="row invoice-info">
            <div class="col-sm-12 invoice-col">
               <table class="table table-striped" style="font-size:14px;">
                  <thead>
                     <tr>
                        <th>Check</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Charges/Debit</th>
                        <th>Credit</th>
                        <th>Belance</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td></td>
                        <td>{{ $registration->arrivaleDate }}</td>
                        <td>Cash</td>
                        <td> - </td>
                        <td>Rp. 
                           {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}
                        </td>
                        <td>Rp. 
                           {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}
                        </td>
                     </tr>
                     @forelse($allGroupGuestBills as $groupBill)
                        <tr>
                           <td>
                              <b>#{{ $loop->iteration }}</b>
                              @if($groupBill->status == 1)
                                 <font><b>Charge to </b>{{ $groupBill->chargeTo }}</font>
                              @else
                                 <input type="checkbox" class="{{ $groupBill->typeBill }}" value="{{ $groupBill->id }}" name="checkBill[]">
                              @endif
                           </td>
                           <td>
                              {{ $groupBill->date }}
                           </td>
                           <td>
                              @if($groupBill->typeBill == 'rooms' OR $groupBill->typeBill == 'extraBed')
                                 <font>{{ $groupBill->description }} <i class="fa fa-check"></i></font>
                              @elseif($groupBill->typeBill == 'meals')
                                 <font>{{ $groupBill->description }} <i class="fas fa-utensils"></i></font>
                              @elseif($groupBill->typeBill == 'diffDateInCO')
                                 <font style="color:red;">{{ $groupBill->description }}</font>
                              @else
                                 {{ $groupBill->description }} @if($groupBill->status == 0)<a href="#" class="btn btn-danger btn-xs deletePostCash" data-id="{{ $groupBill->idGuestBill }}"><i class="fa fa-trash" aria-hidden="true"></i></a>@endif
                              @endif

                           </td>
                           <td>
                              Rp. {{ number_format($groupBill->amount, 0, ',', '.') }}
                           </td>
                           <td> - </td>
                           <td>
                              Rp. {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit-=$groupBill->amount, 0, ',', '.') }}
                           </td>
                        </tr>
                     @empty
                        <tr>
                           <td></td>
                           <td></td>
                           <td><center><a href="#" class="btn btn-primary" id="saveAllBills" data-id="{{ $registration->id }}"><i class="fa fa-list" aria-hidden="true"></i> Create master bill</a></center></td>
                           <td></td>
                        </tr>
                     @endforelse
                        <tr style="background:#8A89EB;">
                           <td></td>
                           <td>{{ $registration->departureDate }}</td>
                           <td><b>{{ $totalCash }}</b></td>
                           <td> - </td>
                           <td>Rp. {{ number_format($refund, 0, ',', '.') }} </td>
                           <td>0</td>
                        </tr>
                        <tr  style="background:#FAD507;">
                           <td> - </td>
                           <td> - </td>
                           <td> Total </td>
                           <td>Rp. {{ number_format($allBill, 0, ',', '.') }} </td>
                           <td> - </td>
                           <td> - </td>
                        </tr>
                  </tbody>
                  <tfoot style="background:#ccc;">
                     <tr>
                        <th>Method payemnt</th>
                        <th>Number account</th>
                        <th>Exp date</th>
                        <th>Type charge</th>
                        <th>Charge to</th>
                        <th colspan="2">Action</th>
                     </tr>
                     <tr>
                        <td>
                           <select name="methodPayment" class="form-control" id="" required>
                              <option value=""></option>
                              <option value="cash">Cash</option>
                              <option value="credit card">Credit card</option>
                              <option value="debit">debit</option>
                              <option value="payLetter">Pasca payment</option>
                           </select>
                        </td>
                        <td>
                           <input type="number" name="numberAccount" class="form-control" placeholder="Number account..." id="">
                        </td>
                        <td>
                           <input type="date" name="expDate" class="form-control" placeholder="Exp date..." id="">
                        </td>
                        <td>
                           <select name="typeCharge" id="typeCharge" class="form-control" required>
                              <option value=""></option>
                              <option value="P/A">P/A</option>
                              <option value="P/A ALL">P/A ALL</option>
                              <option value="C/A ">C/A</option>
                              <option value="C/A ALL">C/A ALL</option>
                              <option value="C/A RO">C/A RO</option>
                              <option value="C/A RO+BF">C/A RO+BF</option>
                           </select>
                        </td>
                        <td>
                           <select name="chargeTo" class="form-control" id="">
                              <option value=""></option>
                              @foreach($registration->rooms as $room)
                                 <option value="{{ $room->numberRoom }}">{{ $room->numberRoom }}</option>
                              @endforeach
                           </select>
                        </td>
                        <td colspan="2">
                           <button class="btn btn-warning">Pay</button>
                        </td>
                     </tr>
                  </tfoot>
               </table>
               <a href="#" class="btn btn-success btn-flat float-right checkOut" data-id="{{ $registration->id }}" id="checkOut">Check Out</a>   
            </div>
         </div>
      </div>
   </div>
</div>
</form>

{{-- MASTER BILL --}}
@if(!empty($registration->masterBills))
   <div class="row">
      @foreach($registration->masterBills as $masterBill)
      <div class="col-sm-6">
         <div class="card card-success">
            <div class="card-header">
               <h3 class="card-title">Master bill</h3>
               <a href="#" class="btn btn-flat btn-danger btn-sm float-right deleteAllMasterBill" data-id="{{ $masterBill->id }}"><i class="fa fa-window-close" aria-hidden="true"></i></a>
            </div>
            <div class="card-body" style="overflow-y: auto;height:600px;">
               <div class="col-sm-6 invoice-col">
                  <p>
                     Method Payment : {{ $masterBill->methodPayment }} <br>
                     Number account : {{ $masterBill->numberAccount }} <br>
                     Exp date : {{ $masterBill->expDate }} <br>
                     Type charge : {{ $masterBill->typeCharge }} <br>
                     Charge to : {{ $masterBill->chargeTo }} <br>
                  </p>
               </div>
               <button class="btn btn-primary btn-flat btn-sm float-right mb-2"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
               <table class="table table-bordered table-striped" style="font-size:14px;">
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
                              <a href="#" class="btn btn-danger btn-xs deleteMasterBill" data-id="{{ $detailMasterBill->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
@endif
