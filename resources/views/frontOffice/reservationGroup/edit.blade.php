@extends('frontOffice.template.ui')
@section('title', 'Edit Group Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservationGroup.index') }}">Data Group Reservation</a></li>
   <li class="breadcrumb-item">Edit Group Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
   <form action="{{ route('reservation.reservationGroup.update', $reservationGroup->id) }}" method="post">
      @method('put')
      @csrf
      <div class="row">
         {{-- Group name --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Step 1 | Group name</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Group Name</label>
                  <input type="text" name="groupName" class="form-control @error('groupName') is-invalid @enderror" value="{{ $reservationGroup->groupName }}">
                  @error('groupName')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Arrivale Date</label>
                  <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" value="{{ $reservationGroup->arrivaleDate }}">
                  @error('arrivaleDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Departure Date</label>
                  <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" value="{{ $reservationGroup->departureDate }}">
                  @error('departureDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
         </div>
         {{-- Room arragement --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Step 2 | Room arragement</h3>
                  <a href="#" class="addExtraBad ml-2 btn btn-warning btn-xs"><i class="fa fa-plus px-1"></i>Add Extra bad</a>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <td>Media Of Reservation</td>
                           <td>Total Room Reserved</td>
                           <td>Type Of Room</td>
                           <td>Room rate</td>
                           <td>Action</td>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($reservationGroup->groupReservationRooms as $value)

                        <input type="hidden" name="idRooms[]" value="{{ $value->id }}">
                        <tr>
                           <td>
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ $reservationGroup->mediaReservation }}">{{ $reservationGroup->mediaReservation }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" id="totalRoomReserved{{ $value->typeOfRoom }}" name="totalRoomReserved[]" class="form-control" value="{{ $value->totalRoomReserved }}" required>

                              {{-- Jumlah default room reserved --}}
                              <input type="hidden" name="" id="totalRoomReserved{{ $value->typeOfRoom }}DefaultHidden" value="{{ $value->totalRoomReserved }}">
                           </td>
                           <td>
                              <select name="rooms[]" id="typeRoom" class="form-control" required>
                                 <option value="{{ $value->typeOfRoom }}">{{ $value->typeOfRoom }}</option>
                              </select>
                           </td>
                           <td><input type="number" class="form-control" id="roomRate" name="roomRate[]" value="{{ $value->roomRate }}"></td>
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
                              <select name="mediaReservation" id="" class="form-control">
                                 <option value="{{ $reservationGroup->mediaReservation }}">{{ $reservationGroup->mediaReservation }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" id="NewTotalRoomReserved" name="totalRoomReserved[]" class="form-control" value="">
                           </td>
                           <td>
                              <select name="rooms[]" id="NewTypeRoom" class="form-control">
                                 <option value=""></option>
                                 <option value="standart">STANDART</option>
                                 <option value="superior">SUPERIOR</option>
                                 <option value="deluxe">DELUXE</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" class="form-control" id="newRoomRate" name="roomRate[]" value="">
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
         </div>
         {{-- Method payment --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Step 3 | Method payment</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-4">
                        <label for="">Personal account</label>
                        <select name="methodPayment" class="form-control @error('methodPayment') is-invalid @enderror" id="">
                           <option value="{{ $reservationGroup->methodPayment->methodPayment }}">{{ $reservationGroup->methodPayment->methodPayment }}</option>
                           <option value=""></option>
                           <option value="company">Company</option>
                           <option value="personal">Personal account</option>
                        </select>
                     </div>
                     @error('credimethodPaymenttCard')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
                  <div class="row">
                     <label for="">Deposit</label>
                     <input type="text" class="form-control is-invalid" name="deposit" placeholder="Deposit..." value="{{ $reservationGroup->methodPayment->deposit }}" autocomplete="off">
                     <div class="invalid-feedback">
                        Deposit is not blank
                     </div>

                     @if($reservationGroup->methodPayment->methodPayment == 'personal')
                        {{-- PERSONAL CONDITION --}}
                        <div class="col-sm-6">
                           <label for="">Credit card</label>
                           <select name="creditCard" class="form-control @error('creditCard') is-invalid @enderror" placeholder="Credit Crard">
                              <option value="{{ $reservationGroup->methodPayment->value1 }}">{{ $reservationGroup->methodPayment->value1 }}</option>
                              <option value=""></option>
                              <option value="debit">Debit</option>
                              <option value="credit">credit</option>
                           </select>
                           @error('creditCard')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Number Account</label>
                           <input type="number" class="form-control @error('numberAccount') is-invalid @enderror" name="numberAccount" placeholder="Number Account..." value="{{ $reservationGroup->methodPayment->value2 }}">
                           @error('numberAccount')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Other</label>
                           <input type="text" class="form-control @error('otherPersonal') is-invalid @enderror" name="otherPersonal" placeholder="Other..." value="{{ $reservationGroup->methodPayment->value3 }}">
                           @error('otherPersonal')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        {{-- via commpany account --}}
                        <div class="col-sm-6">
                           <label for="">Guarantee letter</label>
                           <input type="text" class="form-control @error('guarantee') is-invalid @enderror" placeholder="Guarantee letter..." name="guarantee" value="{{ old('guarantee') }}">
                           @error('guarantee')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                           <label for="">Voucher</label>
                           <input type="text" class="form-control @error('voucher') is-invalid @enderror" placeholder="Voucher..." name="voucher" value="{{ old('voucher') }}">
                           @error('voucher')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     @else
                        {{-- COMPANY --}}
                        <div class="col-sm-6">
                           <label for="">Credit card</label>
                           <select name="creditCard" class="form-control @error('creditCard') is-invalid @enderror" placeholder="Credit Crard">
                              <option value=""></option>
                              <option value="debit">Debit</option>
                              <option value="credit">credit</option>
                           </select>
                           @error('creditCard')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Number Account</label>
                           <input type="number" class="form-control @error('numberAccount') is-invalid @enderror" name="numberAccount" placeholder="Number Account..." value="{{ old('numberAccount') }}">
                           @error('numberAccount')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Other</label>
                           <input type="text" class="form-control @error('otherPersonal') is-invalid @enderror" name="otherPersonal" placeholder="Other..." value="{{ old('otherPersonal') }}">
                           @error('otherPersonal')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        {{-- via commpany account --}}
                        <div class="col-sm-6">
                           <label for="">Guarantee letter</label>
                           <input type="text" class="form-control @error('guarantee') is-invalid @enderror" placeholder="Guarantee letter..." name="guarantee" value="{{ $reservationGroup->methodPayment->value1 }}">
                           @error('guarantee')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                           <label for="">Voucher</label>
                           <input type="text" class="form-control @error('voucher') is-invalid @enderror" placeholder="Voucher..." name="voucher" value="{{ $reservationGroup->methodPayment->value2 }}">
                           @error('voucher')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         {{-- Contact person --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">
                     Step 4 | Contact person
                  </h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Contact person</label>
                  <input type="text" name="contactPerson" placeholder="Contact person..." class="form-control @error('contactPerson') is-invalid @enderror" value="{{ $reservationGroup->contactPerson }}">
                  @error('contactPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  
                  <label for="">Address person</label>
                  <input type="text" name="addressPerson" placeholder="Address person..." class="form-control @error('addressPerson') is-invalid @enderror" value="{{ $reservationGroup->addressPerson }}">
                  @error('addressPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>
         </div>
         {{-- Spec request --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Step 5 | Special request</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Special request</label>
                        <label for="">Other</label>
                        <input type="text" class="form-control" name="specialRequest" value="{{ $reservationGroup->specialRequest }}" placeholder="Other...">
                     </div>
                     <div class="col-sm-6">
                        <label for="">At time</label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" value="{{ $reservationGroup->atTime }}" name="atTime" value="addressPerson">
                        @error('addressPerson')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Rate</label>
                        <input type="number" name="rateRequest" class="form-control" value="{{ $reservationGroup->rateRequest }}">
                     </div>
                     <div class="col-sm-6">
                        <label for="">Flight number / Other</label>
                        <input type="text" name="flightNumber" class="form-control" value="{{ $reservationGroup->flightNumber }}">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         {{-- meal arragement --}}
         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">
                     Step 6 | Meal arragement
                  </h3>
                  <a href="#" class="addMeal px-1 ml-2 btn btn-warning btn-xs"><i class="fa fa-plus px-1"></i>Meal arragement</a>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  {{-- PROBLEM!!!!! --}}
                  @if(count($reservationGroup->meals) == null)
                     <div class="row addMeals">
                        <div class="col-sm-4" id="1">
                           <label for="">Meals</label>
                           <select name="meals[]" class="form-control" id="" required>
                              <option value=""></option>
                              @foreach($meals as $meal)
                                 <option value="{{ $meal->id }}">{{ $meal->type }}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-sm-4" id="2">
                           <label for="">Time</label>
                           <input type="time" name="timeMeal[]" class="form-control" required>
                        </div>
                        <div class="col-sm-4" id="3">
                           <label for="">Action</label><br>
                           <a href="#" class="btn btn-danger removeMealsArragement" style="display:inline"><i class="fa fa-times"></i></a>
                        </div>
                     </div>
                  @else
                     @foreach($reservationGroup->meals as $mealArragement)
                     <div class="row">
                        <div class="col-sm-4" id="">
                           <label for="">Meals</label>
                           <select name="meals[]" class="form-control" id="" required>
                              <option value="{{ $mealArragement->id }}">{{ $mealArragement->type }}</option>
                              <option value=""></option>
                              @foreach($meals as $meal)
                              <option value="{{ $meal->id }}">{{ $meal->type }}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-sm-4" id="">
                           <label for="">Time</label>
                           <input type="time" name="timeMeal[]" value="{{ $mealArragement->pivot->atTime }}" class="form-control" required>
                        </div>
                        <div class="col-sm-4" id="">
                           <label for="">Action</label><br>
                           
                           <input type="hidden" name="idMeals[]" value="{{ $mealArragement->pivot->id }}">

                           <a href="#" class="btn btn-danger deleteMealArragement" data-id="{{ $mealArragement->pivot->id }}" style="display:inline"><i class="fa fa-trash"></i></a>
                        </div>
                     </div>
                     @endforeach
                     <div class="row addMeals">
                        
                     </div>
                  @endif
               </div>
            </div>
         </div>
         {{-- Submit --}}
         <div class="col-md-12">
            <div class="card card-success">
               <div class="card-header">
                  <h3 class="card-title">
                     Finally
                  </h3>
               </div>
               <div class="card-body">
                  <div class="col-sm-6">
                     <label for="">Estimate arrivale</label>
                     <input type="time" name="estimateArrivale" class="@error('estimateArrivale') is-invalid @enderror form-control" value="{{ $reservationGroup->estimateArrivale }}">
                     @error('estimateArrivele')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
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
                     <input type="hidden" name="clerk" value="{{ auth()->user()->name }}">
                     <button class="btn btn-success" type="submit">Submit</button>
                  </div>
               </div>
            </div>
         </div>
         {{-- Batas --}}
      </div>
   </form>
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

!-- Sweet alert -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
   $(function() {
      $('.multiSelect').select2({
         theme: 'bootstrap4'
      })
   });

   $('.addMeal').on('click', function() {
      addMeal();
   })
   function addMeal() {
      let row = `
         <div class="col-sm-4" id="1">
            <label for="">Meals</label>
            <select name="meals[]" class="form-control" id="" required>
               <option value=""></option>
               @foreach($meals as $meal)
                  <option value="{{ $meal->id }}">{{ $meal->type }}</option>
               @endforeach
            </select>
         </div>
         <div class="col-sm-4" id="2">
            <label for="">Time</label>
            <input type="time" name="timeMeal[]" class="form-control" required>
         </div>
         <div class="col-sm-4" id="3">
            <label for="">Action</label><br>
            <a href="#" class="btn btn-danger removeMealsArragement" style="display:inline"><i class="fa fa-times"></i></a>
         </div>
      `;
      $('.addMeals').append(row);
   };

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

   $('.remove').live('click', function() {
      $(this).parent().parent().remove();
   });

   //delete ROOM
   $('.removeData').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data("id");
         $.ajax({
            type: "GET"
            , url: "/reservation/reservationGroup/deteleRoomArragement/"+id
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


   $('.removeMealsArragement').live('click', function() {
      $('#1').remove();
      $('#2').remove();
      $('#3').remove();
   });

   //Delete Meals
   $('.deleteMealArragement').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data("id");
         $.ajax({
            type: "GET"
            , url: "/reservation/reservationGroup/deleteMealArragementGroupReservation/"+id
            , data: {
               "id": id
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
      $('#totalRoomReservedstandart').change(function(){
         let totalRoomReservedStandart = $(this).val();
         let totalRoomReservedStandartDefaultHidden = $('#totalRoomReservedstandartDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         // jika jumlah kamar yang di pesan kurang dari kamar default
         if(totalRoomReservedStandart < totalRoomReservedStandartDefaultHidden){
            //jika jumlah kamar yang dipesan kurang dari nool
            if(totalRoomReservedStandart <= 0){
               alert('The total rooms booked cannot be below zero');
               $('#totalRoomReservedstandart').val(totalRoomReservedStandartDefaultHidden);
               return;
            }
            alert('Reduce the number of rooms booked');
            return;
         } else {
            $.ajax({
               type: "POST",
               url: "{{ route('reservation.checkAvailableRoomStandart.totalRoomReserved') }}",
               data: {
                  "_token": "{{ csrf_token() }}",
                  "totalRoomReserved": totalRoomReservedStandart,
                  "typeRoom": typeRoom 
               },
               beforeSend: function(){
                  $("#totalRoomReservedstandart").css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
               },
               dataType: 'json',
               success: function(data){
                  if(data.success === true){
                     alert(data.message);
                     $('#totalRoomReservedstandart').val(totalRoomReservedStandartDefaultHidden);
                     $("#totalRoomReservedstandart").removeClass('is-valid');
                     $("#totalRoomReservedstandart").addClass('is-invalid');
                     $("#totalRoomReservedstandart").css("background","#FFF");
                  }else if(data.success === false) {
                     alert(data.message);
                     $("#totalRoomReservedstandart").css("background","#FFF");
                     $("#totalRoomReservedstandart").removeClass('is-invalid');
                     $("#totalRoomReservedstandart").addClass('is-valid');
                  }
               },
               error: function(jqXHR, textStatus, errorThrown) {}
            });
         }
      });

      //SUPERIOR
      $('#totalRoomReservedsuperior').change(function(){
         let totalRoomReservedSuperior = $(this).val();
         let totalRoomReservedsuperiorDefaultHidden = $('#totalRoomReservedsuperiorDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         if(totalRoomReservedSuperior < totalRoomReservedsuperiorDefaultHidden){
            if(totalRoomReservedSuperior <= 0){
               alert('The total rooms booked cannot be below zero');
               $('#totalRoomReservedsuperior').val(totalRoomReservedsuperiorDefaultHidden);
               return;
            }
            alert('Reduce the number of rooms booked');
            return;
         } else {
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
                     $('#totalRoomReservedsuperior').val(totalRoomReservedsuperiorDefaultHidden);
                     $("#totalRoomReservedsuperior").removeClass('is-valid');
                     $("#totalRoomReservedsuperior").addClass('is-invalid');
                     $("#totalRoomReservedsuperior").css("background","#FFF");
                  }else if(data.success === false) {
                     alert(data.message);
                     $("#totalRoomReservedsuperior").css("background","#FFF");
                     $("#totalRoomReservedsuperior").removeClass('is-invalid');
                     $("#totalRoomReservedsuperior").addClass('is-valid');
                  }
               },
               error: function(jqXHR, textStatus, errorThrown) {}
            });
         }
      });

      //DELUXE
      $('#totalRoomReserveddeluxe').change(function(){
         let totalRoomReservedDeluxe = $(this).val();
         let totalRoomReservedDeluxeDefaultHidden = $('#totalRoomReserveddeluxeDefaultHidden').val();
         let typeRoom = $("#typeRoom option:selected").val();
         if(totalRoomReservedDeluxe < totalRoomReservedDeluxeDefaultHidden){
            if(totalRoomReservedDeluxe <= 0){
               alert('The total rooms booked cannot be below zero');
               $('#totalRoomReserveddeluxe').val(totalRoomReservedDeluxeDefaultHidden);
               return;
            }
            alert('Reduce the number of rooms booked');
            return;
         } else {
            $.ajax({
               type: "POST",
               url: "{{ route('reservation.checkAvailableRoomDeluxe.totalRoomReserved') }}",
               data: {
                  "_token": "{{ csrf_token() }}",
                  "totalRoomReserved": totalRoomReservedDeluxe,
                  "typeRoom": typeRoom 
               },
               beforeSend: function(){
                  $("#totalRoomReserveddeluxe").css("background","#FFF url({{ asset('assets/gif/loading3.gif') }}) no-repeat 60px");
               },
               dataType: 'json',
               success: function(data){
                  if(data.success === true){
                     alert(data.message);
                     $('#totalRoomReserveddeluxe').val(totalRoomReservedDeluxeDefaultHidden);
                     $("#totalRoomReserveddeluxe").removeClass('is-valid');
                     $("#totalRoomReserveddeluxe").addClass('is-invalid');
                     $("#totalRoomReserveddeluxe").css("background","#FFF");
                  }else if(data.success === false) {
                     alert(data.message);
                     $("#totalRoomReserveddeluxe").css("background","#FFF");
                     $("#totalRoomReserveddeluxe").removeClass('is-invalid');
                     $("#totalRoomReserveddeluxe").addClass('is-valid');
                  }
               },
               error: function(jqXHR, textStatus, errorThrown) {}
            });
         }
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
