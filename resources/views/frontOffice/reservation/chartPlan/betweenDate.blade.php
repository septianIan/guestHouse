@extends('frontOffice.template.ui')
@section('title', 'Date between')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Date between</h3>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-4">
                        <input type="date" class="form-control">
                     </div>
                     <div class="col-sm-4">
                        <input type="date" class="form-control">
                     </div>
                     <div class="col-sm-4">
                        <button class="btn btn-success">Submit</button>
                     </div>
                  </div>

                  {{-- Result --}}
                  <div class="row">
                     <div class="col-md-12 mt-2">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th>No</th>
                                 <th>Guest name</th>
                                 <th>Arrivale</th>
                                 <th>Departure</th>
                                 <th>Room</th>
                                 <th>Type</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($data as $value)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value[0] }}</td>
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
