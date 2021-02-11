@extends('frontOffice.template.ui')
@section('title', 'Edit Individual Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Individual Reservation</a></li>
   <li class="breadcrumb-item active">Edit Individual Reservation</li>
</ol>
@endsection

@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('reservation.reservation.update', $reservation) }}" method="post">
            @csrf
            @method('put')
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Edit individual Reservation</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Guest Name</label>
                  <input type="text" name="guestName" class="form-control @error('guestName') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ $reservation->guestName }}">
                  @error('guestName')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Change Arrivale Date</label>
                  <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" autocomplete="off" value="{{ $reservation->arrivaleDate }}">
                  @error('arrivaleDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Change Departure Date</label>
                  <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" placeholder="Departure Date..." autocomplete="off" value="{{ $reservation->departureDate }}">
                  @error('departureDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Rooms Arragement</h3>
                  <a href="#" class="addExtraBad ml-2 btn btn-warning btn-xs"><i class="fa fa-plus px-1"></i>Add Extra bad</a>
               </div>
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <td>Media Of Reservation</td>
                           <td>Total Room Reserved</td>
                           <td>Type Of Room</td>
                           <td>Room rate</td>
                           <td>Discount</td>
                           <td>Action</td>
                        </tr>
                     </thead>
                     <tbody class="rowRooms">

                     </tbody>
                     <tbody>
                        @foreach($reservation->individualReservationRooms as $value)

                        <input type="hidden" name="idRooms[]" value="{{ $value->id }}">
                        <tr>
                           <td>
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ $reservation->mediaReservation }}">{{ $reservation->mediaReservation }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" id="totalRoomReserved{{ $value->typeOfRoom }}" name="totalRoomReserved[]" class="form-control" value="{{ $value->totalRoomReserved }}" required>

                              <input type="hidden" name="" id="totalRoomReserved{{ $value->typeOfRoom }}DefaultHidden" value="{{ $value->totalRoomReserved }}">
                           </td>
                           <td>
                              <select name="rooms[]" id="typeRoom" class="form-control" required>
                                 <option value="{{ $value->typeOfRoom }}">{{ $value->typeOfRoom }}</option>
                              </select>
                           </td>
                           <td><input type="number" class="form-control" id="roomRate" name="roomRate[]" value="{{ $value->roomRate }}"></td>
                           <td>
                              <input type="number" name="discount[]" style="width:100px;" class="form-control" value="{{ $value->discount }}" id="">%
                           </td>
                           <td>
                              <a href="#" class="btn btn-danger removeData" data-id="{{ $value->id }}"><i class="fa fa-trash"></i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     <tbody style="background:#2ecc71;">
                        <input type="hidden" name="idRooms">
                        <tr>
                           <td>
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ $reservation->mediaReservation }}">{{ $reservation->mediaReservation }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" id="NewTotalRoomReserved" name="totalRoomReserved[]" class="form-control" value="" required>
                           </td>
                           <td>
                              <select name="rooms[]" id="NewTypeRoom" class="form-control" required>
                                 <option value=""></option>
                                 <option value="standart">STANDART</option>
                                 <option value="superior">SUPERIOR</option>
                                 <option value="deluxe">DELUXE</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" class="form-control" id="newRoomRate" name="roomRate[]" value="">
                           </td>
                           <td rowspan="2">
                              <input type="number" name="discount[]" style="width:100px;" class="form-control" value="" id="">%
                           </td>
                        </tr>
                     </tbody>
                     <thead>
                        <tr style="background:lightblue;">
                           <td>Total Room Reserved</td>
                           <td>Type Of Room</td>
                           <td>Room rate</td>
                           <td colspan="2">Action</td>
                        </tr>
                     </thead>
                     <tfoot class="rowExtraBad">
                        @if(empty($extraBad))
                        <tr style="background:lightblue;">
                           <td>
                              <input type="number" id="form1" name="totalRoomReserved[]" class="form-control" value="" required>
                           </td>
                           <td>
                              <select name="rooms[]" id="form2" class="form-control" required>
                                 <option value="extraBad">Extra Bad</option>
                              </select>
                           </td>
                           <td><input type="number" class="form-control" id="form3" name="roomRate[]" value=""></td>
                           <td colspan="2">
                              <center>
                                 <a href="#" class="btn btn-danger removeExtraBad"><i class="fa fa-times"></i></a>
                              </center>
                           </td>
                        </tr>
                        @endif
                     </tfoot>
                  </table>
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Method Payment</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Deposit</label>
                  <input type="number" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." value="{{ $reservation->deposit }}" autocomplete="off">
                  @error('deposit')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Method Payment</label>
                        <select name="methodPayment" id="" class="form-control @error('methodPayment') is-invalid @enderror">
                           <option value="{{ $reservation->methodPayment }}">{{ $reservation->methodPayment }}</option>
                           <option value=""></option>
                           <option value="cash">Cash</option>
                           <option value="transfer">Transfer</option>
                           <option value="debit">Debit</option>
                           <option value="credit">Credit</option>
                        </select>
                        @error('methodPayment')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Number</label>
                        <input type="number" class="form-control @error('numberAccount') is-invalid @enderror" name="numberAccount" placeholder="Number Account..." value="{{ $reservation->numberAccount }}" autocomplete="off">
                        @error('numberAccount')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Another Contact</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Contact Person</label>
                  <input type="number" name="contactPerson" class="form-control @error('contactPerson') is-invalid @enderror" placeholder="Contact Person..." autocomplete="off" value="{{ $reservation->contactPerson }}">
                  @error('contactPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <label for="">Address/Phone</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address..." autocomplete="off" value="{{ $reservation->address }}">
                  @error('address')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Estimate Arrivale</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Estimate Arrival</label>
                  <input type="time" name="estimateArrivale" class="form-control @error('estimateArrivale') is-invalid @enderror" placeholder="Estimate Arrival..." autocomplete="off" value="{{ $reservation->estimateArrivale }}">
                  @error('estimateArrivale')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Request</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Request</label>
                  <textarea name="specialRequest" id="" cols="0" rows="4" class="form-control @error('specialRequest') is-invalid @enderror" placeholder="Request...">{{ $reservation->specialRequest }}</textarea>
                  @error('specialRequest')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>

            <div class="card card-success">
               <div class="card-header">
                  <h3 class="card-title">
                     Finally
                  </h3>
               </div>
               <div class="card-body">
                  <div class="form-group">
                     <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" value="confirm" name="status" checked>
                        <label for="customRadio1" class="custom-control-label">Confirm</label>
                     </div>
                     <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" value="tentative" name="status">
                        <label for="customRadio2" class="custom-control-label">tentative</label>
                     </div>
                     <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio3" value="changed" name="status">
                        <label for="customRadio3" class="custom-control-label">Changed</label>
                     </div>
                  </div>
                  <div class="col-sm-6 mt-3">
                     <button class="btn btn-success" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </form>
         {{-- BATAS --}}
      </div>
   </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!--- Sweet alert -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme/bootstrap-4.min.css') }}">
@endpush

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
   $(function() {
      $('.multiSelect').select2({
         theme: 'bootstrap4'
      })
   });

   $('.addExtraBad').on('click', function(){
      addExtraBad();
   });

   function addExtraBad(){
      let tr = `
         <tr style="background:lightblue;">
            <td>
               <input type="number" id="form1" name="totalRoomReserved[]" class="form-control" value="" required>
            </td>
            <td>
               <select name="rooms[]" id="form2" class="form-control" required>
                  <option value="extraBad">Extra Bad</option>
               </select>
            </td>
            <td><input type="number" class="form-control" id="form3" name="roomRate[]" value=""></td>
            <td colspan="2">
               <center>
                  <a href="#" class="btn btn-danger removeExtraBad"><i class="fa fa-times"></i></a>
               </center>
            </td>
         </tr>
      `;
      $('.rowExtraBad').append(tr);
   }

   $('.removeExtraBad').live('click', function() {
      var removeExtraBad = $('tfoot tr');
      removeExtraBad.remove();
   });

   $('.removeData').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data("id");
         $.ajax({
            type: "GET"
            , url: "/reservation/deleteRoomArragement/" + id
            , data: {
               "id": id
               , "_method": 'DELETE'
               , "_token": "{{ csrf_token() }}"
            },

            success: function(data) {
               Swal.fire('Erase Data!', 'Data has been deleted', 'success')
               location.reload(true);
            }
         });
      } else {
         return false
      }
   });

   $(document).ready(function(){
      //STANDART
      $('#totalRoomReservedStandart').change(function(){
         let totalRoomReservedStandart = $(this).val();
         let totalRoomReservedStandartDefaultHidden = $('#totalRoomReservedStandartDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         $.ajax({
            type: "POST",
            url: "{{ route('reservation.checkAvailableRoomStandart.totalRoomReserved') }}",
            data: {
               "_token": "{{ csrf_token() }}",
               "totalRoomReserved": totalRoomReservedStandart,
               "typeRoom": typeRoom 
            },
            beforeSend: function(){
               $("#totalRoomReservedStandart").css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
            },
            dataType: 'json',
            success: function(data){
               if(data.success === true){
                  alert(data.message);
                  $('#totalRoomReservedStandart').val(totalRoomReservedStandartDefaultHidden);
                  $("#totalRoomReservedStandart").removeClass('is-valid');
                  $("#totalRoomReservedStandart").addClass('is-invalid');
                  $("#totalRoomReservedStandart").css("background","#FFF");
               }else if(data.success === false) {
                  alert(data.message);
                  $("#totalRoomReservedStandart").css("background","#FFF");
                  $("#totalRoomReservedStandart").removeClass('is-invalid');
                  $("#totalRoomReservedStandart").addClass('is-valid');
               }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
         });
      });

      //SUPERIOR
      $('#totalRoomReservedSuperior').change(function(){
         let totalRoomReservedSuperior = $(this).val();
         let totalRoomReservedSuperiorDefaultHidden = $('#totalRoomReservedSuperiorDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         $.ajax({
            type: "POST",
            url: "{{ route('reservation.checkAvailableRoomSuperior.totalRoomReserved') }}",
            data: {
               "_token": "{{ csrf_token() }}",
               "totalRoomReserved": totalRoomReservedSuperior,
               "typeRoom": typeRoom 
            },
            beforeSend: function(){
               $("#totalRoomReservedSuperior").css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
            },
            dataType: 'json',
            success: function(data){
               if(data.success === true){
                  alert(data.message);
                  $('#totalRoomReservedSuperior').val(totalRoomReservedSuperiorDefaultHidden);
                  $("#totalRoomReservedSuperior").removeClass('is-valid');
                  $("#totalRoomReservedSuperior").addClass('is-invalid');
                  $("#totalRoomReservedSuperior").css("background","#FFF");
               }else if(data.success === false) {
                  alert(data.message);
                  $("#totalRoomReservedSuperior").css("background","#FFF");
                  $("#totalRoomReservedSuperior").removeClass('is-invalid');
                  $("#totalRoomReservedSuperior").addClass('is-valid');
               }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
         });
      });

      //DELUXE
      $('#totalRoomReservedDeluxe').change(function(){
         let totalRoomReservedDeluxe = $(this).val();
         let totalRoomReservedDeluxeDefaultHidden = $('#totalRoomReservedDeluxeDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         $.ajax({
            type: "POST",
            url: "{{ route('reservation.checkAvailableRoomDeluxe.totalRoomReserved') }}",
            data: {
               "_token": "{{ csrf_token() }}",
               "totalRoomReserved": totalRoomReservedDeluxe,
               "typeRoom": typeRoom 
            },
            beforeSend: function(){
               $("#totalRoomReservedDeluxe").css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
            },
            dataType: 'json',
            success: function(data){
               if(data.success === true){
                  alert(data.message);
                  $('#totalRoomReservedDeluxe').val(totalRoomReservedDeluxeDefaultHidden);
                  $("#totalRoomReservedDeluxe").removeClass('is-valid');
                  $("#totalRoomReservedDeluxe").addClass('is-invalid');
                  $("#totalRoomReservedDeluxe").css("background","#FFF");
               }else if(data.success === false) {
                  alert(data.message);
                  $("#totalRoomReservedDeluxe").css("background","#FFF");
                  $("#totalRoomReservedDeluxe").removeClass('is-invalid');
                  $("#totalRoomReservedDeluxe").addClass('is-valid');
               }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
         });
      });

      //TAMBAH KAMAR BARU
      $('#NewTotalRoomReserved').change(function(){
         let NewTotalRoomReserved = $(this).val();
         let typeRoom = $('#NewTypeRoom option:selected').val();

         console.log(typeRoom);

         $.ajax({
            type: "POST",
            url: "{{ route('reservation.checkAvailableRoom.totalRoomReserved') }}",
            data: {
               "_token": "{{ csrf_token() }}",
               "totalRoomReserved": NewTotalRoomReserved,
               "typeRoom": typeRoom
            },
            beforeSend: function(){
               $('#NewTotalRoomReserved').css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
            },
            dataType: 'json',
            success: function(data){
               if(data.success === true){
                  alert(data.message);
                  $('#NewTotalRoomReserved').val('');
                  $("#NewTotalRoomReserved").removeClass('is-valid');
                  $("#NewTotalRoomReserved").addClass('is-invalid');
                  $("#NewTotalRoomReserved").css("background","#FFF");
               }else if(data.success === false) {
                  alert(data.message);
                  $("#NewTotalRoomReserved").css("background","#FFF");
                  $("#NewTotalRoomReserved").removeClass('is-invalid');
                  $("#NewTotalRoomReserved").addClass('is-valid');
               }
            },
            error: function(jqXHR, textStatus, errorThrown){}
         });
      });
   });
</script>
@endpush
