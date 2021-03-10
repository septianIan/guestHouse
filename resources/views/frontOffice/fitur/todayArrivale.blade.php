@extends('frontOffice.template.ui')
@section('title', 'Today Arrivale List')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h2 class="card-title">
                     Arrivale today guest
                  </h2>
               </div>
               <div class="card-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Name/Group</th>
                           <th>Room blocked</th>
                           <th>Address/Company</th>
                           <th>Contact person</th>
                           <th>Departure date</th>
                           <th>Remark</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($arrivalReservation as $v)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $v['guestName'] }}</td>
                              <td></td>
                              <td>{{ $v['contactPerson'] }}</td>
                              <td>{{ $v['address'] }}</td>
                              <td>{{ $v['departureDate'] }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection