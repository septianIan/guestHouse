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
               <div class="col-sm-3 invoice-col">
                  <p>
                     <strong>Group name :&nbsp; <font style="font-style:italic;">{{ $reservationGroup->groupName }}</font></strong>
                     <br>
                     Name person : {{ $reservationGroup->namePerson }}
                     <br>                     
                     Contact Person : {{ $reservationGroup->contactPerson }}
                     <br>
                     Address : {{ $reservationGroup->addressPerson }}
                  </p>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation</b>
                  <p>
                     Arrivale Date : {{ $reservationGroup->arrivaleData }}<br>
                     Departure Date : {{ $reservationGroup->departureDate }}<br>
                     Estimate Arrival Check in : {{ $reservationGroup->estimateArrivale }}<br>
                     Date Reservation : {{ $reservationGroup->dateReservation }}
                  </p>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Method Payment :&nbsp; <font style="font-style:italic;">{{ $reservationGroup->methodPayment->methodPayment }}</font></b>
                  @if($reservationGroup->methodPayment->methodPayment == 'personal')
                     <p>
                        Cast deposit : {{ $reservationGroup->methodPayment->value2 }}<br>
                        Credit card : {{ $reservationGroup->methodPayment->value3 }}<br>
                        Other : {{ $reservationGroup->methodPayment->value4 }}<br>
                     </p>
                  @else
                     <p>
                        Guarantee : {{ $reservationGroup->methodPayment->value2 }}<br>
                        Voucher : {{ $reservationGroup->methodPayment->value3 }}<br>
                        Other : {{ $reservationGroup->methodPayment->value4 }}<br>
                     </p>
                  @endif
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Booked Room</b>
                  <p>
                     Total Room : {{ count($reservationGroup->rooms) }}<br>
                  </p>
               </div>

               <div class="row mt-3">
                  <h4 class="mx-3">
                     <i class="fa fa-info-circle"></i>
                     &nbsp;Billing Datails
                  </h4>
                  <div class="col-12 table-responsive">
                     <table class="table table-bordered table-avatar">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Number room</th>
                              <th>Type room</th>
                              <th>Stay overnight</th>
                              <th>Room rate</th>
                              <th>Total rate per room</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($reservationGroup->rooms as $room)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $room->numberRoom }}</td>
                                 <td>{{ $room->roomType }}</td>
                                 <td>{{ $difference }} Night</td>
                                 <td>
                                    {{ $room->getPriceRp() }} / Night
                                    
                                 </td>
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
                           <tr rowspan="1" style="background:#FFA07A;font-weight:bold;">
                              <td colspan="5">Total room payment:</td>
                              <td>
                                 {{ $reservationGroup->getTotalRp() }}
                              </td>
                           </tr>
                        </tbody>
                        <tbody>
                           <tr>
                              <th>No</th>
                              <th>Meal</th>
                              <th colspan="5">At Time</th>
                           </tr>
                        </tbody>
                        <tbody>
                           @foreach($reservationGroup->meals as $meal)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $meal->type }}</td>
                                 <td colspan="5">{{ $meal->pivot->atTime }}</td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tbody>
                           <tr rowspan="1" style="background:#98FB98;font-weight:bold;">
                              <td colspan="5">Total meal :</td>
                              <td>
                                 (+) Rp. {{ number_format($totalMeal, 0, ',', '.') }}
                              </td>
                           </tr>
                        </tbody>
                        <tbody>
                           <tr rowspan="1">
                              <th>Special request</th>
                              <td colspan="4">{{ $reservationGroup->specialRequest }}</td>
                              <td style="background:lightblue;font-weight:bold;">(+) Rp. {{ number_format($reservationGroup->costRequest, 0, ',', '.') }}</td>
                           </tr>
                        </tbody>
                        @if($reservationGroup->methodPayment->methodPayment == 'personal')
                        <tbody>
                           <tr>
                              <th colspan="5">Deposit&nbsp;:</th>
                              <th colspan="6" style="background:#FFB6C1;">(-) Rp.&nbsp;{{ number_format($reservationGroup->methodPayment->value2, 0, ',', '.') }}</th>
                           </tr>
                        </tbody>
                        @endif
                        <tfoot>
                           <tr rowspan="1" style="background:yellow;font-weight:bold;">
                              <td colspan="5">Total of all :</td>
                              <td>
                                 @if($reservationGroup->methodPayment->methodPayment == 'personal')
                                    Rp. {{ number_format($allTotal-=$reservationGroup->methodPayment->value2, 0, ',', '.') }}
                                 @else
                                    Rp. {{ number_format($allTotal, 0, ',', '.') }}
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
</div>
@endsection
