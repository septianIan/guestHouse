@extends('frontOffice.template.ui')
@section('title', 'Edit Registration guest')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reception.registration.index') }}">Data Registration</a></li>
   <li class="breadcrumb-item active">Edit Registration guest</li>
</ol>
@endsection
@section('content')
<div class="container">

   @if(isset($guestReservation))
   <div class="row">
      <div class="col-lg-12">
         <div class="invoice p-3 mb-3">
            <div class="row">
               <div class="col-12">
                  <h4>
                     <i class="fa fa-info-circle"></i>
                     &nbsp;Detail Guest Reservation
                  </h4>
               </div>
            </div>
            <div class="row invoice-info">
               <div class="col-sm-3 invoice-col">
                  <address>
                     <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $guestReservation->reservation->guestName }} </font></strong><br>
                     Address : {{ $guestReservation->reservation->address }}<br>
                     Contact Person : {{ $guestReservation->reservation->contactPerson }}<br>
                     Name Person : {{ $guestReservation->reservation->namePerson }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation : </b>{{ $guestReservation->reservation->created_at }}
                  <address>
                     Arrivale Date : {{ $guestReservation->reservation->arrivaleDate }}<br>
                     Departure Date : {{ $guestReservation->reservation->departureDate }}<br>
                     Estimate Arrival Check in : {{ $guestReservation->reservation->estimateArrivale }}<br>
                     Email: info@almasaeedstudio.com
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Payment</b>
                  <address>
                     Method Payment : {{ $guestReservation->reservation->methodPayment }}<br>
                     Deposit : {{ number_format($guestReservation->reservation->deposit, 0, ',', '.') }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Booked Room</b>
                  <address>
                     @foreach($guestReservation->reservation->individualReservationRooms as $value)
                     Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                     <b>{{ $value->typeOfRoom }}</b>
                     @endforeach
                     Stay : {{ $difference }} night
                  </address>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endif

   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('reception.registration.update' ,$registration->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Edit Registration guest</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">First name</label>
                        <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" placeholder="First name..." autocomplete="off" value="{{ $registration->firstName }}">
                        @error('firstName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Nationality</label>
                        <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" placeholder="Nationality..." autocomplete="off" value="{{ $registration->nationality }}">
                        @error('nationality')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Occupation</label>
                        <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" placeholder="Occupation..." autocomplete="off" value="{{ $registration->occupation }}">
                        @error('occupation')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Last name</label>
                        <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" placeholder="Last name..." autocomplete="off" value="{{ $registration->lastName }}">
                        @error('lastName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Passport</label>
                        <input type="number" name="passport" class="form-control @error('passport') is-invalid @enderror" placeholder="Passport..." autocomplete="off" value="{{ $registration->passport }}">
                        @error('passport')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Date of Birth</label>
                        <input type="date" name="dateBirth" class="form-control @error('dateBirth') is-invalid @enderror" autocomplete="off" value="{{ $registration->dateBirth }}">
                        @error('dateBirth')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
                  <label for="">Home address</label>
                  <textarea name="homeAddress" id="" cols="15" class="form-control" rows="3">{{ $registration->homeAddress }}</textarea>
                  @error('homeAdrress')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title"></h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">Company</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" placeholder="Company..." value="{{ $registration->company }}" autocomplete="off">
                        @error('company')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Arrivale date</label>
                        <input type="date" class="form-control @error('arrivaleDate') is-invalid @enderror" name="arrivaleDate" placeholder="Arrivale date..." value="{{ $registration->arrivaleDate }}" autocomplete="off">
                        @error('arrivaleDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Departure date</label>
                        <input type="date" class="form-control @error('departureDate') is-invalid @enderror" name="departureDate" value="{{ $registration->departureDate }}" autocomplete="off">
                        @error('departureDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Purpose of visit</label>
                        <input type="text" class="form-control @error('purpose') is-invalid @enderror" name="purpose" placeholder="purpose of visit..." value="{{ $registration->purpose }}" autocomplete="off">
                        @error('purpose')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Comming form</label>
                        <input type="text" class="form-control @error('comingFrom') is-invalid @enderror" name="comingFrom" placeholder="Coming from..." value="{{ $registration->comingFrom }}" autocomplete="off">
                        @error('comingFrom')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Next destination</label>
                        <input type="text" class="form-control @error('nextDestination') is-invalid @enderror" name="nextDestination" placeholder="Next destination..." value="{{ $registration->nextDestination }}" autocomplete="off">
                        @error('nextDestination')
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
                  <h3 class="card-title">Term of payment</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-5">
                        <select name="termOfPayment" class="form-control" id="test" onchange="showDiv(this)">
                           <option value="{{ $registration->termOfPayment }}">{{ $registration->termOfPayment }}</option>
                           <option value=""></option>
                           <option value="cash">Cash/Travel cheque</option>
                           <option value="creditCard">Credit card</option>
                           <option value="companyAccount">Company account</option>
                           <option value="travelAccount">Travel account</option>
                        </select>
                     </div>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" value="{{ $registration->numberAccount }}" name="numberAccount">
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-12">
                  <div class="invoice p-3 mb-3">
                     <div class="row">
                        <div class="col-12">
                           <h3>
                              <i class="fa fa-info-circle"></i>
                              &nbsp;Detail Bill
                           </h3>
                        </div>
                     </div>
                     <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col">
                           <table class="table table-striped">
                              <thead>
                                 <tr>
                                    <th>No room</th>
                                    <th>Total pax</th>
                                    <th>Type of registration</th>
                                    <th>Walk in or reservation</th>
                                    <th>Room rate</th>
                                    <th>Stay</th>
                                    <th>Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($registration->rooms as $room)
                                 <tr>
                                    <td>{{ $room->numberRoom }}</td>
                                    <td>{{ $room->pivot->totalPax }}</td>
                                    <td>{{ $room->pivot->typeOfRegistration }}</td>
                                    <td>{{ $room->pivot->walkInOrReservation }}</td>
                                    <td>Rp. {{ number_format($room->pivot->roomRate, 0, ',', '.') }}</td>
                                    <td>{{ $difference }} Night</td>
                                    <td>
                                       Rp.
                                       @php
                                       $roomRate = $room->pivot->roomRate * $difference;
                                       echo number_format($roomRate, 0, ',', '.')
                                       @endphp
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                              <tbody>
                                 <tr rowspan="1" style="background:#3498db;font-weight:bold;">
                                    <td colspan="6"></td>
                                    <td>
                                       Rp.
                                       @php
                                       $total = $registration->rooms()->sum('roomRate') * $difference;
                                       echo number_format($total, 0, ',', '.')
                                       @endphp
                                    </td>
                                 </tr>
                              </tbody>
                              @if(isset($guestReservation))
                              <tbody>
                                 <tr rowspan="1" style="background:#dbc3c7;font-weight:bold;">
                                    <td colspan="6">Deposit :</td>
                                    <td>
                                       (-) Rp. {{ number_format($guestReservation->reservation->deposit, 0, ',', '.') }}
                                    </td>
                                 </tr>
                              </tbody>
                              @endif
                              @if(!empty($registration->extraBad))
                              <tbody>
                                 <tr rowspan="1" style="background:#2ecc71;font-weight:bold;">
                                    <td colspan="6">Extrabad :</td>
                                    <td>
                                       Rp. {{ number_format($registration->extraBad->rate, 0, ',', '.') }} (-)
                                    </td>
                                 </tr>
                              </tbody>
                              @endif
                              <tfoot>
                                 <tr rowspan="1" style="background:yellow;font-weight:bold;">
                                    <td colspan="6">Total :</td>
                                    <td>
                                       Rp.
                                       @if(isset($guestReservation))
                                       @php
                                       $total = ($registration->rooms()->sum('roomRate') * $difference) - $guestReservation->reservation->deposit;
                                       echo number_format($total, 0, ',', '.')
                                       @endphp
                                       @else
                                       @php
                                       $total = $registration->rooms()->sum('roomRate') * $difference;
                                       echo number_format($total, 0, ',', '.')
                                       @endphp
                                       @endif
                                    </td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="card card-success">
               <div class="card-header">
                  <h3 class="card-title">
                     Finally
                  </h3>
               </div>
               <div class="card-body">
                  <div class="col-sm-6 mt-3">
                     <button class="btn btn-success" type="submit">Edit</button>
                     <a href="#" class="btn btn-primary checkIn" data-id="{{ $registration->id }}">Check In</a>
                  </div>
               </div>
            </div>
         </form>

         <div class="card card-outline card-primary">
            <div class="card-header">
               <h3 class="card-title">Rooms Arragement</h3>
            </div>
            <div class="card-body">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <td>Room no</td>
                        <td>Total pax</td>
                        <td>Room rate</td>
                        <td>Individual/Group</td>
                        <td>Walk in/Reservarion</td>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($registration->rooms as $roomArragement)
                     <form action="{{ route('reception.registration.editRoom', $roomArragement->pivot->id) }}" method="post">
                        @csrf
                        @method('post')

                        <input type="hidden" name="idRegistration" value="{{ $registration->id }}">
                        <input type="hidden" name="idRoomOld" value="{{ $roomArragement->id }}">

                        <tr>
                           <td>
                              <select name="rooms" id="" class="form-control">
                                 <option value="{{ $roomArragement->id }}">{{ $roomArragement->numberRoom }}</option>
                                 <option value=""></option>
                                 @foreach($rooms as $room)
                                 <option value="{{ $room->id }}">{{ $room->numberRoom }} || {{ $room->code }}</option>
                                 @endforeach
                              </select>
                           </td>
                           <td><input type="text" value="{{ $roomArragement->pivot->totalPax }}" class="form-control" name="totalPax"></td>
                           <td><input type="number" value="{{ $roomArragement->pivot->roomRate }}" class="form-control" name="roomRate"></td>
                           <td>
                              <select name="typeOfRegistration" id="" class="form-control">
                                 <option value="{{ $roomArragement->pivot->typeOfRegistration }}">{{ $roomArragement->pivot->typeOfRegistration }}</option>
                                 <option value=""></option>
                                 <option value="individual">Individual</option>
                                 <option value="group">Group</option>
                              </select>
                           </td>
                           <td>
                              <select name="walkInOrReservation" id="" class="form-control">
                                 <option value="{{ $roomArragement->pivot->walkInOrReservation }}">{{ $roomArragement->pivot->walkInOrReservation }}</option>
                                 <option value=""></option>
                                 <option value="walkIn">Walk in</option>
                                 <option value="reservation">Reservation</option>
                              </select>
                           </td>
                           <td>
                              <div class="btn-group align-middle py-0">
                                 {{-- submit new room --}}
                                 <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                                 {{-- Delete --}}
                                 <a href="#" class="btn btn-danger deleteRoom" data-id="{{ $roomArragement->pivot->id }}"><i class="fa fa-trash"></i></a>
                              </div>
                           </td>
                        </tr>
                     </form>
                     @endforeach
                  </tbody>
                  <tbody>
                     @if(!empty($registration->extraBad))
                     <form action="{{ route('reception.registration.editExtraBad', $registration->id) }}" method="post">

                        <tr style="background:lightblue;">
                           <td></td>
                           <td>
                              <input type="number" id="form1" name="amount" class="form-control" value="{{ $registration->extraBad->amount }}" required>
                           </td>
                           <td><input type="number" class="form-control" id="form3" name="rate" value="{{ $registration->extraBad->rate }}"></td>
                           <td>
                              <select name="extraBad" id="form2" class="form-control" required>
                                 <option value="extraBad">Extra Bad</option>
                              </select>
                           </td>
                           <td colspan="2">
                              <center>

                                 @csrf
                                 @method('post')
                                 <div class="btn-group align-middle py-0">
                                    {{-- submit new room --}}
                                    <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                                    {{-- Delete --}}
                                    <a href="#" class="btn btn-danger deleteExtraBad" data-id="{{ $registration->extraBad->id }}"><i class="fa fa-trash"></i></a>
                                 </div>
                              </center>
                           </td>
                        </tr>
                     </form>
                     @else
                     <form action="{{ route('reception.registration.addExtraBad') }}" method="post">
                     @csrf
                     <tr style="background:lightblue;">
                        <td></td>
                        <td>
                           <input type="number" id="form1" name="amount" class="form-control" value="" required>
                        </td>
                        <td><input type="number" class="form-control" id="form3" name="rate" value=""></td>
                        <td>
                           <select name="extraBad" id="form2" class="form-control" required>
                              <option value="extraBad">Extra Bad</option>
                           </select>
                        </td>
                        <td colspan="2">
                           <center>
                              <input type="hidden" value="{{ $registration->id }}" name="registration_id">
                              <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-bookmark"></i></button>
                           </center>
                        </td>
                     </tr>
                     </form>
                     @endif
                  </tbody>
                  <tfoot style="background:#ccc;">
                     <tr>
                        <form action="{{ route('reception.registration.addRoom') }}" method="post">
                           @csrf
                           <td>
                              <select name="rooms" id="rooms" class="form-control @error('rooms[]') is-invalid @enderror">
                                 <option value=""></option>
                                 @foreach($rooms as $room)
                                 <option value="{{ $room->id }}">{{ $room->numberRoom }} || {{ $room->code }}</option>
                                 @endforeach
                              </select>
                              @error('rooms[]')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror
                           </td>
                           <td>
                           <td>
                              <input type="text" class="form-control @error('totalPax') is-invalid @enderror" id="totalPax" name="totalPax">
                              @error('totalPax')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                              @enderror
                           </td>
                           <td><input type="number" class="form-control" id="roomRate" name="roomRate"></td>
                           <td>
                              <select name="typeOfRegistration" id="typeOfRegistration" class="form-control">
                                 <option value=""></option>
                                 <option value="individual">Individual</option>
                                 <option value="group">Group</option>
                              </select>
                           </td>
                           <td>
                              <select name="walkInOrReservation" id="walkInOrReservation" class="form-control">
                                 <option value=""></option>
                                 <option value="walkIn">Walk in</option>
                                 <option value="reservation">Reservation</option>
                              </select>
                           </td>
                           <td>
                              <input type="hidden" value="{{ $registration->id }}" name="idRegistration">
                              <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-bookmark"></i></button>
                           </td>
                        </form>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>   
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
   $('.checkIn').live('click', function() {
      var id = $(this).data('id'); //ambil dari data-id
         
      Swal.fire({
         title: 'Would you like to keep a check in?',
         showDenyButton: true,
         showCancelButton: true,
         confirmButtonText: `Save`,
         denyButtonText: `Don't save`,
      }).then((result) => {
         if (result.value) {
            $.ajax({
               type: "GET",
                  url: "/reception/checkIn/" + id,
                  data: {
                  "id": id
               },

               //setelah berhasil di hapus
               success: function(data) {
                  if (data.success === true) {
                     Swal.fire('Info! ', data.message, 'info')
                  } else if (data.success === false) {
                     Swal.fire('Saved!', data.message, 'success')
                     location = '/reception/registration';
                  }
               }
            })
         }
      })
   })

   $('.deleteRoom').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data('id');
         $.ajax({
            type: "GET",
               url: "/reception/deleteRoomArragement/" + id,
               data: {
               "id": id,
                  "_method": 'DELETE',
                  "_token": "{{ csrf_token() }}",
            },

            success: function(data) {
               Swal.fire('Erase Data!', 'Data has been deleted', 'success')
               location.reload(true);
            }
         });
      } else {
         return false;
      }
   });

   $('.deleteExtraBad').live('click', function() {
      if (confirm('Are you sure for deleting?')) {
         let id = $(this).data('id');
         $.ajax({
            type: "GET",
            url: "/reception/deleteExtraBad/" + id,
               data: {
               "id": id,
                  "_method": "DELETE",
                  "_token": "{{ csrf_token() }}",
            },

            success: function(data) {
               Swal.fire('Erase Data!', 'Data has been deleted', 'success')
               location.reload(true);
            }
         });
      } else {
         return false;
      }
   });

   function showDiv(select) {
      let date = `<input type="date" name="expDate" class="form-control" id="remove">`;
      let removeDate = document.getElementById('remove');
      if (select.value == "creditCard") {
         $('.expDate').append(date);
      } else {
         removeDate.remove();
      }
   };

</script>
@endpush
