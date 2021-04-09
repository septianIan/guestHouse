@extends('frontOffice.template.ui')
@section('title', 'Detail Registration guest')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reception.registration.index') }}">Data Registration</a></li>
   <li class="breadcrumb-item active">Detail Registration guest</li>
</ol>
@endsection

@section('content')
   <div class="container">
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
               <div class="row invoice-info" style="font-size:14px;">
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Name guest : {{ $registration->getGuestName() }}<br>
                        Nationality : {{ $registration->nationality }}<br>
                        Passport : {{ $registration->passport }}<br>
                        Occupation : {{ $registration->occupation }}<br>
                        Date birth : {{ $registration->dateBirth }}
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
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
                  <div class="col-sm-3 invoice-col">
                     @if($registration->status == 'checkIn')
                        <div class="alert alert-info alert-dismissible">
                           <h5><i class="icon fas fa-check"></i>Check In!</h5>
                           <p>
                              On : {{ $dataCheckIn->date }} <br>
                              Hour : {{ $dataCheckIn->time }}
                           </p>
                        </div>  
                     @elseif($registration->status == 'checkOut')
                        <div class="alert alert-success alert-dismissible">
                           <h5><i class="icon fas fa-check"></i>Check Out!</h5>
                           <p>
                              On : {{ $dataCheckOut->date }} <br>
                              Hour : {{ $dataCheckOut->time }}
                           </p>
                        </div>
                     @else
                        <div class="alert alert-warning alert-dismissible">
                           <h5><i class="icon fas fa-check"></i>{{ $registration->status }}!</h5>
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- Detial Reservation guest --}}
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
                     <b>Special Request</b>
                     <address>
                        {{ $guestGroupReservation->reservationGroup->specialRequest }}
                     </address>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif

      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Bill
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

      {{-- GUEST bILL --}}
      <div class="row">
         {{-- Room surcharge --}}
         @if($roomSurCharges->isNotEmpty())
            <div class="col-sm-6">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Room surcharge
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col" style="font-size:14px;">
                     <p>
                        Name guest : {{ $registration->getGuestName() }}<br>
                        Nationality : {{ $registration->nationality }}<br>
                        Passport : {{ $registration->passport }}<br>
                        Occupation : {{ $registration->occupation }}<br>
                        Date birth : {{ $registration->dateBirth }} <br>
                        Check in time : {{ $registration->checkIn->time }}
                     </p>
                  </div>
                  <table class="table table-bordered table-striped" style="font-size:14px;">
                     <thead>
                        <tr>
                           <th>Type room</th>
                           <th>Room surcharge</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($roomSurCharges as $roomSurCharge)
                           <tr>
                              <td>{{ $roomSurCharge->typeRoom }}</td>
                              <td>Rp. {{ number_format($roomSurCharge->roomSurCharge, 0, ',', '.') }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         @endif
         {{-- master bill --}}
         @if($registration->status == 'checkOut')
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
         @endif
      </div>
   </div>
@endsection