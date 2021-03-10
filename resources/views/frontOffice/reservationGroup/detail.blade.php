@extends('frontOffice.template.ui')
@section('title', 'Detail reservation group')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservationGroup.index') }}">Data Reservation</a></li>
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
                     &nbsp;Detail Group Reservation
                  </h4>
               </div>
            </div>
            <div class="row invoice-info">
               <div class="col-sm-4 invoice-col">
                  <p>
                     <strong>Group name :&nbsp; <font style="font-style:italic;">{{ $reservationGroup->groupName }}</font></strong>
                     <br>
                     Contact Person : {{ $reservationGroup->contactPerson }}
                     <br>
                     Name person : {{ $reservationGroup->namePerson }}
                     <br>
                     Address : {{ $reservationGroup->addressPerson }}
                  </p>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation</b>
                  <p>
                     Arrivale Date : {{ $reservationGroup->arrivaleDate }}<br>
                     Departure Date : {{ $reservationGroup->departureDate }}<br>
                     Estimate Arrival Check in : {{ $reservationGroup->estimateArrivale }}<br>
                     Date Reservation : {{ $reservationGroup->dateReservation }}
                  </p>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Method Payment :&nbsp; <font style="font-style:italic;">{{ $reservationGroup->methodPayment->methodPayment }}</font></b>
                  @if($reservationGroup->methodPayment->methodPayment == 'personal')
                  <p>
                     Cast deposit : {{ number_format($reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                     Credit card : {{ $reservationGroup->methodPayment->value1 }}<br>
                     Number account : {{ $reservationGroup->methodPayment->value2 }}<br>
                     Other : {{ $reservationGroup->methodPayment->value3 }}<br>
                  </p>
                  @else
                  <p>
                     Deposit : {{ number_format($reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                     Credit card : {{ $reservationGroup->methodPayment->value1 }}<br>
                     Travel agent : {{ $reservationGroup->methodPayment->value2 }}<br>
                     Other : {{ $reservationGroup->methodPayment->value3 }}<br>
                  </p>
                  @endif
               </div>
               <div class="col-sm-2 invoice-col">

               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-12">
         <div class="invoice p-3 mb-3">
            <div class="row mt-3">
               <h4 class="mx-3">
                  <i class="fa fa-info-circle"></i>
                  &nbsp;Room Datails
               </h4>
               <div class="col-12 table-responsive">
                  <table id="nilai" class="table table-bordered table-striped detailBill">
                     <thead>
                        <tr>
                           <th>Total Room Reserved</th>
                           <th>Type Of Room</th>
                           <th>Room rate</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($reservationGroup->groupReservationRooms as $value)
                        <tr>
                           <td>{{ $value->totalRoomReserved }}</td>
                           <td>{{ $value->typeOfRoom }}</td>
                           <td>Rp. {{ number_format($value->roomRate, 0, ',','.') }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-12">
         <div class="invoice p-3 mb-3">
            <div class="row mt-3">
               <h4 class="mx-3">
                  <i class="fa fa-info-circle"></i>
                  &nbsp;Meal Datails
               </h4>
               <div class="col-12 table-responsive">
                  <table id="nilai" class="table table-bordered table-striped detailBill">
                     <thead>
                        <tr>
                           <th>Type meal</th>
                           <th>At time</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($reservationGroup->meals as $value)
                        <tr>
                           <td>{{ $value->type }}</td>
                           <td>{{ $value->pivot->atTime }}</td>
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