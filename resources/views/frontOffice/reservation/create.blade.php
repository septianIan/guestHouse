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
                  <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" autocomplete="off" value="{{ old('arrivaleDate') }}">
                  @error('arrivaleDate')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror

                  <label for="">Departure Date</label>
                  <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" placeholder="Departure Date..." autocomplete="off" value="{{ old('departureDate') }}">
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
                  <a href="#" class="addRow ml-2"><i class="fa fa-plus px-1"></i>Add Room Arragement</a>
                  <a href="#" class="addExtraBad ml-2"><i class="fa fa-plus px-1"></i>Add Extra bad</a>
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
                           <td></td>
                        </tr>
                     </tbody>
                     <tfoot class="rowExtraBad">
                        <td></td>
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
                  <input type="number" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." value="{{ old('deposit') }}" autocomplete="off">
                  @error('deposit')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Method Payment</label>
                        <select name="methodPayment" id="" class="form-control @error('methodPayment') is-invalid @enderror">
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
                        <input type="number" class="form-control @error('numberAccount') is-invalid @enderror" name="numberAccount" placeholder="Number Account..." value="{{ old('numberAccount') }}" autocomplete="off">
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
                  <input type="number" name="contactPerson" class="form-control @error('contactPerson') is-invalid @enderror" placeholder="Contact Person..." autocomplete="off" value="{{ old('contactPerson') }}">
                  @error('contactPerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <label for="">Name Person</label>
                  <input type="text" name="namePerson" class="form-control @error('namePerson') is-invalid @enderror" placeholder="Name Person..." autocomplete="off" value="{{ old('namePerson') }}">
                  @error('namePerson')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
                  <label for="">Address/Phone</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address..." autocomplete="off" value="{{ old('address') }}">
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
                  <input type="time" name="estimateArrivale" class="form-control @error('estimateArrivale') is-invalid @enderror" placeholder="Estimate Arrival..." autocomplete="off" value="{{ old('estimateArrivale') }}">
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
                  <textarea name="specialRequest" id="" cols="0" rows="4" class="form-control @error('specialRequest') is-invalid @enderror" placeholder="Request...">{{ old('specialRequest') }}</textarea>
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

   $('.addRow').on('click', function() {
      addRow();
   });

   function addRow() {
      let tr = `
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
      $('tbody').append(tr);
   };

   $('.addExtraBad').on('click', function(){
      addExtraBad();
   })

   $('.removeExtraBad').live('click', function() {
      var removeExtraBad = $('tfoot tr');
      removeExtraBad.remove();
   });

   function addExtraBad(){
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
      var last = $('tbody').length;
      console.log(last);
      if (last < '15') {
         alert("you can not remove last row");
      } else {
         $(this).parent().parent().remove();
      }
   });

</script>
@endpush
