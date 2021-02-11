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
                     &nbsp;Detail Individual Reservation
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
                     Media Of Reservation : {{ $reservation->mediaReservation }}
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation</b>
                  <address>
                     Arrivale Date : {{ $reservation->arrivaleDate }}<br>
                     Departure Date : {{ $reservation->departureDate }}<br>
                     Estimate Arrival Check in : {{ $reservation->estimateArrivale }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Payment</b>
                  <address>
                     Method Payment : {{ $reservation->methodPayment }}<br>
                     Deposit : Rp. {{ number_format($reservation->deposit, 0, ',', '.') }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Status</b>
                  <address>
                     {{ $reservation->status }}
                  </address>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-sm-12">
         <div class="invoice p-3 mb-3">
            <div class="row mt-3">
               <h4 class="mx-3">
                  <i class="fa fa-info-circle"></i>
                  &nbsp;Room Datails
               </h4>
               <div class="col-12 table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Total Room Reserved</th>
                           <th>Type Of Room</th>
                           <th>Room rate</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($reservation->individualReservationRooms as $value)
                        <tr>
                           <td>{{ $value->totalRoomReserved }}</td>
                           <td>{{ $value->typeOfRoom }}</td>
                           <td>Rp. {{ number_format($value->roomRate, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
