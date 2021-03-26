@extends('frontOffice.template.ui')
@section('title', 'Today Departure List')
@section('breadcumb')
   
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h2 class="card-title">
                     Today Expected Departure today guest
                  </h2>
               </div>
               <div class="card-body">
                  <table id="dataTable" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Name/Group</th>
                           <th>Estimate arrival</th>
                           <th>Address/Company</th>
                           <th>Contact person</th>
                           <th>Arrival date</th>
                           <th>Departure date</th>
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
         ajax: '{{ route('data.todayEDList') }}',
         columns : [
            {data: 'DT_RowIndex'},
            {data: 'guestName'},
            {data: 'estimateArrivale'},
            {data: 'address'},
            {data: 'contactPerson'},
            {data: 'arrivaleDate'},
            {data: 'departureDate'},
         ]
      });
   });
</script>
@endpush