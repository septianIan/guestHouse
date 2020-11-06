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
                        Coming from : {{ $registration->comingFrom }}
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
                                    Rp. {{ number_format($room->pivot->roomRate*=$difference, 0, ',', '.') }}
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr rowspan="1" style="background:yellow;font-weight:bold;">
                           <td colspan="6"></td>
                              <td>
                                 Rp. {{ number_format($grandTotal, 0, ',', '.') }}
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