@extends('frontOffice.template.ui')
@section('title', 'Cancel Guest')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation Guest</a></li>
   <li class="breadcrumb-item active">Data Cancel Reservation Guest</li>
</ol>
@endsection
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">Data Cancel Guest</h3>
            </div>
            <div class="card-body">
               <table id="dataTable" class="table table-bordered table-stripped">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Name Guest</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Media Reservation</th>
                        <th>Estimate Arrival</th>
                        <th>Action</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!--- Sweet alert -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme/bootstrap-4.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
   $(function() {
      //dataTable
      $('#dataTable').DataTable({
         "processing" : true,
         "serverSide" : true,
         "responsive" : true,
         "autoWidth" : true,
         ajax: '{{ route('reservation.data.cancelReservations') }}',
         columns : [
            {data: 'DT_RowIndex'},
            {data: 'guestName'},
            {data: 'arrivaleDate'},
            {data: 'departureDate'},
            {data: 'mediaReservation'},
            {data: 'estimateArrivale'},
            {
               data: 'detail', 
               name: 'detail', 
               orderable: true, 
               searchable: true
            },
         ]
      });
   })
</script>
@endpush
