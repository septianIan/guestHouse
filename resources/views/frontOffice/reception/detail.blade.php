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

      {{-- Detial Reservation guest --}}
      @if(isset($guestReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Guest Reservation
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <address>
                        <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $guestReservation->reservation->guestName }} </font></strong><br>
                        Address : {{ $guestReservation->reservation->address }}<br>
                        Contact Person : {{ $guestReservation->reservation->contactPerson }}<br>
                        Name Person : {{ $guestReservation->reservation->namePerson }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Date Reservation : </b>{{ $guestReservation->reservation->created_at }}
                     <address>
                        Arrivale Date : {{ $guestReservation->reservation->arrivaleDate }}<br>
                        Departure Date : {{ $guestReservation->reservation->departureDate }}<br>
                        Estimate Arrival Check in : {{ $guestReservation->reservation->estimateArrivale }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Payment</b>
                     <address>
                        Method Payment : {{ $guestReservation->reservation->methodPayment }}<br>
                        Deposit : {{ number_format($guestReservation->reservation->deposit, 0, ',', '.') }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Order room by reservation</b>
                     <address>
                        @foreach($guestReservation->reservation->individualReservationRooms as $value)
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
                              <td colspan="6">Extrabad :</td>
                              <td>
                                 Rp. {{ number_format($registration->extraBad->rate * $difference, 0, ',', '.') }} (+)
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
   </div>
@endsection