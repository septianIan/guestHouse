@extends('frontOffice.template.ui')
@section('title', 'Individual Reservation')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="">Home</a></li>
   <li class="breadcrumb-item active">Data Individual Reservation</li>
</ol>
@endsection

@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">Data Individual Reservation</h3>
               <a href="{{ route('reservation.reservation.create') }}" class="float-right"><i class="fa fa-plus"></i> Add Reservation</a>
            </div>
            <div class="card-body">
               @if(session('message'))
                  <div  div id="notif" class="alert alert-info">{{ session('message') }}</div>
               @endif
               <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Guest Name</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Media Reservation</th>
                        <th>Estimate Arrival</th>
                        <th>Status</th>
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
         ajax: '{{ route('reservation.data.reservations') }}',
         columns : [
            {data: 'DT_RowIndex'},
            {data: 'guestName'},
            {data: 'arrivaleDate'},
            {data: 'departureDate'},
            {data: 'mediaReservation'},
            {data: 'estimateArrivale'},
            {data: 'status'},
            {data: 'action'}
         ]
      });
      //sweet alert
      $('#dataTable').on('click', 'button#delete', function(e){
         e.preventDefault();
         var id = $(this).data('id'); //ambil dari data-id

         Swal.fire({
            title: 'Are you sure you delete this data?',
            text: "Deleted data! means canceled reservation!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel!',
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: "DELETE",
                  url: "/reservation/reservation/" +id,
                  data: {
                     "id": id,
                     "_token": "{{ csrf_token() }}"
                  },

                  success: function(data){
                     if(data.success === true){
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                        })
                     } else {
                        Swal.fire('Erase Data!', data.message, 'success')
                        location.reload(true);
                     }
                  }
               })
            }
         })
      });
      //notif
      $('#notif').fadeTo(2000, 500).slideUp(500, function(){
            $('#notif').slideUp(500);
      })
   });
</script>
@endpush
