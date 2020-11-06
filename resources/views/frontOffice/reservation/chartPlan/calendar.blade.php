@extends('frontOffice.template.ui')
@section('title', 'Calendar')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline card-success">
               {!! $calendar->calendar() !!}
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
{!! $calendar->script() !!}
@endpush
