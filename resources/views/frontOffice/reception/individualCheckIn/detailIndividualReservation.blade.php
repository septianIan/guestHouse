@extends('frontOffice.template.ui')
@section('title', 'Detail Reservation')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reservation.reservation.index') }}">Data Reservation</a></li>
   <li class="breadcrumb-item active">Detail Reservation</li>
</ol>
@endsection
@section('content')
<div class="container">
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
                     <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $reservation->guestName }} </font></strong><br>
                     Address : {{ $reservation->address }}<br>
                     Contact Person : {{ $reservation->contactPerson }}<br>
                     Name Person : {{ $reservation->namePerson }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Date Reservation</b>
                  <address>
                     Arrivale Date : {{ $reservation->arrivaleDate }}<br>
                     Departure Date : {{ $reservation->departureDate }}<br>
                     Estimate Arrival Check in : {{ $reservation->estimateArrivale }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Payment</b>
                  <address>
                     Method Payment : {{ $reservation->methodPayment }}<br>
                     Deposit : {{ number_format($reservation->deposit, 0, ',', '.') }}<br>
                  </address>
               </div>
               <div class="col-sm-3 invoice-col">
                  <b>Order room by reservation</b>
                  <address>
                     @foreach($reservation->individualReservationRooms as $value)
                     Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                     <p>{{ $value->typeOfRoom }}</p>
                     @endforeach
                     Stay : {{ $difference }} night
                  </address>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <form action="{{ route('reception.registration.store') }}" method="post">
            @csrf

            <input type="hidden" name="idIndividualReservation" value="{{ $reservation->id }}">

            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Create Registration guest</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                     </button>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="">First name</label>
                        <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" placeholder="First name..." autocomplete="off" value="{{ $reservation->getFirstName() }}">
                        @error('firstName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Nationality</label>
                        <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" placeholder="Nationality..." autocomplete="off" value="ID" required>
                        @error('nationality')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Occupation</label>
                        <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" placeholder="Occupation..." autocomplete="off" value="{{ old('occupation') }}">
                        @error('occupation')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Last name</label>
                        <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" placeholder="Last name..." autocomplete="off" value="{{ $reservation->getLastName() }}">
                        @error('lastName')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Passport</label>
                        <input type="number" name="passport" class="form-control @error('passport') is-invalid @enderror" placeholder="Passport..." autocomplete="off" value="{{ old('passport') }}" required>
                        @error('passport')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Date of Birth</label>
                        <input type="date" name="dateBirth" class="form-control @error('dateBirth') is-invalid @enderror" autocomplete="off" value="{{ old('dateBirth') }}">
                        @error('dateBirth')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                  </div>
                  <label for="">Home address</label>
                  <textarea name="homeAddress" id="" cols="15" class="form-control @error('homeAddress') is-invalid @enderror" rows="3">{{ $reservation->address }}</textarea>
                  @error('homeAddress')
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
                        <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" placeholder="Company..." value="{{ old('company') }}" autocomplete="off">
                        @error('company')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Arrivale date</label>
                        <input type="date" class="form-control @error('arrivaleDate') is-invalid @enderror arrivaleDate" name="arrivaleDate" placeholder="Arrivale date..." value="{{ $reservation->arrivaleDate }}" autocomplete="off">
                        @error('arrivaleDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Departure date</label>
                        <input type="date" class="form-control @error('departureDate') is-invalid @enderror" name="departureDate" value="{{ $reservation->departureDate }}" autocomplete="off">
                        @error('departureDate')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-sm-6">
                        <label for="">Purpose of visit</label>
                        <input type="text" class="form-control @error('purpose') is-invalid @enderror" name="purpose" placeholder="purpose of visit..." value="{{ old('purpose') }}" autocomplete="off">
                        @error('purpose')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Comming form</label>
                        <input type="text" class="form-control @error('comingFrom') is-invalid @enderror" name="comingFrom" placeholder="Coming from..." value="{{ old('comingFrom') }}" autocomplete="off">
                        @error('comingFrom')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror

                        <label for="">Next destination</label>
                        <input type="text" class="form-control @error('nextDestination') is-invalid @enderror" name="nextDestination" placeholder="Next destination..." value="{{ old('nextDestination') }}" autocomplete="off">
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
                        <select name="termOfPayment" class="form-control">
                           <option value="{{ $reservation->methodPayment }}">{{ $reservation->methodPayment }}</option>
                           <option value="cash">Cash/Travel cheque</option>
                           <option value="creditCard">Credit card</option>
                           <option value="debit">Debit card</option>
                           <option value="companyAccount">Company account</option>
                           <option value="travelAccount">Travel account</option>
                        </select>
                     </div>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" value="0" name="numberAccount">
                     </div>
                     <div class="col-sm-3 expDate">
                        
                     </div>
                  </div>
               </div>
            </div>

            <div class="card card-outline card-primary">
               <div class="card-header">
                  <h3 class="card-title">Rooms Arragement</h3>
                  <a href="#" class="addRow ml-2 btn btn-primary btn-xs"><i class="fa fa-plus px-1"></i>Room Arragement</a>
                  <a href="#" class="addExtraBad ml-2 btn btn-warning btn-xs"><i class="fa fa-plus px-1"></i>Extra bad</a>
               </div>
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <td>Type room</td>
                           <td>Room no</td>
                           <td>Total pax</td>
                           <td>Room rate</td>
                           <td>Individual/Group</td>
                           <td>Walk in/Reservarion</td>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($individialReservationRoomWhereNotExtraBad as $value)
                        @for($i = 0; $i < $value->totalRoomReserved; $i++)
                        
                        <input type="hidden" name="idRooms[]" value="{{ $value->id }}">

                           <tr>
                              <td>{{ $value->typeOfRoom }}</td>
                              <td>
                                 <select name="rooms[]" id="roomArragement" class="form-control @error('rooms') is-invalid @enderror" required>
                                    <option value=""></option>
                                    @if($value->typeOfRoom == 'standart')
                                       @foreach($standart as $room)

                                          @if($room->code == 'O')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:blue;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VR')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:green;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VC')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:#FFA500;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VD')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:red;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>
                                             
                                          @endif

                                       @endforeach
                                    @elseif($value->typeOfRoom == 'superior')
                                       @foreach($superior as $room)

                                          @if($room->code == 'O')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:blue;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VR')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:green;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VC')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:#FFA500;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VD')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:red;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>
                                             
                                          @endif

                                       @endforeach
                                    @elseif($value->typeOfRoom == 'deluxe')
                                       @foreach($deluxe as $room)

                                          @if($room->code == 'O')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:blue;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VR')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:green;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VC')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:#FFA500;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>

                                          @elseif($room->code == 'VD')
                                             <option value="{{ $room->id }}" 
                                             @if($room->code == 'O')
                                                disabled
                                             @elseif($room->code == 'VD')
                                                disabled
                                             @endif
                                             style="color:red;font-weight:bold;">
                                          
                                             {{ $room->numberRoom }} | {{ $room->code }}</option>
                                             
                                          @endif

                                       @endforeach
                                    @else
                                       <option value="">Null</option>
                                    @endif
                                 </select>
                                 @error('rooms')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                              </td>
                              <td>
                                 <input type="number" class="form-control @error('totalPax') is-invalid @enderror" name="totalPax[]" value="{{ $value->totalPax }}">
                                 @error('totalPax')
                                 <div class="invalid-feedback">
                                    {{ $message }}
                                 </div>
                                 @enderror
                              </td>
                              <td>
                                 <input type="number" class="form-control @error('roomRate') is-invalid @enderror" value="{{ $value->roomRate }}" name="roomRate[]">
                                 @error('roomRate')
                                 <div class="invalid-feedback">
                                    {{ $message }}
                                 </div>
                                 @enderror
                              </td>
                              <td>
                                 <select name="typeOfRegistration[]" id="" class="form-control">
                                    <option value="individual">Individual</option>
                                 </select>
                              </td>
                              <td>
                                 <select name="walkInOrReservation[]" id="" class="form-control">
                                    <option value="reservation">Reservation</option>
                                 </select>
                              </td>
                           </tr>
                           
                        @endfor
                        @endforeach
                     </tbody>
                     <tfoot class="rowExtraBad">
                        @if(!empty($extraBad))
                           <tr style="background:lightblue;">
                              <td colspan="2"></td>
                              <td>
                                 <input type="number" id="form1" name="amount" class="form-control" value="1" required>
                              </td>
                              <td><input type="number" class="form-control" id="form3" name="rate" value="{{ $extraBad->roomRate }}"></td>
                              <td>
                                 <select name="extraBad" id="form2" class="form-control" required>
                                    <option value="extraBad">Extra Bad</option>
                                 </select>
                              </td>
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
            {{-- Submit --}}
            <div class="card card-success">
               <div class="card-header">
                  <h3 class="card-title">
                     Finally
                  </h3>
               </div>
               <div class="card-body">
                  <div class="col-sm-6 mt-3">
                     <button class="btn btn-success submit" style="visibility: hidden;" id="submit" type="submit">Submit</button>
                     <a href="#" class="btn btn-warning btn-flat" id="cekRoom">cek</a>
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
   $('.addRow').on('click', function() {
      addRow();
   });

   function addRow() {
      let tr = `
         <tr>
            <td></td>
            <td>
               <select name="rooms[]" id="rooms" class="form-control @error('rooms') is-invalid @enderror">
                  <option value=""></option>
                  @foreach($rooms as $room)

                     @if($room->code == 'O')
                        <option value="{{ $room->id }}" 
                        @if($room->code == 'O')
                           disabled
                        @elseif($room->code == 'VD')
                           disabled
                        @endif
                        style="color:blue;font-weight:bold;">
                     
                        {{ $room->numberRoom }} | {{ $room->code }}</option>

                     @elseif($room->code == 'VR')
                        <option value="{{ $room->id }}" 
                        @if($room->code == 'O')
                           disabled
                        @elseif($room->code == 'VD')
                           disabled
                        @endif
                        style="color:green;font-weight:bold;">
                     
                        {{ $room->numberRoom }} | {{ $room->code }}</option>

                     @elseif($room->code == 'VC')
                        <option value="{{ $room->id }}" 
                        @if($room->code == 'O')
                           disabled
                        @elseif($room->code == 'VD')
                           disabled
                        @endif
                        style="color:#FFA500;font-weight:bold;">
                     
                        {{ $room->numberRoom }} | {{ $room->code }}</option>

                     @elseif($room->code == 'VD')
                        <option value="{{ $room->id }}" 
                        @if($room->code == 'O')
                           disabled
                        @elseif($room->code == 'VD')
                           disabled
                        @endif
                        style="color:red;font-weight:bold;">
                     
                        {{ $room->numberRoom }} | {{ $room->code }}</option>
                        
                     @endif

                  @endforeach
               </select>
            </td>
            <td>
               <input type="number" class="form-control @error('totalPax') is-invalid @enderror" name="totalPax[]" value="">
               @error('totalPax')
               <div class="invalid-feedback">
                  {{ $message }}
               </div>
               @enderror
            </td>
            <td>
               <input type="number" class="form-control @error('roomRate') is-invalid @enderror" value="" name="roomRate[]">
               @error('roomRate')
               <div class="invalid-feedback">
                  {{ $message }}
               </div>
               @enderror
            </td>
            <td>
               <select name="typeOfRegistration[]" id="" class="form-control">
                  <option value=""></option>
                  <option value="individual">Individual</option>
                  <option value="group">Group</option>
               </select>
            </td>
            <td>
               <select name="walkInOrReservation[]" id="" class="form-control">
                  <option value=""></option>
                  <option value="walkIn">Walk in</option>
                  <option value="reservation">Reservation</option>
               </select>
            </td>
            <td><a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a></td>
         </tr>
      `;
      $('tbody').append(tr);
   };

   $('.remove').live('click', function() {
      var last = $('tr').length;
      if (last < 0) {
         alert("you can not remove last row");
      } else {
         $(this).parent().parent().remove();
      }
   });

   function showDiv(select) {
      let date1 = `<input type="date" name="expDate" class="form-control" id="remove">`;
      let date2 = `<input type="date" name="expDate" class="form-control" id="remove">`;
      let removeDate = document.getElementById('remove');
      if (select.value == "creditCard" || select.value == 'debit') {
         $('.expDate').append(date1);
      } else {
         removeDate.remove();
      }
   };

   $('.addExtraBad').on('click', function() {
      let tr = `
         <tr style="background:lightblue;">
            <td colspan="2"></td>
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
                  <a href="#" class="btn btn-danger removeExtraBad"><i class="fa fa-times"></i></a>
               </center>
            </td>
         </tr>
      `;
      $('.rowExtraBad').append(tr);
   });

   $('.removeExtraBad').live('click', function() {
      var removeExtraBad = $('tfoot tr');
      removeExtraBad.remove();
   });

   // roomReserved
   $(document).ready(function(){
      $('#cekRoom').live('click', function(){
         // retrive select option array with element id
         let roomReserved = [];
         $('select[name="rooms[]"] option:selected').each(function(){
            roomReserved.push($(this).val());
         }); 
         let roomArragement = roomReserved.filter(item => item);

         // tambahan kamar baru
         let addRoom =[];
         $('#rooms option:selected').each(function(){
            addRoom.push($(this).val());
         });
         let rooms = addRoom.filter(item => item);
         let arrivalDate = $(".arrivaleDate").val();
         
         $.ajax({
            type: "POST",
            url: "{{ route('reception.checkAvailableRoom.roomReserved') }}",
            data: {
               "_token": "{{ csrf_token() }}",
               "roomArragement": roomArragement,
               "rooms": rooms,
               "arrivalDate": arrivalDate,
            },
            dataType: 'json',
            success: function(data){
               if(data.success === true){
                  Swal.fire({
                     icon: 'error',
                     title: 'Oops...',
                     text: data.message
                  })
                  document.getElementById("submit").style.visibility = 'hidden';
               }else if(data.success === false) {
                  alert(data.message);
                  document.getElementById("submit").style.visibility = 'visible';
               }
            },
            error: function(jqXHR, textStatus, errorThrown) {}
         });
      });
   });
</script>
@endpush
