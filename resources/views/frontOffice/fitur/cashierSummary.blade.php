@extends('frontOffice.template.ui')
@section('title', 'Front office cashier summary')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-outline card-primary">
               <div class="card-body" id="calendar">
                  
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@push('styles')
   <link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
   <link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush
@push('scripts')
   <script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js'></script>
   <script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/jquery.min.js'></script>
   <script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js'></script>
   <script>
      $(document).ready(function(){
         $('#calendar').fullCalendar({
            dayClick: function(date, jsEvent, view, resourceObj){
               alert('Selected on: ' + date.format());
               window.open('/front-office/cashier/summary/'+date.format(), '_blank');
            }
         });
      })
   </script>  
@endpush
