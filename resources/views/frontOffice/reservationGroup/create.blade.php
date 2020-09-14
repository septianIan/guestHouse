@extends('frontOffice.template.ui')
@section('title', 'Create Reservation Group')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Create Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
   <form action="{{ route('reservation.reservationGroup.store') }}" method="post">
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
                  <h3 class="card-title">Step 2 | Room selection</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <label for="">Number room | <a href="" data-toggle="modal" data-target="#modal-xl">Check Room</a></label>
                  <select name="rooms[]" value="{{ old('rooms[]') }}" class="form-control @error('rooms') is-invalid @enderror multiSelect" multiple>
                     <option value="">Pilih</option>
                     <option value=""></option>
                     @foreach($rooms as $room)
                     <option value="{{ $room->id }}" @if($room->status == 'O')
                        disabled
                        @endif>
                        {{ $room->numberRoom }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;| <u>{{ $room->roomType }} | {{ $room->status }}</u>
                     </option>
                     @endforeach
                  </select>
                  @error('rooms')
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
                  <h3 class="card-title">Step 3 | Method payment</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-5">
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
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Deposit</label>
                        <input type="text" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." value="{{ old('deposit') }}" autocomplete="off">
                        @error('deposit')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Credit card</label>
                        <input type="text" class="form-control @error('creditCard') is-invalid @enderror" name="creditCard" placeholder="Credit card..." value="{{ old('creditCard') }}">
                        @error('creditCard')
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
                        <label for="">Cost</label>
                        <input type="number" name="costRequest" class="form-control" value="{{ old('priceRequest') }}">
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
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <td>Meals</td>
                                 <td>Time at</td>
                                 <td>Action</td>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>
                                    <select name="meals[]" value="{{ old('meals[]') }}" class="form-control @error('meals') is-invalid @enderror">
                                       <option value=""></option>
                                       @foreach($meals as $meal)
                                       <option value="{{ $meal->id }}">
                                          {{ $meal->type }}
                                       </option>
                                       @endforeach
                                    </select>
                                 </td>
                                 <td><input type="time" name="timeMeal[]" class="form-control" id=""></td>
                                 <td><a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a></td>
                              </tr>
                           </tbody>
                        </table>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js">
</script>
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

   function addRow() {
      var tr = '<tr>' +
         '<td><select name="meals[]" value="{{ old('
      meals[]
      ') }}" class="form-control @error('
      meals ') is-invalid @enderror" ><option value=""></option>@foreach($meals as $meal)<option value="{{ $meal->id }}">{{ $meal->type }}</option>@endforeach\</select></td>' +
         '<td><input type="time" name="timeMeal[]" class="form-control" id=""></td>' +
         '<td><a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a></td>' +
         '</tr>';
      $('tbody').append(tr);
   };

   $('.remove').live('click', function() {
      var last = $('tbody tr').length;
      if (last==1) {
         alert("you can not remove last row");
      } else {
         $(this).parent().parent().remove();
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
