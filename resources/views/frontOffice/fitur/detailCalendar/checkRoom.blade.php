@extends('frontOffice.template.ui')
@section('title', 'Check room')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline card-success">
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Date</th>
                           <th>Availeble</th>
                           <th>The room will be empty</th>
                        </tr>
                     </thead>
                     <tbody>
                           <tr>
                              <td>{{ $dateSelected }}</td>
                              <td>{{ $roomAvailble }} Rooms</td>
                              <td>
                                 <p>Room to check out</p>
                                 @foreach($registration as $regis)
                                    @foreach($regis->rooms as $room)
                                       <li style="color:green;">{{ $room->numberRoom }}</li>
                                    @endforeach
                                 @endforeach
                                 <hr>
                                 <p>Can only choose {{ $standartRoomAvailable }} STANDART room</p>
                                 @if($standartRoomAvailable != 0)
                                    @foreach($standartRoom as $v)
                                       <li>{{ $v->numberRoom }}</li>
                                    @endforeach
                                 @endif
                                 <hr>
                                 <p>Can only choose {{ $superiorRoomAvaileble }} SUPERIOR room</p>
                                 @if($superiorRoomAvaileble != 0)
                                    @foreach($superiorRoom as $v)
                                       <li>{{ $v->numberRoom }}</li>
                                    @endforeach
                                 @endif
                                 <hr>
                                 <p>Can only choose {{ $deluxeRoomAvaileble }} DELUXE room</p>
                                 @if($deluxeRoomAvaileble != 0)
                                    @foreach($deluxeRoom as $v)
                                       <li>{{ $v->numberRoom }}</li>
                                    @endforeach
                                 @endif
                              </td>
                           </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
