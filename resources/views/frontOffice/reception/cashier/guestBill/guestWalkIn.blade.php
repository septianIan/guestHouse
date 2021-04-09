<form action="{{ route('reception.master-bill.store') }}" method="post">
<input type="hidden" name="registration_id" value="{{ $registration->id }}">
@csrf
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
                        <th colspan="6">Charges/Debit</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($allIndividualGuestBills as $individualBill)
                        <tr>
                           <td>
                              <b>#{{ $loop->iteration }}</b>
                              @if($individualBill->status == 1)
                                 <font><b>Charge to </b>{{ $individualBill->chargeTo }}</font>
                              @else
                                 <input type="checkbox" class="{{ $individualBill->typeBill }}" value="{{ $individualBill->id }}" name="checkBill[]">
                              @endif
                           </td>
                           <td>
                              {{ $individualBill->date }}
                           </td>
                           <td>
                              @if($individualBill->typeBill == 'rooms' OR $individualBill->typeBill == 'extraBed')
                                 <font>{{ $individualBill->description }} <i class="fa fa-check"></i></font>
                              @elseif($individualBill->typeBill == 'meals')
                                 <font>{{ $individualBill->description }} <i class="fas fa-utensils"></i></font>
                              @elseif($individualBill->typeBill == 'diffDateInCO')
                                 <font style="color:red;">{{ $individualBill->description }} <i class="fa fa-check"></i></font>
                              @elseif($individualBill->typeBill == 'roomSurcharge')
                                 <font>{{ $individualBill->description }} <i class="fa fa-check"></i></font>
                              @else
                                 {{ $individualBill->description }} @if($individualBill->status == 0)<a href="#" class="btn btn-danger btn-xs deletePostCash" data-id="{{ $individualBill->idGuestBill }}"><i class="fa fa-trash" aria-hidden="true"></i></a>@endif
                              @endif

                           </td>
                           <td colspan="6">
                              Rp. {{ number_format($individualBill->amount, 0, ',', '.') }}
                           </td>
                        </tr>
                     @empty
                        <tr>
                           <td colspan="6"><center><a href="#" class="btn btn-primary" id="saveAllBills" data-id="{{ $registration->id }}"><i class="fa fa-list" aria-hidden="true"></i> Create master bill</a></center></td>
                        </tr>
                     @endforelse
                     <tr  style="background:#FAD507;">
                        <td> - </td>
                        <td> - </td>
                        <td> Total </td>
                        <td colspan="6">Rp. {{ number_format($allBill, 0, ',', '.') }} </td>
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
                              <select name="typeCharge" id="typeCharge" class="form-control">
                                 <option value=""></option>
                                 <option value="P/A">P/A</option>
                                 <option value="P/A ALL">P/A ALL</option>
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
            <a href="{{ route('reception.masterBill.voucher', $masterBill->id) }}" class="btn btn-primary btn-flat float-right mb-2" target="_blank"><i class="fa fa-print"></i> Print</a>
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