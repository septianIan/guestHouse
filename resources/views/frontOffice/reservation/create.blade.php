@extends('frontOffice.template.ui')
@section('title', 'Create Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Create Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">Create reservation</h3>
            </div>

            @if (session('error'))
            @alert(['type' => 'danger'])
            {!! session('error') !!}
            @endalert
            @endif

            <div class="card-body">
               <form action="{{ route('reservation.reservation.store') }}" method="post">
                  @csrf
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Guest Name</label>
                        <input type="text" name="guestName" class="form-control @error('guestName') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ old('guestName') }}">
                        @error('guestName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Method Payment</label>
                        <select name="methodPayment" id="" class="form-control @error('methodPayment') is-invalid @enderror">
                           <option value="{{ old('methodPayment') }}">{{ old('methodPayment') }}</option>
                           <option value=""></option>
                           <option value="cash">Cash</option>
                           <option value="transfer">Transfer</option>
                        </select>
                        @error('methodPayment')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Arrivale Date</label>
                        <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" autocomplete="off" value="{{ old('arrivaleDate') }}">
                        @error('arrivaleDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Deposit</label>
                           <input type="number" name="deposit" class="form-control @error('deposit') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ old('deposit') }}">
                           @error('deposit')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        @error('deposit')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Departure Date</label>
                        <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" placeholder="Departure Date..." autocomplete="off" value="{{ old('departureDate') }}">
                        @error('departureDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Contact Person</label>
                        <input type="number" name="contactPerson" class="form-control @error('contactPerson') is-invalid @enderror" placeholder="Contact Person..." autocomplete="off" value="{{ old('contactPerson') }}">
                        @error('contactPerson')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Media Reservation</label>
                        <select name="mediaReservation" id="" class="form-control @error('mediaReservation') is-invalid @enderror">
                           <option value="{{ old('mediaReservation') }}">{{ old('mediaReservation') }}</option>
                           <option value=""></option>
                           <option value="telephone">Telephone</option>
                           <option value="fax">Fax</option>
                        </select>
                        @error('mediaReservation')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control @error('namePerson') is-invalid @enderror" placeholder="Address..." autocomplete="off" value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="">Number room</label>
                           <select name="rooms[]" id="" class="form-control @error('rooms') is-invalid @enderror multiSelect" multiple>
                              <option value="">Pilih</option>
                              <option value=""></option>
                              @foreach($rooms as $room)
                              <option value="{{ $room->id }}"
                                 @if($room->status == 'O')
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

                     <div class="col-sm-6">
                        <label for="">Name Person</label>
                        <input type="text" name="namePerson" class="form-control @error('namePerson') is-invalid @enderror" placeholder="Name Person..." autocomplete="off" value="{{ old('namePerson') }}">
                        @error('namePerson')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        
                     </div>

                     <div class="col-sm-6">
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Estimate Arrival</label>
                        <input type="time" name="estimateArrivale" class="form-control @error('estimateArrivale') is-invalid @enderror" placeholder="Estimate Arrival..." autocomplete="off" value="{{ old('estimateArrivale') }}">
                        @error('estimateArrivale')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Request</label>
                        <textarea name="specialRequest" id="" cols="0" rows="4" class="form-control @error('specialRequest') is-invalid @enderror" placeholder="Request...">{{ old('specialRequest') }}</textarea>
                        @error('specialRequest')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
                  {{-- Batas --}}
                  <div class="card-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
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
   })

</script>
@endpush
