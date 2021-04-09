@extends('frontOffice.template.ui')
@section('title', 'Rooms Status')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title"></h3>
               </div>
               <div class="card-body">
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
