@extends('frontOffice.template.ui')
@section('title', 'Edit Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Edit Reservation</li>
</ol>
@endsection

@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">
                  Edit Reservation
               </h3>
               <div class="card-tools">
                  <button class="btn btn-tool" type="button" data-card-widget="collapse" data-toggle="tooltip" title="Edit Reservation"><i class="fas fa-minus"></i></button>
               </div>
            </div>
            <div class="card-body">
               <form action="{{ route('reservation.reservation.update', $reservation) }}" method="post">
                  @csrf
                  @method('put')
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Guest Name</label>
                        <input type="text" name="guestName" class="form-control @error('guestName') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ $reservation->guestName }}">
                        @error('guestName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Method Payment</label>
                        <select name="methodPayment" id="" class="form-control @error('methodPayment') is-invalid @enderror">
                           <option value="{{ $reservation->methodPayment }}">{{ $reservation->methodPayment }}</option>
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
                        <label for="">Arrival Date</label>
                        <input type="date" name="arrivaleDate" class="form-control @error('arrivaleDate') is-invalid @enderror" placeholder="Arrival Date..." autocomplete="off" value="{{ $reservation->arrivaleDate }}">
                        @error('arrivalDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Deposit</label>
                        <input type="number" name="deposit" class="form-control @error('deposit') is-invalid @enderror" placeholder="Guest Name..." autocomplete="off" value="{{ $reservation->deposit }}">
                        @error('deposit')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Departure Date</label>
                        <input type="date" name="departureDate" class="form-control @error('departureDate') is-invalid @enderror" placeholder="Departure Date..." autocomplete="off" value="{{ $reservation->departureDate }}">
                        @error('departureDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>

                     <div class="col-sm-6">
                        <label for="">Contact Person</label>
                        <input type="number" name="contactPerson" class="form-control @error('contactPerson') is-invalid @enderror" placeholder="Contact Person..." autocomplete="off" value="{{ $reservation->contactPerson }}">
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
                           <option value="{{ $reservation->mediaReservation }}">{{ $reservation->mediaReservation }}</option>
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
                        <label for="">Name Person</label>
                        <input type="text" name="namePerson" class="form-control @error('namePerson') is-invalid @enderror" placeholder="Name Person..." autocomplete="off" value="{{ $reservation->namePerson }}">
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
                     {{-- <div class="col-sm-6">
                        <div class="form-group">
                           <label for="">Number room</label><br>
                           <button type="button" class="btn btn-default bg-maroon toastsDefaultMaroon" data-toggle="modal" data-target="#modal-lg">
                              Edit Room
                           </button>
                           {{-- <select name="numberRoom[]" id="" class="form-control @error('numberRoom') is-invalid @enderror multiSelect" multiple>
                              <option value="">Pilih</option>
                              <option value=""></option>
                              @foreach($rooms as $room)
                              <option value="{{ $room->id }}" @if($reservation->rooms->contains($room))selected="selected" @endif>
                                 {{ $room->numberRoom }}
                              </option>
                              @endforeach
                           </select> 
                           @error('numberRoom')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div> --}}

                     <div class="col-sm-6">
                        <label for="">Estimate Arrival</label>
                        <input type="time" name="estimateArrivale" class="form-control @error('estimateArrival') is-invalid @enderror" placeholder="Estimate Arrival..." autocomplete="off" value="{{ $reservation->estimateArrivale }}">
                        @error('estimateArrivale')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>


                     <div class="col-sm-6">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control @error('namePerson') is-invalid @enderror" placeholder="Address..." autocomplete="off" value="{{ $reservation->address }}">
                        @error('address')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-12">
                        <label for="">Request</label>
                        <textarea name="specialRequest" id="" cols="0" rows="4" class="form-control @error('specialRequest') is-invalid @enderror" placeholder="Request...">{{ $reservation->specialRequest }}</textarea>
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
         {{-- Card edit rooms --}}
         <div class="card card-secondary">
            <div class="card-header">
               <h3 class="card-title">
                  Edit Room
               </h3>
               <div class="card-tools">
                  <button class="btn btn-tool" type="button" data-card-widget="collapse" data-toggle="tooltip" title="Edit Reservation"><i class="fas fa-minus"></i></button>
               </div>
            </div>
            <div class="card-body p-2">
               <div class="row">
                  <div class="col-sm-6">
                     <table class="table table-active">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Type room</th>
                              <th>Number room</th>
                              <th>Action</th>
                           </tr>
                           <tbody>
                              @foreach($reservation->rooms as $room)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $room->roomType }}</td>
                                    <td>{{ $room->numberRoom }}</td>
                                    <td>
                                       <form action="{{ route('reservation.edit.room', $reservation->id) }}">
                                       @method('DELETE')
                                       @csrf
                                          <input type="hidden" name="idRoom" value="{{ $room->numberRoom }}">
                                          <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                       </form>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </thead>
                     </table>
                  </div>
                  <div class="col-sm-6">
                     <p>Add room for <b>{{ $reservation->guestName }}</b></p>
                     <form action="{{ route('reservation.addNew.room', $reservation->id) }}">
                        <label for="">Rooms</label>
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
                        <button type="submit" class="btn btn-secondary mt-2 mb-3">Submit</button>
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
   })

</script>
@endpush
