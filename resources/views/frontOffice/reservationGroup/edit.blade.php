@extends('frontOffice.template.ui')
@section('title', 'Edit Reservation group')
@section('breadcrumb')
   <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('reservation.reservationGroup.index') }}">Data Reservation</a></li>
      <li class="breadcrumb-item">Edit reservation group</li>
   </ol>
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Edit Reservation group</h3>
               </div>
               <div class="card-body">
                  <form action="{{ route('reservation.reservationGroup.update', $reservationGroup->id) }}" method="post">
                     @method('put')
                     @csrf
                     <div class="row">
                        <div class="col-sm-6">
                           <label for="">Group name</label>
                           <input type="text" name="groupName" class="form-control @error('groupName') is-invalid @enderror" value="{{ $reservationGroup->groupName }}">
                           @error('groupName')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                           

                           <label for="">Name Person</label>
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
                        <div class="col-sm-6">
                           <label for="">Arrivale date</label>
                           <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" value="{{ $reservationGroup->arrivaleDate }}">
                           @error('arrivaleDate')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Daperture date</label>
                           <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" value="{{ $reservationGroup->departureDate }}">
                           @error('departureDate')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror

                           <label for="">Estimate arrivale</label>
                           <input type="time" name="estimateArrivale" class="@error('estimateArrivale') is-invalid @enderror form-control" value="{{ $reservationGroup->estimateArrivale }}">
                           @error('estimateArrivele')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                           @enderror
                        </div>
                     </div>
                     {{-- step 1 --}}
                        <div class="row mt-2" style="border-top:solid 3px gray;">
                           <div class="col-sm-5">
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
                     @if($methodPayment->methodPayment == 'personal')
                        <div class="row mt-2">
                           <div class="col-sm-6">
                              <label for="">Deposit | <b style="color:red;">{{ $reservationGroup->methodPayment->value2 }}</b></label>
                              <input type="text" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." autocomplete="off">
                              @error('deposit')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror

                              <label for="">Credit card | <b style="color:red;">{{ $reservationGroup->methodPayment->value3 }}</b></label>
                              <input type="text" class="form-control @error('creditCard') is-invalid @enderror" name="creditCard" placeholder="Credit card..." >
                              @error('creditCard')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror

                              <label for="">Other | <b style="color:red;">{{ $reservationGroup->methodPayment->value4 }}</b></label>
                              <input type="text" class="form-control @error('otherPersonal') is-invalid @enderror" name="otherPersonal" placeholder="Other...">
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
                     @else
                        <div class="row mt-2">
                           <div class="col-sm-6">
                              <label for="">Deposit</label>
                              <input type="text" class="form-control @error('deposit') is-invalid @enderror" name="deposit" placeholder="Deposit..." value="" autocomplete="off">
                              @error('deposit')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror

                              <label for="">Credit card</label>
                              <input type="text" class="form-control @error('creditCard') is-invalid @enderror" name="creditCard" placeholder="Credit card..." value="">
                              @error('creditCard')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror

                              <label for="">Other</label>
                              <input type="text" class="form-control @error('otherPersonal') is-invalid @enderror" name="otherPersonal" placeholder="Other..." value="">
                              @error('otherPersonal')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror
                           </div>
                           {{-- via commpany account --}}
                           <div class="col-sm-6">
                              <label for="">Guarantee letter | <b style="color:red;">{{ $reservationGroup->methodPayment->value2 }}</b></label>
                              <input type="text" class="form-control @error('guarantee') is-invalid @enderror" placeholder="Guarantee letter..." name="guarantee">
                              @error('guarantee')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror
                              <label for="">Voucher | <b style="color:red;">{{ $reservationGroup->methodPayment->value3 }}</b></label>
                              <input type="text" class="form-control @error('voucher') is-invalid @enderror" placeholder="Voucher..." name="voucher">
                              @error('voucher')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror
                           </div>
                        </div>
                     @endif
                     
                     <button Type="submit" class="btn btn-success mt-1">Submit</button>
                     {{-- Batas step 1 --}}
                     <div class="row mt-2" style="border-top:solid 3px gray;">
                        <div class="col-sm-6">
                           <label for="">Special request</label>
                           <label for="">Other</label>
                           <input type="text" class="form-control" name="specialRequest" placeholder="Other..." value="{{ $reservationGroup->specialRequest }}">
                        </div>
                     
                        <div class="col-sm-6">
                           <label for="">Cost</label>
                           <input type="number" name="costRequest" class="form-control" value="{{ $reservationGroup->costRequest }}">
                        </div>
                     </div>
                  </form> 
                  
                     <div class="row mt-2" style="border-top:solid 3px gray;">
                        <div class="col-sm-6 mt-1">
                           <table class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <td>No</td>
                                    <td>Type</td>
                                    <td>Time</td>
                                    <td>Action</td>
                                 </tr>
                              </thead>
                              @foreach($reservationGroup->meals as $meal)
                                 <tbody>
                                    <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td>{{ $meal->type }}</td>
                                       <td>{{ $meal->pivot->atTime }}</td>
                                       <td>
                                          <form action="{{ route('reservation.deleteMeal.meal', $reservationGroup->id) }}">
                                          @method('DELETE')
                                          @csrf
                                             <input type="hidden" name="idMeal" value="{{ $meal->id }}">
                                             <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                          </form>
                                       </td>
                                    </tr>
                                 </tbody>
                              @endforeach
                           </table>
                        </div>
                        <div class="col-sm-6">
                        <form action="{{ route('reservation.addMeal.meal') }}" method="post">
                           @csrf
                           <label for="">Meal</label>
                           <select name="meals[]" value="{{ old('meals[]') }}" class="form-control @error('meals') is-invalid @enderror">
                              <option value=""></option>
                              @foreach($meals as $meal)
                              <option value="{{ $meal->id }}">
                                 {{ $meal->type }}
                              </option>
                              @endforeach
                           </select>
                              <div class="row">
                                 <div class="col-sm-3">
                                    <label for="">Time</label>
                                    <input type="time" name="timeMeal" class="form-control" id="">
                                 </div>
                                 <div class="col-sm-2"><br>
                                    <input type="hidden" name="id" value="{{ $reservationGroup->id }}">
                                    <button class="btn btn-secondary mt-2">Add</button>
                                 </div>
                              </div>
                        </form>
                        </div>
                     </div>
                     <div class="row mt-2" style="border-top:solid 3px gray">
                        <div class="col-sm-6 mt-1">
                           <table class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <td>No</td>
                                    <td>Type room</td>
                                    <td>Number room</td>
                                    <td>Action</td>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($reservationGroup->rooms as $room)
                                    <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td>{{ $room->roomType }}</td>
                                       <td>{{ $room->numberRoom }}</td>
                                       <td>
                                          <form action="{{ route('reservation.deleteRoom.room', $reservationGroup->id) }}">
                                             <input type="hidden" name="idRoom" value="{{ $room->id }}">
                                             <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                          </form>
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                        <div class="col-sm-6">
                           <form action="{{ route('reservation.addRoom.room') }}" method="post">
                              @csrf
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
                              <input type="hidden" name="id" value="{{ $reservationGroup->id }}">
                              <button type="submit" class="btn btn-secondary mt-3">Add</button>
                           </form>
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
   $(function() {
      $('.multiSelect').select2({
         theme: 'bootstrap4'
      })
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