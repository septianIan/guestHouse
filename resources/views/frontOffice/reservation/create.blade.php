@extends('frontOffice.template.ui')
@section('title', 'Create Individual Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/{{ request()->segment(1) }}">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Create Individual Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('reservation.reservation.store') }}" method="post">
            @csrf
            {{-- Guest name --}}
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Create Individual Reservation</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Guest Name</label>
                  <input type="text" name="guestName" class="form-control @error('guestName') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ old('guestName') }}">
                  @error('guestName')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Arrivale Date</label>
                  <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" autocomplete="off" value="{{ old('arrivaleDate') }}" required>
                  @error('arrivaleDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Departure Date</label>
                  <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" placeholder="Departure Date..." autocomplete="off" value="{{ old('departureDate') }}" required>
                  @error('departureDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
            {{-- Room Arragement --}}
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Rooms Arragement</h3>
                  <a href="#" class="addExtraBad ml-2 btn btn-warning btn-xs"><i class="fa fa-plus px-1"></i>Extra bad</a>
               </div>
               <div class="card-body">
                  {{-- ROOMS --}}
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Media Of Reservation</th>
                           <th>Total Room Reserved</th>
                           <th>Total Pax</th>
                           <th>Type Of Room</th>
                           <th>Room rate</th>
                        </tr>
                     </thead>
                     <tbody>
                     {{-- Standart --}}
                        <tr>
                           <td rowspan="3">
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ old('mediaReservation') }}">{{ old('mediaReservation') }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" id="totalRoomReservedStandart" name="totalRoomReserved[]" class="form-control">
                           </td>
                           <td>
                              <input type="number" id="totalPax" name="totalPax[]" class="form-control">
                           </td>
                           <td>
                              <select name="rooms[]" id="typeRoom" class="form-control">
                                 <option value="standart">STANDARD</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" name="roomRate[]" class="form-control" value="{{ $roomRateStandart->price }}">
                           </td>
                        </tr>
                        {{-- Superior --}}
                        <tr>
                           <td>
                              <input type="number" id="totalRoomReservedSuperior" name="totalRoomReserved[]" class="form-control">
                           </td>
                           <td>
                              <input type="number" id="totalPax" name="totalPax[]" class="form-control">
                           </td>
                           <td>
                              <select name="rooms[]" id="typeRoom" class="form-control">
                                 <option value="superior">SUPERIOR</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" name="roomRate[]" class="form-control" value="{{ $roomRateSuperior->price }}">
                           </td>
                        </tr>
                        {{-- Deluxe --}}
                        <tr>
                           <td>
                              <input type="number" id="totalRoomReservedDeluxe" name="totalRoomReserved[]" class="form-control">
                           </td>
                           <td>
                              <input type="number" id="totalPax" name="totalPax[]" class="form-control">
                           </td>
                           <td>
                              <select name="rooms[]" id="typeRoom" class="form-control">
                                 <option value="deluxe">DELUXE</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" name="roomRate[]" class="form-control" value="{{ $roomRateDeluxe->price }}">
                           </td>
                        </tr>
                     </tbody>
                     {{-- EXTRABED --}}
                     <thead>
                        <tr style="background:lightblue;">
                           <td>Total Room Reserved</td>
                           <td>Type Of Room</td>
                           <td>Room rate</td>
                           <td colspan="2">Action</td>
                        </tr>
                     </thead>
                     <tfoot class="rowExtraBad">
                        <tr style="background:lightblue;">
                           <td>
                              <input type="number" id="form1" name="totalRoomReserved[]" class="form-control" value="" required>
                           </td>
                           <td>
                              <select name="rooms[]" id="form2" class="form-control" required>
                                 <option value="extraBad">Extra Bed</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" class="form-control" name="roomRate[]" value="">

                              <input type="hidden" name="discount[]" style="width:100px;" class="form-control" id="">
                           </td>
                           <td colspan="2">
                              <center>
                                 <a href="#" class="btn btn-danger removeExtraBad"><i class="fa fa-times"></i></a>
                              </center>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
            {{-- Method payment --}}
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
                  <input type="number" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." value="{{ old('deposit') }}" autocomplete="off" required>
                  @error('deposit')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Method Payment</label>
                        <select name="methodPayment" id="" class="form-control @error('methodPayment') is-invalid @enderror" required>
                           <option value="{{ old('methodPayment') }}">{{ old('methodPayment') }}</option>
                           <option value=""></option>
                           <option value="cash">Cash</option>
                           <option value="transfer">Transfer</option>
                           <option value="transfer">Debit</option>
                           <option value="transfer">Credit</option>
                        </select>
                        @error('methodPayment')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Number</label>
                        <input type="number" class="form-control @error('numberAccount') is-invalid @enderror" name="numberAccount" placeholder="Number Account..." value="{{ old('numberAccount') }}" autocomplete="off" required>
                        @error('numberAccount')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
               </div>
            </div>
            {{-- Another contact --}}
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
                  <input type="text" name="contactPerson" class="form-control @error('contactPerson') is-invalid @enderror" placeholder="Contact Person..." autocomplete="off" value="{{ old('contactPerson') }}" required>
                  @error('contactPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <label for="">Address/Phone</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address..." autocomplete="off" value="{{ old('address') }}" required>
                  @error('address')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
            {{-- Estimate arrivale --}}
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
                  <input type="time" name="estimateArrivale" class="form-control @error('estimateArrivale') is-invalid @enderror" placeholder="Estimate Arrival..." autocomplete="off" value="{{ old('estimateArrivale') }}" required>
                  @error('estimateArrivale')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
            {{-- Spec req --}}
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
                  <textarea name="specialRequest" id="" cols="0" rows="4" class="form-control @error('specialRequest') is-invalid @enderror" placeholder="Request...">{{ old('specialRequest') }}</textarea>
                  @error('specialRequest')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
            {{-- Submit --}}
            <div class="card card-success">
               <div class="card-header">
                  <h3 class="card-title">
                     Finally
                  </h3>
               </div>
               <div class="card-body">
                  <div class="col-sm-6">
                     <label for="">Status Reservation ?</label>
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
                  </div>
                  <div class="col-sm-6 mt-3">
                     <input type="text" name="clerk" value="{{ auth()->user()->name }}">
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
@endpush

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
   $(function() {
      $('.multiSelect').select2({
         theme: 'bootstrap4'
      })
   })

   $('.addExtraBad').on('click', function(){
      addExtraBad();
   })

   $('.removeExtraBad').live('click', function() {
      var removeExtraBad = $('tfoot tr');
      //element.parentNode.removeChild(removeExtraBad);
      removeExtraBad.remove();
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

   $(document).ready(function(){
      //standart
      $('#totalRoomReservedStandart').change(function(){
         let totalRoomReservedStandart = $(this).val();
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
                  $('#totalRoomReservedStandart').val('');
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

      //superior
      $('#totalRoomReservedSuperior').change(function(){
         let totalRoomReservedSuperior = $(this).val();
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
                  $('#totalRoomReservedSuperior').val('');
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
                  $('#totalRoomReservedDeluxe').val('');
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
   });

</script>
@endpush
