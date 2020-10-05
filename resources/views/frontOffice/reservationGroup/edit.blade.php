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

         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Step 2 | Room arragement</h3>
                  <a href="#" class="addRoom ml-2"><i class="fa fa-plus px-1"></i>Add Room Arragement</a>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Number room | <a href="" data-toggle="modal" data-target="#modal-xl">Check Room</a></label>
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Media Information</th>
                           <th>Total Room Reserved</th>
                           <th>Type of Room</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr rowspan="1">
                           <td colspan="4">
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ $reservationGroup->mediaReservation}}">{{ $reservationGroup->mediaReservation }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                        </tr>
                        @foreach($reservationGroup->groupReservationRooms as $value)
                        <tr>
                           <td></td>
                           <td>
                              <input type="number" name="totalRoomReserved[]" class="form-control" value="{{ $value->totalRoomReserved }}" required>
                           </td>
                           <td>
                              <select name="rooms[]" id="" class="form-control" required>
                                 <option value="{{ $value->typeOfRoom }}">{{ $value->typeOfRoom }}</option>
                                 <option value=""></option>
                                 <option value="standart">STANDARD</option>
                                 <option value="superior">SUPERIOR</option>
                                 <option value="deluxe">DELUXE</option>
                              </select>
                           </td>
                           <td>
                              <a href="#" class="btn btn-danger delete" data-id="{{ $value->id }}"><i class="fa fa-trash"></i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

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
                  <label for="">Name person</label>
                  <input type="text" name="namePerson" placeholder="Name person..." class="form-control @error('namePerson') is-invalid @enderror" value="{{ $reservationGroup->namePerson }}">
                  @error('namePerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

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
                        <input type="text" class="form-control" value="{{ $reservationGroup->specialRequest }}" name="specialRequest" placeholder="Other...">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Cost</label>
                        <input type="number" name="costRequest" class="form-control" value="{{ $reservationGroup->costRequest }}">
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">
                     Step 6 | Meal arragement
                  </h3>
                  <a href="#" class="addMeal px-1"><i class="fa fa-plus px-1"></i>Add Meal arragement</a>
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
                     <div class="row addMeals">
                        <div class="col-sm-4" id="1">
                           <label for="">Meals</label>
                           <select name="meals[]" class="form-control" id="" required>
                              <option value="{{ $mealArragement->id }}">{{ $mealArragement->type }}</option>
                              <option value=""></option>
                              @foreach($meals as $meal)
                              <option value="{{ $meal->id }}">{{ $meal->type }}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-sm-4" id="2">
                           <label for="">Time</label>
                           <input type="time" name="timeMeal[]" value="{{ $mealArragement->pivot->atTime }}" class="form-control" required>
                        </div>
                        <div class="col-sm-4" id="3">
                           <label for="">Action</label><br>
                           <a href="#" class="btn btn-danger deleteMealArragement" data-id="{{ $mealArragement->pivot->id }}" style="display:inline"><i class="fa fa-trash"></i></a>
                        </div>
                     </div>
                     @endforeach
                  @endif
               </div>
            </div>
         </div>

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
                           <input class="custom-control-input" type="radio" id="customRadio1" value="1" name="status" checked>
                           <label for="customRadio1" class="custom-control-label">Confirm</label>
                        </div>
                        <div class="custom-control custom-radio">
                           <input class="custom-control-input" type="radio" id="customRadio2" value="2" name="status">
                           <label for="customRadio2" class="custom-control-label">tentative</label>
                        </div>
                        <div class="custom-control custom-radio">
                           <input class="custom-control-input" type="radio" id="customRadio3" value="3" name="status">
                           <label for="customRadio3" class="custom-control-label">Changed</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 mt-3">

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

   $('.addRoom').on('click', function() {
      addRoom();
   });

   $('.addMeal').on('click', function() {
      addMeal();
   })

   function addRoom() {
      let trAddRoom = `
         <tr>
            <td></td>
            <td>
               <input type="number" name="totalRoomReserved[]" id="1" class="form-control" required>
            </td>
            <td>
               <select name="rooms[]" id="2" class="form-control" required>
                  <option value=""></option>
                  <option value="standart">STANDARD</option>
                  <option value="superior">SUPERIOR</option>
                  <option value="deluxe">DELUXE</option>
               </select>
            </td>
            <td><a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a></td>
         </tr>
      `;
      $('tbody').append(trAddRoom);
   };

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

   $('.remove').live('click', function() {
      $(this).parent().parent().remove();
   });

   $('.delete').live('click', function() {
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

   $('.deleteMealArragement').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data("id");
         $.ajax({
            type: "GET"
            , url: "/reservation/reservationGroup/deleteRoomArragementGroupReservation/"+id
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

</script>
@endpush

@push('modals')
<div class="modal fade" id="modal-xl">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Extra Large Modal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>One fine body&hellip;</p>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
@endpush
