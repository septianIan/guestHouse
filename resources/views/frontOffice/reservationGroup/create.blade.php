@extends('frontOffice.template.ui')
@section('title', 'Create Reservation Group')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservationGroup.index') }}">Data Group Reservation</a></li>
   <li class="breadcrumb-item active">Create Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
   <form action="{{ route('reservation.reservationGroup.store') }}" method="post" onSubmit="validate()">
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
                  <input type="text" name="groupName" class="form-control @error('groupName') is-invalid @enderror" value="{{ old('groupName') }}">
                  @error('groupName')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Arrivale Date</label>
                  <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" value="{{ old('arrivaleDate') }}">
                  @error('arrivaleDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Departure Date</label>
                  <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" value="{{ old('departureDate') }}">
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
                  <a href="#" class="addExtraBad ml-2"><i class="fa fa-plus px-1"></i>Add Extra bad</a>
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
                           <td>Media Of Reservation</td>
                           <td>Total Room Reserved</td>
                           <td>Type Of Room</td>
                           <td>Room rate</td>
                           <td>Action</td>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>
                              <select name="mediaReservation" id="" class="form-control" required>
                                 <option value="{{ old('mediaReservation') }}">{{ old('mediaReservation') }}</option>
                                 <option value=""></option>
                                 <option value="telephone">Telephone</option>
                                 <option value="fax">Fax</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" name="totalRoomReserved[]" class="form-control" value="" required>
                           </td>
                           <td>
                              <select name="rooms[]" class="form-control" required>
                                 <option value=""></option>
                                 <option value="standart">STANDARD</option>
                                 <option value="superior">SUPERIOR</option>
                                 <option value="deluxe">DELUXE</option>
                              </select>
                           </td>
                           <td>
                              <input type="number" name="roomRate[]" class="form-control" required>
                           </td>
                           <td></td>
                        </tr>
                     </tbody>
                     <tfoot class="rowExtraBad">
                        <tr style="background:lightblue;">
                           <td></td>
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
                     </tfoot>
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
                     <div class="col-sm-6">
                        <label for="">Personal account</label>
                        <select name="methodPayment" class="form-control @error('methodPayment') is-invalid @enderror" id="">
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
                     <div class="col-sm-6">
                        <label for="">Deposit</label>
                        <input type="text" class="form-control is-invalid" name="deposit" placeholder="Deposit..." value="{{ old('deposit') }}" autocomplete="off">
                        <div class="invalid-feedback">
                           Deposit is not blank
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row">
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
                  <input type="text" name="namePerson" placeholder="Name person..." class="form-control @error('namePerson') is-invalid @enderror" value="{{ old('namePerson') }}">
                  @error('namePerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Contact person</label>
                  <input type="text" name="contactPerson" placeholder="Contact person..." class="form-control @error('contactPerson') is-invalid @enderror" value="{{ old('contactPerson') }}">
                  @error('contactPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Address person</label>
                  <input type="text" name="addressPerson" placeholder="Address person..." class="form-control @error('addressPerson') is-invalid @enderror" value="{{ old('addressPerson') }}">
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
                        <input type="text" class="form-control" name="specialRequest" placeholder="Other...">
                     </div>
                     <div class="col-sm-6">
                        <label for="">At time</label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" name="atTime" value="addressPerson">
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
                        <input type="number" name="rateRequest" class="form-control" value="{{ old('rateRequest') }}">
                     </div>
                     <div class="col-sm-6">
                        <label for="">Flight number / Other</label>
                        <input type="text" name="flightNumber" class="form-control" value="{{ old('flightNumber') }}">
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
                  <a href="#" class="addRow px-1"><i class="fa fa-plus px-1"></i>Add Meal arragement</a>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row addMeals">
                     <div class="col-sm-4" id="1">
                        <label for="">Meals</label>
                        <select name="meals[]" class="form-control">
                           <option value=""></option>
                           @foreach($meals as $meal)
                           <option value="{{ $meal->id }}">{{ $meal->type }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="col-sm-4" id="2">
                        <label for="">Time</label>
                        <input type="time" name="timeMeal[]" class="form-control">
                     </div>
                     <div class="col-sm-4" id="3">
                        <label for="">Action</label><br>
                        <a href="#" class="btn btn-danger removeMealsArragement" style="display:inline"><i class="fa fa-times"></i></a>
                     </div>
                  </div>
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
                     <input type="time" name="estimateArrivale" class="@error('estimateArrivale') is-invalid @enderror form-control" value="{{ old('estimateArrivale') }}">
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
   });

   $('.addRow').on('click', function() {
      addRow();
   });

   $('.addRoom').on('click', function() {
      addRoom();
   });

   $('.addExtraBad').on('click', function() {
      addExtraBad();
   });

   function addRoom() {
      let trAddRoom = `
         <tr>
            <td></td>
            <td>
               <input type="number" name="totalRoomReserved[]" class="form-control" required>
            </td>
            <td>
               <select name="rooms[]" class="form-control" required>
                  <option value=""></option>
                  <option value="standart">STANDARD</option>
                  <option value="superior">SUPERIOR</option>
                  <option value="deluxe">DELUXE</option>
               </select>
            </td>
            <td>
               <input type="number" name="roomRate[]" class="form-control" required>
            </td>
            <td><a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a></td>
         </tr>
      `;
      $('tbody').append(trAddRoom);
   };

   function addRow() {
      let row = `
         <div class="col-sm-4" id="1">
            <label for="">Meals</label>
            <select name="meals[]" class="form-control" required>
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

   function addExtraBad() {
      let tr = `
         <tr style="background:lightblue;">
            <td></td>
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

   $('.remove').live('click', function() {
      let last = $('tbody.tr').length;
      if (last > 0) {
         alert("you can not remove last row");
      } else {
         $(this).parent().parent().remove();
      }
   });

   $('.removeExtraBad').live('click', function() {
      var removeExtraBad = $('tfoot tr');
      removeExtraBad.remove();
   });

   $('.removeMealsArragement').live('click', function() {
      $('#1').remove();
      $('#2').remove();
      $('#3').remove();
   });

</script>
@endpush

@push('modals')
<div class="modal fade" id="modal-xl">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Rooms available</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               @foreach($rooms as $room)
               <div class="col-mb-3 col-sm-2 col-12">
                  @if($room->status == 'VR')
                  <div class="info-box bg-info">
                     <span class="info-box-icon"><i class="fa fa-check-square"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text">{{ $room->roomType }}</span>
                        <span class="info-box-number">{{ $room->numberRoom }}</span>
                     </div>
                  </div>
                  @elseif($room->status == 'O')
                  <div class="info-box bg-danger">
                     <span class="info-box-icon"><i class="fa fa-times"></i></span>
                     <div class="info-box-content">
                        <span class="info-box-text">{{ $room->roomType }}</span>
                        <span class="info-box-number">{{ $room->numberRoom }} </span>
                     </div>
                  </div>
                  @endif
               </div>
               @endforeach
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="button" class="btn btn-primary">Save changes</button>
      </div>
   </div>
</div>
@endpush
