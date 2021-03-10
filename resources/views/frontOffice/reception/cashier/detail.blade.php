@extends('frontOffice.template.ui')
@section('title', 'Detail Guest Check In')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reception.cashier.index') }}">Data Guest Check In</a></li>
   <li class="breadcrumb-item active">Detail Guest Check In</li>
</ol>
@endsection

@section('content')
   <div class="container">
      {{-- Detail Guest Registration --}}
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Registration
                     </h3>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Name guest : {{ $registration->getGuestName() }}<br>
                        Nationality : {{ $registration->nationality }}<br>
                        Passport : {{ $registration->passport }}<br>
                        Occupation : {{ $registration->occupation }}<br>
                        Date birth : {{ $registration->dateBirth }}
                     </p>
                  </div>
                  <div class="col-sm-4 invoice-col">
                     <p>
                        Home address : {{ $registration->homeAddress }}<br>
                        Company : {{ $registration->company }}<br>
                        Purpose : {{ $registration->purpose }}<br>
                        Arrivale date : {{ $registration->arrivaleDate }}<br>
                        Departure Date : {{ $registration->departureDate }}
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Coming from : {{ $registration->comingFrom }} <br>
                        Next destination : {{ $registration->nextDestination }}<br>
                        Term of payment : {{ $registration->termOfPayment }}<br>
                        Number account : {{ $registration->numberAccount }}<br>
                        Exp date : {{ $registration->expDate }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- Detial guest Reservation --}}
      @if(isset($guestIndividaulReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Guest <b>Individual</b> Reservation
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <address>
                        <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $guestIndividaulReservation->reservation->guestName }} </font></strong><br>
                        Address : {{ $guestIndividaulReservation->reservation->address }}<br>
                        Contact Person : {{ $guestIndividaulReservation->reservation->contactPerson }}<br>
                        Name Person : {{ $guestIndividaulReservation->reservation->namePerson }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Date Reservation : </b>{{ $guestIndividaulReservation->reservation->created_at }}
                     <address>
                        Arrivale Date : {{ $guestIndividaulReservation->reservation->arrivaleDate }}<br>
                        Departure Date : {{ $guestIndividaulReservation->reservation->departureDate }}<br>
                        Estimate Arrival Check in : {{ $guestIndividaulReservation->reservation->estimateArrivale }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Payment</b>
                     <address>
                        Method Payment : {{ $guestIndividaulReservation->reservation->methodPayment }}<br>
                        Deposit : {{ number_format($guestIndividaulReservation->reservation->deposit, 0, ',', '.') }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Order room by reservation</b>
                     <address>
                        @foreach($guestIndividaulReservation->reservation->individualReservationRooms as $value)
                        <address>
                           Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                           <b>{{ $value->typeOfRoom }}</b>
                        </address>
                        @endforeach
                        Stay : {{ $difference }} night
                     </address>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @elseif(isset($guestGroupReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Guest <b>Group</b> Reservation
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <address>
                        <strong>Group Name :&nbsp;<font style="font-style:italic;">{{ $guestGroupReservation->reservationGroup->groupName }} </font></strong><br>
                        Address : {{ $guestGroupReservation->reservationGroup->addressPerson }}<br>
                        Contact Person : {{ $guestGroupReservation->reservationGroup->contactPerson }}
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Date Reservation : </b>{{ $guestGroupReservation->reservationGroup->created_at }}
                     <address>
                        Arrivale Date : {{ $guestGroupReservation->reservationGroup->arrivaleDate }}<br>
                        Departure Date : {{ $guestGroupReservation->reservationGroup->departureDate }}<br>
                        Estimate Arrival Check in : {{ $guestGroupReservation->reservationGroup->estimateArrivale }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Method Payment :&nbsp; <font style="font-style:italic;">{{ $guestGroupReservation->reservationGroup->methodPayment->methodPayment }}</font></b>
                     @if($guestGroupReservation->reservationGroup->methodPayment->methodPayment == 'personal')
                     <p>
                        Cast deposit : {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                        Credit card : {{ $guestGroupReservation->reservationGroup->methodPayment->value1 }}<br>
                        Number account : {{ $guestGroupReservation->reservationGroup->methodPayment->value2 }}<br>
                        Other : {{ $guestGroupReservation->reservationGroup->methodPayment->value3 }}<br>
                     </p>
                     @else
                     <p>
                        Deposit : {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                        Credit card : {{ $guestGroupReservation->reservationGroup->methodPayment->value1 }}<br>
                        Travel agent : {{ $guestGroupReservation->reservationGroup->methodPayment->value2 }}<br>
                        Other : {{ $guestGroupReservation->reservationGroup->methodPayment->value3 }}<br>
                     </p>
                     @endif
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Order room by reservation</b>
                     <address>
                        @foreach($guestGroupReservation->reservationGroup->groupReservationRooms as $value)
                        <address>
                           Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                           <b>{{ $value->typeOfRoom }}</b>
                        </address>
                        @endforeach
                        Stay : {{ $difference }} night
                     </address>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif

      {{-- GUEST BILL --}}
      @if(isset($guestIndividaulReservation))
         @include('frontOffice.reception.cashier.guestBill.guestIndividualReservation')
      @elseif(isset($guestGroupReservation))
         @include('frontOffice.reception.cashier.guestBill.guestGroupReservation')
      @endif

      {{-- DETAILS BILL --}}
      <div class="row">
         {{-- Bill Telephone --}}
         <div class="col-sm-6">
            <div class="card card-primary">
               <div class="card-header">
                  <h2 class="card-title">
                     Bill telephone
                  </h2>
               </div>
               <div class="card-body" style="font-size:14px;overflow-y: auto;height:330px;">
                  @forelse($billTelephone as $v)
                     <div class="row">
                        <div class="col-sm-7">
                           <div class="form-group">
                           <label>Guest name</label>
                           {{ $v->registration->getGuestName() }}
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <div class="form-group">
                           <label>Room</label>
                           {{ $v->room->numberRoom }}
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                           <label>Date</label>
                           {{ $v->date }}
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                           <label>No. Called</label>
                           {{ $v->noCalled }}
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>City</label>
                           {{ $v->city }}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Country</label>
                           {{ $v->country }}
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Time</label>
                           {{ $v->time }}
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Connected</label>
                           {{ $v->connected }}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Disconected</label>
                           {{ $v->disconected }}
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Minutes</label>
                           {{ $v->minutes }}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                           <label>Amount Rp</label>
                           Rp. {{ number_format($v->amount, 0, ',', '.') }}
                           </div>
                        </div>
                     </div>
                     
                     <div class="row">
                        <a href="#" id="editTelephoneVoucher" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalEditTelpVoucher" data-id="{{ $v->id }}">Edit</a>

                        <form action="{{ route('reception.billtelephone.destroy', $v->id) }}" method="post">
                        @csrf
                        @method('delete')
                           <button type="submit" class="btn btn-danger btn-xs ml-2" onclick="return confirm('Are you sure for deleting?')">Delete</button>
                        </form>
                     </div>
                     <hr>
                  @empty
                     <center>Bill has <b>not been created</b></center>
                  @endforelse
               </div>
            </div>
         </div>

         {{-- Bill Miscellaneous --}}
         <div class="col-sm-6">
            <div class="card card-warning">
               <div class="card-header">
                  <h2 class="card-title">
                     Bill miscellaneous
                  </h2>
               </div>
               <div class="card-body"  style="font-size:14px;overflow-y: auto;height:330px;">
                  <table class="table table-bordered table-striped" style="font-size:14px;">
                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Room</th>
                           <th>Discription</th>
                           <th>Amount</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($billMiscellaneous as $v)
                           <tr>
                              <td>{{ $v->date }}</td>
                              <td>{{ $v->room->numberRoom }}</td>
                              <td>{{ $v->descriptions }}</td>
                              <td>Rp. {{ number_format($v->amount, 0, ',', '.') }}</td>
                              <td>
                                 <div class="btn-group align-middle py-0">
                                    <a href="#" id="editMiscellaneousVoucher" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalEditMiscellaneousVoucher" data-id="{{ $v->id }}">Edit</a>
                                    <form action="{{ route('reception.billMiscellaneous.destroy', $v->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                       <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure for deleting?')">Delete</button>
                                    </form>   
                                 </div>
                              </td>
                           </tr>
                        @empty
                           <tr>
                              <td colspan="5"><center>Bill has <b>not been created</b></center></td>
                           </tr>
                        @endforelse
                           <tr>
                              <td colspan="3"><center><b>Total</b></center></td>
                              <td colspan="3">Rp. {{ number_format($totalMiscellaneous, 0, ',', '.') }}</td>
                           </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

      </div>

      <div class="row">

         {{-- Bill Mini bar --}}
         <div class="col-sm-6">
            <div class="card card-success">
               <div class="card-header">
                  <h2 class="card-title">
                     Mini bar
                  </h2>
               </div>
               <div class="card-body"  style="font-size:14px;overflow-y: auto;height:330px;">
                  <div class="row">
                     <div class="col-sm-7">
                        <div class="form-group">
                        <label>Guest name</label>
                        : {{ $registration->getGuestName() }}
                        </div>
                     </div>
                  </div>
                  <table class="table table-bordered table-striped" style="font-size:12px;">
                     <thead>
                        <tr>
                           <th>Room</th>
                           <th>Date</th>
                           <th>Product name</th>
                           <th>Quantity</th>
                           <th>Price</th>
                           <th>Amount</th>
                        </tr>
                     </thead>
                     @forelse($billMinibar as $miniBar)
                        @foreach($miniBar->orderrdetails as $orderDetail)
                        <tbody>
                           <tr>    
                              <td>{{ $miniBar->room->numberRoom }}</td>
                              <td>{{ $orderDetail->orderr->date }}</td>  
                              <td>{{ $orderDetail->product->name }}</td>
                              <td>{{ $orderDetail->quantity }}</td>
                              <td>Rp. {{ number_format($orderDetail->product->price, 0, ',', '.') }}</td>
                              <td>Rp. {{ number_format($orderDetail->amount, 0, ',', '.') }}</td>
                           </tr>
                        </tbody>
                        @endforeach
                     @empty
                     <tr>
                        <td colspan="6"><center>Bill has <b>not been created</b></center></td>
                     </tr>
                     @endforelse
                     <tfoot>
                        <tr>
                           <td colspan="5"><center><b>Total</b></center></td>
                           <td>Rp. {{ number_format($totalCashMinibar, 0, ',', '.') }}</td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>

         {{-- Cash receipt/deposit voucher For GUEST RESERVATION--}}
         <div class="col-sm-6">
            <div class="card card-outline card-default">
               <div class="card-header">
                  <h2 class="card-title">
                     Cash receipt
                  </h2>
               </div>
               <div class="card-body"  style="font-size:14px;overflow-y: auto;height:330px;">
                  <div class="row">
                     <div class="col-sm-12">
                        <label for="">Date</label>
                        @if(isset($guestIndividaulReservation))
                           {{ $guestIndividaulReservation->reservation->created_at }}
                        @elseif(isset($guestGroupReservation))
                           {{ $guestGroupReservation->reservationGroup->created_at }}
                        @endif
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <label for="">Recevied from</label>
                        @if(isset($guestIndividaulReservation))
                           {{ $guestIndividaulReservation->reservation->guestName }}
                        @elseif(isset($guestGroupReservation))
                           {{ $guestGroupReservation->reservationGroup->contactPerson }}
                        @endif
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <label for="">Amount deposit</label>
                        Rp. 
                        @if(isset($guestIndividaulReservation))
                           {{ number_format($guestIndividaulReservation->reservation->deposit, 0, ',', '.') }}
                        @elseif(isset($guestGroupReservation))
                           {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}
                        @endif
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <label for="">Type of payment</label>
                        :  @if(isset($guestIndividualReservation))
                           {{ $guestIndividaulReservation->reservation->methodPayment }}
                           @elseif($guestGroupReservation)
                           {{ $guestGroupReservation->reservationGroup->methodPayment->methodPayment }}
                           @endif
                     </div>
                     <div class="col-sm-4">
                        <label for="">Cheque</label>
                        :
                     </div>
                     <div class="col-sm-4">
                        <label for="">Others</label>
                        :
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>

      <div class="row">
         {{-- Drycleaning --}}
         <div class="col-sm-6">
            <div class="card card-success">
               <div class="card-header"  style="background:#F30086;">
                  <h2 class="card-title">
                     Drycleaning
                  </h2>
               </div>
               <div class="card-body"  style="font-size:14px;overflow-y: auto;height:330px;">
                  <div class="row">
                     <div class="col-sm-7">
                        <div class="form-group">
                        <label>Guest name</label>
                        : {{ $registration->getGuestName() }}
                        </div>
                     </div>
                  </div>
                  <table class="table table-bordered table-striped" style="font-size:14px;">
                     <thead>
                        <tr>
                           <th>Room</th>
                           <th>Date</th>
                           <th>Package</th>
                           <th>Quantity</th>
                           <th>Price</th>
                           <th>Amount</th>
                        </tr>
                     </thead>
                     @forelse($billLaundry as $drycleaning)
                     <tbody>
                        @foreach($drycleaning->drycleaning_details as $drycleaningDetail)
                           <tr>
                              <td>{{ $drycleaning->room->numberRoom }}</td>
                              <td>{{ $drycleaningDetail->drycleanings->date }}</td>
                              <td>{{ $drycleaningDetail->package->name }}</td>
                              <td>{{ $drycleaningDetail->quantity }}</td>
                              <td>Rp. {{ number_format($drycleaningDetail->package->price, 0, ',', '.') }}</td>
                              <td>Rp. {{ number_format($drycleaningDetail->amount, 0, ',', '.') }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                     @empty
                        <tr>
                           <td colspan="6"><center>Bill has <b>not been created</b></center></td>
                        </tr>
                     @endforelse
                     <tfoot>
                        <tr>
                           <td colspan="5"><center><b>Total</b></center></td>
                           <td>Rp. {{ number_format($totalDrycleaning, 0, ',', '.') }}</td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>

         {{-- Paid out voucher --}}
         <div class="col-sm-6">
            <div class="card card-danger">
               <div class="card-header">
                  <h2 class="card-title">
                     Paid out voucher
                  </h2>
               </div>
               <div class="card-body"  style="font-size:14px;overflow-y: auto;height:330px;">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th>Description</th>
                           <th>Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($billPaidOut as $paidOut)
                           <tr>
                              <td>{{ $paidOut->descriptions }}</td>
                              <td>{{ $paidOut->amount }}</td>
                           </tr>
                        @empty
                           <tr>
                              <td colspan="2"><center>Bill has <b>not been created</b></center></td>
                           </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

      </div>
      {{-- Batas DETAILS BILL --}}

      {{-- GUEST BILL OLD --}}
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail room bill
                     </h3>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-12 invoice-col">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>No room</th>
                              <th>Total pax</th>
                              <th>Type of registration</th>
                              <th>Walk in or reservation</th>
                              <th>Room rate</th>
                              <th>Stay</th>
                              <th>Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($registration->rooms as $room)
                           <tr>
                              <td>{{ $room->numberRoom }}</td>
                              <td>{{ $room->pivot->totalPax }}</td>
                              <td>{{ $room->pivot->typeOfRegistration }}</td>
                              <td>{{ $room->pivot->walkInOrReservation }}</td>
                              <td>Rp. {{ number_format($room->pivot->roomRate, 0, ',', '.') }}</td>
                              <td>{{ $difference }} Night</td>
                              <td>
                                 Rp.
                                 @php
                                 $roomRate = $room->pivot->roomRate * $difference;
                                 echo number_format($roomRate, 0, ',', '.')
                                 @endphp
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tbody>
                           <tr rowspan="1" style="background:#3498db;font-weight:bold;">
                              <td colspan="6"></td>
                              <td>
                                 Rp.
                                 @php
                                 $total = $registration->rooms()->sum('roomRate') * $difference;
                                 echo number_format($total, 0, ',', '.')
                                 @endphp
                              </td>
                           </tr>
                        </tbody>
                        @if(!empty($registration->extraBad))
                        <tbody>
                           <tr rowspan="1" style="background:#2ecc71;font-weight:bold;">
                              <td colspan="6">Extrabad ({{ $registration->extraBad->amount }}) :</td>
                              <td>
                                 Rp. {{ number_format($registration->extraBad->rate * $registration->extraBad->amount * $difference, 0, ',', '.') }} (+)
                              </td>
                           </tr>
                        </tbody>
                        @endif
                        @if(isset($guestReservation))
                        <tbody>
                           <tr rowspan="1" style="background:#dbc3c7;font-weight:bold;">
                              <td colspan="6">Deposit :</td>
                              <td>
                                 Rp. {{ number_format($guestReservation->reservation->deposit, 0, ',', '.') }} (-)
                              </td>
                           </tr>
                        </tbody>
                        @endif
                        <tfoot>
                           <tr rowspan="1" style="background:yellow;font-weight:bold;">
                              <td colspan="6">Total :</td>
                              <td>
                                 Rp.
                                 @if(isset($guestReservation))
                                    {{-- jika dari reservation --}}
                                    @if(!empty($registration->extraBad))
                                       @php
                                          $total = ($registration->rooms()->sum('roomRate') * $difference) + ($registration->extraBad->rate * $difference) - $guestReservation->reservation->deposit;
                                          echo number_format($total, 0, ',', '.')
                                       @endphp
                                    @else
                                       @php
                                          $total = ($registration->rooms()->sum('roomRate') * $difference) - $guestReservation->reservation->deposit;
                                          echo number_format($total, 0, ',', '.')
                                       @endphp
                                    @endif
                                    
                                 @else
                                 {{-- jika datang langsung --}}
                                    @if(!empty($registration->extraBad))
                                       @php
                                          $total = ($registration->rooms()->sum('roomRate') * $difference) + ($registration->extraBad->rate * $difference);
                                          echo number_format($total, 0, ',', '.')
                                       @endphp
                                    @else
                                       @php
                                          $total = $registration->rooms()->sum('roomRate') * $difference;
                                          echo number_format($total, 0, ',', '.')
                                       @endphp
                                    @endif
                                 @endif
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- Meals for group reservation --}}
      @if(isset($guestGroupReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="h3">
                     <i class="fa fa-info-circle"></i>
                        &nbsp;Detail meal arragement
                  </div>
               </div>
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>Meals</th>
                        <th>Hour</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($guestGroupReservation->reservationGroup->meals as $meal)
                        <tr>
                           <td>{{ $meal->type }}</td>
                           <td>{{ $meal->pivot->atTime }}</td>
                        </tr>
                     @empty
                        
                     @endforelse
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      @endif

   </div>
@endsection

@push('modals')
   {{-- MODAL --}}
<div class="modal fade" id="modal-telephoneVoucher">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Telephone voucher</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('reception.billTelephone.store') }}" method="post">
         @csrf
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Guest name</label>
                  <input type="text" name="" class="form-control" id="" value="{{ $registration->getGuestName() }}" disabled>

                  <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Room</label>
                  <select name="room_id" class="form-control" id="" required>
                     <option value=""></option>
                     @foreach($registration->rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                     @endforeach
                  </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="date" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                  <label>No. Called</label>
                  <input type="number" name="noCalled" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>City</label>
                  <input type="text" name="city" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" class="form-control">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Time</label>
                  <input type="time" name="time" class="form-control">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Connected</label>
                  <input type="text" name="connected" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Disconected</label>
                  <input type="text" name="disconected" class="form-control">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Minutes</label>
                  <input type="number" name="minutes" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Amount Rp</label>
                  <input type="number" name="amount" class="form-control" required>
                  </div>
               </div>
            </div>

         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create bill</button>
         </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-miscellVoucher">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Miscellaneous charges voucher</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('reception.billMiscellaneous.store') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Guest name</label>
                     <input type="text" name="" class="form-control" id="" value="{{ $registration->getGuestName() }}" disabled>

                     <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Room</label>
                     <select name="room_id" class="form-control" id="" required>
                        <option value=""></option>
                        @foreach($registration->rooms as $room)
                           <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                        @endforeach
                     </select>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Date</label>
                     <input type="date" name="date" class="form-control" required>
                     </div>
                  </div>
               </div>
               <div class="row">
               <a href="#" class="btn btn-primary adddRowMiscellaneous btn-xs mb-2"><i class="fa fa-plus"></i></a>
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Discription</th>
                           <th>Total amount</th>
                           <th>X</th>
                        </tr>
                     </thead>
                     <tbody class="rowMiscellaneous">
                        <tr>
                           <td>
                              <input type="text" name="descriptions[]" class="form-control" id="">
                           </td>
                           <td style="width:200px;">
                              <input type="number" name="amount[]" onkeyup="countTotalMiscellaneous()" class="form-control amount" id="">
                           </td>
                           <td>
                              
                           </td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                           <td><center><b>Total</b></center></td>
                           <td colspan="" class="total"></td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Create bill</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-paidOutVoucher">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">paid out voucher</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="" method="post">
               @csrf
               <div class="modal-body">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                        <label>Guest name</label>
                        <input type="text" name="" class="form-control" id="" value="{{ $registration->getGuestName() }}" disabled>

                        <input type="hidden" name="registration_id" value="{{ $registration->id }}" disabled>

                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                        <label>Room</label>
                        <select name="room" class="form-control" id="" required>
                           <option value=""></option>
                           @foreach($registration->rooms as $room)
                              <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                           @endforeach
                        </select>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" required>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                  <a href="#" class="btn btn-primary addRowPaidOutVoucher btn-xs mb-2"><i class="fa fa-plus"></i></a>
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>Discription</th>
                              <th>Total amount</th>
                              <th>X</th>
                           </tr>
                        </thead>
                        <tbody class="rowPaidOutVoucher">
                           <tr>
                              <td>
                                 <input type="text" name="description[]" class="form-control" id="">
                              </td>
                              <td style="width:200px;">
                                 <input type="number" name="amount[]" onkeyup="countPaidOutVoucher()" class="form-control amountPaidOutVoucher" id="">
                              </td>
                              <td>
                                 
                              </td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td><center><b>Total</b></center></td>
                              <td colspan="2" class="totalPaidOutVoucher"></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Create bill</button>
               </div>
            </form>
      </div>
   </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEditTelpVoucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit telephone voucher</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body" id="smallBody">
            <form action="{{ route('reception.billtelephone.update') }}" method="post">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Guest name</label>
                     <input type="text" id="name" class="form-control" id="" value="{{ $registration->getGuestName() }}" disabled>

                     <input type="hidden" id="id" name="id">

                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Room</label>
                     <select name="room_id" class="form-control" id="room_id" required>
                        <option value=""></option>
                        @foreach($registration->rooms as $room)
                           <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                        @endforeach
                     </select>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                     <label>Date</label>
                     <input type="date" name="date" id="date" class="form-control" required>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group">
                     <label>No. Called</label>
                     <input type="number" name="noCalled" id="noCalled" class="form-control" required>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>City</label>
                     <input type="text" name="city" id="city" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Country</label>
                     <input type="text" name="country" id="country" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Time</label>
                     <input type="time" name="time" id="time" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Connected</label>
                     <input type="text" name="connected" id="connected" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Disconected</label>
                     <input type="text" name="disconected" id="disconected" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Minutes</label>
                     <input type="number" name="minutes" id="minutes" class="form-control" required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                     <label>Amount Rp</label>
                     <input type="number" name="amount" id="amount" class="form-control" required>
                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Edit bill</button>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modalEditMiscellaneousVoucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit miscellaneous voucher</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body" id="smallBody">
            <form action="{{ route('reception.billMicellaneous.update') }}" method="post">
            @csrf
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Guest name</label>
                  <input type="text" id="name" class="form-control" id="" value="{{ $registration->getGuestName() }}" disabled>

                  <input type="hidden" id="idMiscellaneous" name="id">

                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Room</label>
                  <select name="room_id" class="form-control" id="room_idMiscellaneous" required>
                     <option value=""></option>
                     @foreach($registration->rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                     @endforeach
                  </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="date" id="dateMiscellaneous" class="form-control" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Discription</label>
                  <input type="text" name="descriptions" id="descriptionsMiscellaneous" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Amount</label>
                  <input type="text" name="amount" id="amountMiscellaneous" class="form-control" required>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Edit bill</button>
         </div>
         </form>
      </div>
   </div>
</div>
@endpush
@push('scripts')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
   <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
   <script>
      $('.adddRowMiscellaneous').live('click', function() {
         addRowMiscell();
      });

      function addRowMiscell() {
         let tr = `
            <tr>
               <td>
               <input type="text" name="descriptions[]" class="form-control" id="">
               </td>
               <td>
                  <input type="number" name="amount[]" onkeyup="countTotalMiscellaneous()" class="form-control amount" id="">
               </td>
               <td>
                  <a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a>
               </td>
            </tr>
         `;
         $('.rowMiscellaneous').append(tr);
      }

      $('.remove').live('click',  function(){
         var last=$('tbody tr .a').length;
         console.log(last);
         if(last == 1){
            alert('You can nor remove last row');
         } else {
            $(this).parent().parent().remove();
            var tr = $(this).parent().parent();
            var amount = tr.find('.amount').val();
            var total = 0;
            
            $('.amount').each(function(i,e){
               var amount = $(this).val()-0;
               total += amount;
            });

            // format rupiah
            var reverse = total.toString().split('').reverse().join(''),
            total = reverse.match(/\d{1,3}/g);
            total = total.join('.').split('').reverse().join('');

            $('.total').html(`Rp. ${total}`);  
         }
      });

      function countTotalMiscellaneous(){
         var tr = $(this).parent().parent();
         var amount = tr.find('.amount').val();
         var total = 0;

         $('.amount').each(function(i,e){
            var amount = $(this).val()-0;
            total += amount;
         });

         // format rupiah
         var reverse = total.toString().split('').reverse().join(''),
         total = reverse.match(/\d{1,3}/g);
         total = total.join('.').split('').reverse().join('');

         $('.total').html(`Rp. ${total}`);   
      }
      
      /**
      PAID OUT VOUCHER
      */

      $('.addRowPaidOutVoucher').on('click', function() {
         let tr = `
            <tr>
               <td>
               <input type="text" name="description[]" class="form-control" id="">
               </td>
               <td>
                  <input type="number" name="amount[]" onkeyup="countPaidOutVoucher()" class="form-control amount" id="">
               </td>
               <td>
                  <a href="#" class="btn btn-danger removePaidOutVoucher"><i class="fa fa-times"></i></a>
               </td>
            </tr>
         `;
         $('.rowPaidOutVoucher').append(tr);
      });

      $('.removePaidOutVoucher').live('click',  function(){
         var last=$('tbody tr .a').length;
         console.log(last);
         if(last == 1){
            alert('You can nor remove last row');
         } else {
            $(this).parent().parent().remove();
            var tr = $(this).parent().parent();
            var amount = tr.find('.amount').val();
            var amountPaidOutVoucher = 0;
            
            $('.amount').each(function(i,e){
               var amount = $(this).val()-0;
               amountPaidOutVoucher += amount;
            });

            // format rupiah
            var reverse = amountPaidOutVoucher.toString().split('').reverse().join(''),
            amountPaidOutVoucher = reverse.match(/\d{1,3}/g);
            amountPaidOutVoucher = amountPaidOutVoucher.join('.').split('').reverse().join('');

            $('.amountPaidOutVoucher').html(`Rp. ${amountPaidOutVoucher}`);  
         }
      });

      function countPaidOutVoucher(){
         var tr = $(this).parent().parent();
         var amountPaidOutVoucher = tr.find('.amountPaidOutVoucher').val();
         var totalPaidOutVoucher = 0;

         $('.amountPaidOutVoucher').each(function(i,e){
            var amountPaidOutVoucher = $(this).val()-0;
            totalPaidOutVoucher += amountPaidOutVoucher;
         });

         // format rupiah
         var reverse = totalPaidOutVoucher.toString().split('').reverse().join(''),
         totalPaidOutVoucher = reverse.match(/\d{1,3}/g);
         totalPaidOutVoucher = totalPaidOutVoucher.join('.').split('').reverse().join('');

         $('.totalPaidOutVoucher').html(`Rp. ${totalPaidOutVoucher}`);   
      }

      //MODAL edit
      $(document).ready(function(){
         //TELEPHONE VOUCHER
         $('body').on('click', '#editTelephoneVoucher', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            console.log(id)
            $.get('/reception/guest/billtelephonne/edit/'+id, function (data) {
               console.log(data);
               $('#id').val(data.data.id);
               $('#room_id').val(data.data.room_id);
               $('#date').val(data.data.date);
               $('#noCalled').val(data.data.noCalled);
               $('#city').val(data.data.city);
               $('#country').val(data.data.country);
               $('#time').val(data.data.time);
               $('#connected').val(data.data.connected);
               $('#disconected').val(data.data.disconected);
               $('#minutes').val(data.data.minutes);
               $('#amount').val(data.data.amount);
               $('#modalEditTelpVoucher').appendTo('body');
            });
         });

         //MISCELLENEOUS
         $('body').on('click', '#editMiscellaneousVoucher', function(event){
            var id = $(this).data('id');
            $.get('/reception/guest/billMiscellaneous/edit/'+id, function(data){
               console.log(data.data.amount);
               $('#idMiscellaneous').val(data.data.id);
               $('#room_idMiscellaneous').val(data.data.room_id);
               $('#dateMiscellaneous').val(data.data.date);
               $('#descriptionsMiscellaneous').val(data.data.descriptions);
               $('#amountMiscellaneous').val(data.data.amount);
               $('#modalEditMiscellaneousVoucher').appendTo('body');
            });
         })
      });

      
   </script>
@endpush
