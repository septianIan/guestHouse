@extends('frontOffice.template.ui')
@section('title', 'Detail Guest Check In')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="/">Home</a></li>
   <li class="breadcrumb-item"><a href="{{ route('reception.cashier.index') }}">Data Guest Check In</a></li>
   <li class="breadcrumb-item active">Detail Guest Check In</li>
</ol>
@endsection

@section('content')
   <div class="container">
      {{-- Detail Guest Registration --}}
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Registration
                     </h3>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Name guest : {{ $registration->getGuestName() }}<br>
                        Nationality : {{ $registration->nationality }}<br>
                        Passport : {{ $registration->passport }}<br>
                        Occupation : {{ $registration->occupation }}<br>
                        Date birth : {{ $registration->dateBirth }}
                     </p>
                  </div>
                  <div class="col-sm-4 invoice-col">
                     <p>
                        Home address : {{ $registration->homeAddress }}<br>
                        Company : {{ $registration->company }}<br>
                        Purpose : {{ $registration->purpose }}<br>
                        Arrivale date : {{ $registration->arrivaleDate }}<br>
                        Departure Date : {{ $registration->departureDate }}
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Coming from : {{ $registration->comingFrom }} <br>
                        Next destination : {{ $registration->nextDestination }}<br>
                        Term of payment : {{ $registration->termOfPayment }}<br>
                        Number account : {{ $registration->numberAccount }}<br>
                        Exp date : {{ $registration->expDate }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {{-- Detial guest Reservation --}}
      @if(isset($guestIndividaulReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Guest <b>Individual</b> Reservation
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <address>
                        <strong>Guest Name :&nbsp;<font style="font-style:italic;">{{ $guestIndividaulReservation->reservation->guestName }} </font></strong><br>
                        Address : {{ $guestIndividaulReservation->reservation->address }}<br>
                        Contact Person : {{ $guestIndividaulReservation->reservation->contactPerson }}<br>
                        Name Person : {{ $guestIndividaulReservation->reservation->namePerson }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Date Reservation : </b>{{ $guestIndividaulReservation->reservation->created_at }}
                     <address>
                        Arrivale Date : {{ $guestIndividaulReservation->reservation->arrivaleDate }}<br>
                        Departure Date : {{ $guestIndividaulReservation->reservation->departureDate }}<br>
                        Estimate Arrival Check in : {{ $guestIndividaulReservation->reservation->estimateArrivale }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Payment</b>
                     <address>
                        Method Payment : {{ $guestIndividaulReservation->reservation->methodPayment }}<br>
                        Deposit : {{ number_format($guestIndividaulReservation->reservation->deposit, 0, ',', '.') }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Order room by reservation</b>
                     <address>
                        @foreach($guestIndividaulReservation->reservation->individualReservationRooms as $value)
                        <address>
                           Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                           <b>{{ $value->typeOfRoom }}</b>
                        </address>
                        @endforeach
                        Stay : {{ $difference }} night
                     </address>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @elseif(isset($guestGroupReservation))
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h4>
                        <i class="fa fa-info-circle"></i>
                        &nbsp;Detail Guest <b>Group</b> Reservation
                     </h4>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                     <address>
                        <strong>Group Name :&nbsp;<font style="font-style:italic;">{{ $guestGroupReservation->reservationGroup->groupName }} </font></strong><br>
                        Address : {{ $guestGroupReservation->reservationGroup->addressPerson }}<br>
                        Contact Person : {{ $guestGroupReservation->reservationGroup->contactPerson }}
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Date Reservation : </b>{{ $guestGroupReservation->reservationGroup->created_at }}
                     <address>
                        Arrivale Date : {{ $guestGroupReservation->reservationGroup->arrivaleDate }}<br>
                        Departure Date : {{ $guestGroupReservation->reservationGroup->departureDate }}<br>
                        Estimate Arrival Check in : {{ $guestGroupReservation->reservationGroup->estimateArrivale }}<br>
                     </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Method Payment :&nbsp; <font style="font-style:italic;">{{ $guestGroupReservation->reservationGroup->methodPayment->methodPayment }}</font></b>
                     @if($guestGroupReservation->reservationGroup->methodPayment->methodPayment == 'personal')
                     <p>
                        Cast deposit : {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                        Credit card : {{ $guestGroupReservation->reservationGroup->methodPayment->value1 }}<br>
                        Number account : {{ $guestGroupReservation->reservationGroup->methodPayment->value2 }}<br>
                        Other : {{ $guestGroupReservation->reservationGroup->methodPayment->value3 }}<br>
                     </p>
                     @else
                     <p>
                        Deposit : {{ number_format($guestGroupReservation->reservationGroup->methodPayment->deposit, 0, ',', '.') }}<br>
                        Guarantee letter : {{ $guestGroupReservation->reservationGroup->methodPayment->value1 }}<br>
                        Travel agent : {{ $guestGroupReservation->reservationGroup->methodPayment->value2 }}<br>
                        Other : {{ $guestGroupReservation->reservationGroup->methodPayment->value3 }}<br>
                     </p>
                     @endif
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <b>Order room by reservation</b>
                     <address>
                        @foreach($guestGroupReservation->reservationGroup->groupReservationRooms as $value)
                        <address>
                           Total room reserved : {{ $value->totalRoomReserved }}&nbsp;
                           <b>{{ $value->typeOfRoom }}</b>
                        </address>
                        @endforeach
                        Stay : {{ $difference }} night
                     </address>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endif

      {{-- GUEST BILL walkin--}}
      @if(isset($guestIndividaulReservation))
         @include('frontOffice.reception.cashier.guestBill.guestIndividualReservation')
      @elseif(isset($guestGroupReservation))
         @include('frontOffice.reception.cashier.guestBill.guestGroupReservation')
      @else
         {{-- Guest Bill walk in--}}
         @include('frontOffice.reception.cashier.guestBill.guestWalkIn')
      @endif
      </div>
   </div>
@endsection

@push('modals')
   {{-- MODAL --}}
<div class="modal fade" id="modal-postCharge">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Post charges</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('reception.guestBill.store') }}" method="post">
         @csrf
            <input type="hidden" name="registration_id" value="{{ $registration->id }}">
            <div class="modal-body">
               <a href="#" class="btn btn-success btn-xs" id="addRowBill"><i class="fa fa-plus px-1"></i></a>
               <div id="rowBill">
               
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Create bill</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endpush
@push('styles')
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
      $('.adddRowMiscellaneous').live('click', function() {
         addRowMiscell();
      });

      function addRowMiscell() {
         let tr = `
            <tr>
               <td>
               <input type="text" name="descriptions[]" class="form-control" id="">
               </td>
               <td>
                  <input type="number" name="amount[]" onkeyup="countTotalMiscellaneous()" class="form-control amount" id="">
               </td>
               <td>
                  <a href="#" class="btn btn-danger remove"><i class="fa fa-times"></i></a>
               </td>
            </tr>
         `;
         $('.rowMiscellaneous').append(tr);
      }

      $('.remove').live('click',  function(){
         var last=$('tbody tr .a').length;
         console.log(last);
         if(last == 1){
            alert('You can nor remove last row');
         } else {
            $(this).parent().parent().remove();
            var tr = $(this).parent().parent();
            var amount = tr.find('.amount').val();
            var total = 0;
            
            $('.amount').each(function(i,e){
               var amount = $(this).val()-0;
               total += amount;
            });

            // format rupiah
            var reverse = total.toString().split('').reverse().join(''),
            total = reverse.match(/\d{1,3}/g);
            total = total.join('.').split('').reverse().join('');

            $('.total').html(`Rp. ${total}`);  
         }
      });

      function countTotalMiscellaneous(){
         var tr = $(this).parent().parent();
         var amount = tr.find('.amount').val();
         var total = 0;

         $('.amount').each(function(i,e){
            var amount = $(this).val()-0;
            total += amount;
         });

         // format rupiah
         var reverse = total.toString().split('').reverse().join(''),
         total = reverse.match(/\d{1,3}/g);
         total = total.join('.').split('').reverse().join('');

         $('.total').html(`Rp. ${total}`);   
      }
      
      /**
      PAID OUT VOUCHER
      */

      $('.addRowPaidOutVoucher').on('click', function() {
         let tr = `
            <tr>
               <td>
               <input type="text" name="description[]" class="form-control" id="">
               </td>
               <td>
                  <input type="number" name="amount[]" onkeyup="countPaidOutVoucher()" class="form-control amount" id="">
               </td>
               <td>
                  <a href="#" class="btn btn-danger removePaidOutVoucher"><i class="fa fa-times"></i></a>
               </td>
            </tr>
         `;
         $('.rowPaidOutVoucher').append(tr);
      });

      $('.removePaidOutVoucher').live('click',  function(){
         var last=$('tbody tr .a').length;
         console.log(last);
         if(last == 1){
            alert('You can nor remove last row');
         } else {
            $(this).parent().parent().remove();
            var tr = $(this).parent().parent();
            var amount = tr.find('.amount').val();
            var amountPaidOutVoucher = 0;
            
            $('.amount').each(function(i,e){
               var amount = $(this).val()-0;
               amountPaidOutVoucher += amount;
            });

            // format rupiah
            var reverse = amountPaidOutVoucher.toString().split('').reverse().join(''),
            amountPaidOutVoucher = reverse.match(/\d{1,3}/g);
            amountPaidOutVoucher = amountPaidOutVoucher.join('.').split('').reverse().join('');

            $('.amountPaidOutVoucher').html(`Rp. ${amountPaidOutVoucher}`);  
         }
      });

      function countPaidOutVoucher(){
         var tr = $(this).parent().parent();
         var amountPaidOutVoucher = tr.find('.amountPaidOutVoucher').val();
         var totalPaidOutVoucher = 0;

         $('.amountPaidOutVoucher').each(function(i,e){
            var amountPaidOutVoucher = $(this).val()-0;
            totalPaidOutVoucher += amountPaidOutVoucher;
         });

         // format rupiah
         var reverse = totalPaidOutVoucher.toString().split('').reverse().join(''),
         totalPaidOutVoucher = reverse.match(/\d{1,3}/g);
         totalPaidOutVoucher = totalPaidOutVoucher.join('.').split('').reverse().join('');

         $('.totalPaidOutVoucher').html(`Rp. ${totalPaidOutVoucher}`);   
      }

      //Add row bill
      var count = 0;
      $("#addRowBill").live('click' ,function(){
         count++;
         $('#rowBill').append(`
            <div class="row" id="corso_${count}">
               <div class="col-sm-2">
                  <label for="">Room</label>
                  <select name="rooms[]" id="room_${count}" class="form-control">
                     <option></option>
                     @foreach($registration->rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->numberRoom }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="col-sm-4">
                  <label for="">Date</label>
                  <input type="date" name="date[]" class="form-control" id="date_${count}" required>
               </div>
               <div class="col-sm-3">
                  <label for="">Description</label>
                  <select name="description[]" id="description_${count}" class="form-control" required>
                     <option value=""></option>
                     <option value="room service">Room service</option>
                     <option value="miscellaneous">Miscellaneous</option>
                     <option value="telephone">Telephone</option>
                     <option value="cafe shop">Cafe shop</option>
                     <option value="laundry">Laundry</option>
                     <option value="minibar">Mini bar</option>
                  </select>
               </div>
               <div class="col-sm-2">
                  <label for="">amount</label>
                  <input type="number" name="amount[]" class="form-control" id="amount_${count}">
               </div>
               <div class="col-sm-1">
                  <label for="">Action</label>
                  <a href="#" class="btn btn-danger delete" id="delete_${count}" onclick="remove(this);"><i class="fa fa-times"></i></a>
               </div>
            </div>
         `);
      });

      function remove(aRemove){
         var divid = aRemove.id.replace("delete_", "corso_");
         $("#" + divid).remove();
      }

      $('.deletePostCash').live('click', function(){
         if (confirm('Are you sure for deleting?')) {
            let id = $(this).data('id');
            $.ajax({
               type: "POST",
                  url: "/reception/guest/bill/delete/description/" + id,
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

      $('.deleteMasterBill').live('click', function(){
         if (confirm('Are you sure for deleting?')) {
            let id = $(this).data('id');
            $.ajax({
               type: "POST",
                  url: "/reception/guest/bill/delete/master-bill/" + id,
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

      $('.deleteAllMasterBill').live('click', function(){
         if (confirm("You're sure to clear the master bill in this room?")) {
            let id = $(this).data('id');
            $.ajax({
               type: "POST",
                  url: "/reception/guest/bill/delete/master-bill/per-room/" + id,
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
      })

      // Checked BOX
      $(document).ready(function(){
         $('#typeCharge').change(function(){
            let checkbox = $("#typeCharge option:selected").val();
            if(checkbox == 'P/A ALL' || checkbox == 'C/A ALL'){
               $("input:checkbox").each(function(){
                  this.checked = true;
               });
            } else if(checkbox == 'C/A RO'){
               $("input.rooms:checkbox").each(function(){
                  this.checked = true;
               });

               $("input.meals:checkbox").each(function(){
                  this.checked = false;
               });

               $("input.otherCash:checkbox").each(function(){
                  this.checked = false;
               });
               
            } else if(checkbox == 'C/A RO+BF'){
               $("input.rooms:checkbox").each(function(){
                  this.checked = true;
               });
               
               $("input.meals:checkbox").each(function(){
                  this.checked = true;
               });
            }else if(checkbox == 'P/A'){

            } else {
               $("input:checkbox").each(function(){
                  this.checked = false;
               });
            }
         });

         //Save allBills
         $('#saveAllBills').live('click', function(){
            let id = $(this).data('id');
            Swal.fire({
            title: 'You sure you want to make a master bill?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#078512',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, created!',
            cancelButtonText: 'Cancel!',
            }).then((result) => {
               if(result.value){
                  $.ajax({
                     type: "POST",
                     url: "{{ route('reception.temporary.store') }}",
                     data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id 
                     },
                     dataType: 'json',
                     success: function(data) {
                        Swal.fire('Create Data!', 'The master bill has been created', 'success')
                        location.reload(true);
                     }
                  });
               }
            })
         });
      //
      });

      // ALERT MESSAGE
      var msg = '{{Session::get('alert')}}';
      var exist = '{{Session::has('alert')}}';
      if(exist){
         alert(msg);
      }

      //confirm leave page
      /*window.onbeforeunload = function() {
         var Ans = confirm("Are you sure you want change page!");
         if(Ans==true)
            return true;
         else
            return false;
      };*/

      //RESET BILL
      $('.resetBill').live('click',  function(){
         let id = $(this).data('id');
         Swal.fire({
         title: 'This will reset all guest bills',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#078512',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Reset!',
         cancelButtonText: 'Cancel!',
         }).then((result) => {
            if(result.value){
               $.ajax({
                  type: "GET",
                  url: "/reception/guest/bill/reset/" + id,
                  data: {
                     "_token": "{{ csrf_token() }}",
                     "id": id 
                  },
                  dataType: 'json',
                  success: function(data) {
                  Swal.fire('Reset Data!', 'Bill has been reset', 'success')
                  location.reload(true);
                  }
               });
            }
         })
      });

      //Check Out
      $('#checkOut').live('click',  function(){
         let id = $(this).data('id');
         Swal.fire({
         title: 'Check Out!',
         text: 'Sure you will check out.',
         imageUrl: '{{ asset('assets/img/876195-200.png') }}',
         imageWidth: 200,
         imageHeight: 200,
         imageAlt: 'Custom image',
         }).then((result) => {
            if(result.value){
               $.ajax({
                  type: "GET",
                  url: "/reception/guest/bill/checkout/"+id,
                  dataType: 'json',
                  success: function(data) {
                     if(data.success === true){
                        Swal.fire('Info!', data.message, 'info')
                     }else if(data.success === false){
                        Swal.fire('Check Out!', 'Guest has been check out', 'success')
                        location = '/reception/guest/checkIn';
                     }
                  }
               });
            }
         })
      });
   </script>
@endpush
