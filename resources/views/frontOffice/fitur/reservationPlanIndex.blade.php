@extends('frontOffice.template.ui')
@section('title', 'Reservation Plan')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">

   
      <div class="row">
         <div class="col-12 col-6">
            <div class="card card-default card-tabs">
               <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#allRoomsStatus" role="tab" aria-controls="allRoomsStatus" aria-selected="true">All room status</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#allRoomStatusStandart" role="tab" aria-controls="allRoomStatusStandart" aria-selected="false">All room status standart</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#allRoomStatusSuperior" role="tab" aria-controls="allRoomStatusSuperior" aria-selected="false">All room status superior</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#allRoomStatusDeluxe" role="tab" aria-controls="allRoomStatusDeluxe" aria-selected="false">All room status deluxe</a>
                     </li>
                  </ul>
               </div>
               {{-- Body --}}
               <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                     <div class="tab-pane fade show active" id="allRoomsStatus" role="tabpanel">
                        <div class="row">
                           @foreach($rooms as $room)
                              <div class="col-lg-3">
                                 <div class="card card-default" 
                                 @if($room->code == 'O')
                                    style="background:#0000FF;color:white;"
                                 @elseif($room->code == 'VR')
                                    style="background:#008000;color:white;"
                                 @elseif($room->code == 'VD')
                                    style="background:#FF0000;color:white;"
                                 @elseif($room->code == 'VC')
                                    style="background:#FFA500;color:white;"
                                 @endif>
                                    <div class="card-header">
                                       <h3 class="card-title">
                                          {{ $room->roomType }} 
                                       </h3>
                                       <h3 class="card-title float-right">
                                          <b>{{ $room->numberRoom }}</b> 
                                       </h3>
                                    </div>
                                    <div class="card-body">
                                       @if($room->code == 'O')
                                          <font style="font-weight:bold;">{{ $room->code }}</font>(Occupied)
                                       @elseif($room->code == 'VR')
                                          <font style="font-weight:bold;">{{ $room->code }}</font>(Vacant ready)
                                       @elseif($room->code == 'VD')
                                          <font style="font-weight:bold;">{{ $room->code }}</font>(Vacant dirty)
                                       @elseif($room->code == 'VC')
                                          <font style="font-weight:bold;">{{ $room->code }}</font>(Vacant clean)
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           @endforeach 
                        </div>
                     </div>
                     {{-- Standart rooms --}}
                     <div class="tab-pane fade" id="allRoomStatusStandart" role="tabpanel">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="card card-outline card-primary">
                                 <div class="card-header">
                                    <h3 class="card-title">STANDART</h3>
                                 </div>
                                 <div class="card-body">
                                    <table style="font-size:14px;" class="table table-striped table-bordered">
                                       <thead>
                                          <tr>
                                             <th>Total rooms</th>
                                             <th>O</th>
                                             <th>VD</th>
                                             <th>VC</th>
                                             <th>Booking</th>
                                             <th>VR</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>{{ count($roomStandart) }}</td>
                                             <td>{{ count($roomStandartO) }}</td>
                                             <td>{{ count($roomStandartVD) }}</td>
                                             <td>{{ count($roomStandartVC) }}</td>
                                             <td>{{ $totalBookingRoomReservedStandart }}</td>
                                             <td>{{ count($roomStandartVR) - $totalBookingRoomReservedStandart }}</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     {{-- Superior rooms --}}
                     <div class="tab-pane fade" id="allRoomStatusSuperior" role="tabpanel">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="card card-outline card-success">
                                 <div class="card-header">
                                    <h3 class="card-title">SUPERIOR</h3>
                                 </div>
                                 <div class="card-body">
                                    <table style="font-size:14px;" class="table table-striped table-bordered">
                                       <thead>
                                          <tr>
                                             <th>Total rooms</th>
                                             <th>O</th>
                                             <th>VD</th>
                                             <th>VC</th>
                                             <th>Booking</th>
                                             <th>VR</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>{{ count($roomSuperior) }}</td>
                                             <td>{{ count($roomSuperiorO) }}</td>
                                             <td>{{ count($roomSuperiorVD) }}</td>
                                             <td>{{ count($roomSuperiorVC) }}</td>
                                             <td>{{ $totalRoomReservedSuperior }}</td>
                                             <td>{{ count($roomSuperiorVR) - $totalRoomReservedSuperior }}</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     {{-- Deluxe rooms --}}
                     <div class="tab-pane fade" id="allRoomStatusDeluxe" role="tabpanel">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="card card-outline card-warning">
                                 <div class="card-header">
                                    <h3 class="card-title">DELUXE</h3>
                                 </div>
                                 <div class="card-body">
                                    <table style="font-size:14px;" class="table table-striped table-bordered">
                                       <thead>
                                          <tr>
                                             <th>Total rooms</th>
                                             <th>O</th>
                                             <th>VD</th>
                                             <th>VC</th>
                                             <th>Booking</th>
                                             <th>VR</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>{{ count($roomDeluxe) }}</td>
                                             <td>{{ count($roomDeluxeO) }}</td>
                                             <td>{{ count($roomDeluxeVD) }}</td>
                                             <td>{{ count($roomDeluxeVC) }}</td>
                                             <td>{{ $totalRoomReservedDeluxe }}</td>
                                             <td>{{ count($roomDeluxeVR) - $totalRoomReservedDeluxe }}</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     {{-- batas --}}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@push('styles')
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.css"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.css">
@endpush
@push('scripts')
<script src="http://code.jquery.com/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.js"></script>
@endpush
