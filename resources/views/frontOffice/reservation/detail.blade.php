@extends('frontOffice.template.ui')
@section('title', 'Detail Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Detail Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
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
                     <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $reservation->guestName }} </font></strong><br>
                     Address : {{ $reservation->address }}<br>
                     Contact Person : {{ $reservation->contactPerson }}<br>
                     Name Person : {{ $reservation->namePerson }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation</b>
                  <address>
                     Arrivale Date : {{ $reservation->arrivaleDate }}<br>
                     Departure Date : {{ $reservation->departureDate }}<br>
                     Estimate Arrival Check in : {{ $reservation->estimateArrivale }}<br>
                     Email: info@almasaeedstudio.com
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Payment</b>
                  <address>
                     Method Payment : {{ $reservation->methodPayment }}<br>
                     Deposit : {{ $reservation->deposit }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Booked Room</b>
                  <address>
                     Total Room : {{ $reservation->rooms->count() }}<br>
                  </address>
               </div>

               <div class="row mt-3">
                  <h4 class="mx-3">
                     <i class="fa fa-info-circle"></i>
                     &nbsp;Billing Datails
                  </h4>
                  <div class="col-12 table-responsive">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Number Room</th>
                              <th>Type Room</th>
                              <th>Stay overnight</th>
                              <th>Room rate</th>
                              <th>Total rate per room</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($reservation->rooms as $room)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $room->numberRoom }}</td>
                              <td>{{ $room->roomType }}</td>
                              <td>{{ $difference }} Night</td>
                              <td>{{ $room->getPriceRp() }}</td>
                              <td>
                                 Rp. 
                                 @php
                                    echo number_format($room->price*=$difference, 0, ',', '.')
                                 @endphp
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tbody>
                           <tr style="background:lightblue;">
                              <td colspan="5" style="font-weight:bold;">Deposit&nbsp;:</td>
                              <td colspan="5">Rp.&nbsp;{{ number_format($reservation->deposit, 0, ',', '.') }}</td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr rowspan="1" style="background:yellow;font-weight:bold;">
                              <td colspan="5">Total :</td>
                              <td>Rp. 
                                 @php
                                    echo number_format($reservation->total-=$reservation->deposit, 0, ',', '.')
                                 @endphp
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
</div>
@endsection
