@extends('frontOffice.template.ui')
@section('title', 'Detail Guest Check Out')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reception.cashier.index') }}">Data Guest Check Out</a></li>
   <li class="breadcrumb-item active">Detail Guest Check Out</li>
</ol>
@endsection

@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3" style="background:red;">
               <div class="row">
                  <div class="col-12">
                     <h4 style="color:white;">
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Guest Check Out
                     </h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
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
                        Name guest : {{ $registrationCheckOut->registration->getGuestName() }}<br>
                        Nationality : {{ $registrationCheckOut->registration->nationality }}<br>
                        Passport : {{ $registrationCheckOut->registration->passport }}<br>
                        Occupation : {{ $registrationCheckOut->registration->occupation }}<br>
                        Date birth : {{ $registrationCheckOut->registration->dateBirth }}
                     </p>
                  </div>
                  <div class="col-sm-4 invoice-col">
                     <p>
                        Home address : {{ $registrationCheckOut->registration->homeAddress }}<br>
                        Company : {{ $registrationCheckOut->registration->company }}<br>
                        Purpose : {{ $registrationCheckOut->registration->purpose }}<br>
                        Arrivale date : {{ $registrationCheckOut->registration->arrivaleDate }}<br>
                        Departure Date : {{ $registrationCheckOut->registration->departureDate }}
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Coming from : {{ $registrationCheckOut->registration->comingFrom }} <br>
                        Next destination : {{ $registrationCheckOut->registration->nextDestination }}<br>
                        Term of payment : {{ $registrationCheckOut->registration->termOfPayment }}<br>
                        Number account : {{ $registrationCheckOut->registration->numberAccount }}<br>
                        Exp date : {{ $registrationCheckOut->registration->expDate }}
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
                        Guarantee letter : {{ $guestGroupReservation->reservationGroup->methodPayment->value1 }}<br>
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

      {{-- GUEST BILL walkin--}}
      @if(isset($guestIndividaulReservation))
         @include('frontOffice.reception.cashier.coDetail.guestIndividualReservation')
      @elseif(isset($guestGroupReservation))
         @include('frontOffice.reception.cashier.coDetail.guestGroupReservation')
      @else
         {{-- Guest Bill walk in--}}
         @include('frontOffice.reception.cashier.coDetail.guestWalkIn')
      @endif
      </div>
   </div>
@endsection
@push('styles')
   <!--- Sweet alert -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme/bootstrap-4.min.css') }}">
@endpush
@push('scripts')
   <script>
   
   </script>
@endpush
