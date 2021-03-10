<div class="row">
   <div class="col-lg-12">
      <div class="invoice p-3 mb-3">
         <div class="row">
            <div class="col-12">
               <h3>
                  <i class="fa fa-info-circle"></i>
                  &nbsp;Guest Bill
               </h3>
               <a href="#" class="mb-2 btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-telephoneVoucher"><i class="fa fa-plus px-1"></i>Telephone voucher</a>
               <a href="#" class="mb-2 btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-miscellVoucher"><i class="fa fa-plus px-1"></i>Miscellaneous charges voucher</a>
               <a href="#" class="mb-2 btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-paidOutVoucher"><i class="fa fa-plus px-1"></i>Paid out voucher</a>
            </div>
         </div>
         <div class="row invoice-info">
            <div class="col-sm-12 invoice-col">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Charges/Debit</th>
                        <th>Credit</th>
                        <th>Belance</th>
                     </tr>
                  </thead>
                  <tbody>
                     {{-- Cash --}}
                     <tr>
                        <td>{{ $guestIndividaulReservation->reservation->created_at }}</td>
                        <td>Cash</td>
                        <td> - </td>
                        <td>Rp. {{ number_format($guestIndividaulReservation->reservation->deposit, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($guestIndividaulReservation->reservation->deposit, 0, ',', '.') }}</td>
                     </tr>
                     {{-- Room Cash --}}
                     <tr>
                        <td>{{ $guestIndividaulReservation->reservation->departureDate }}</td>
                        <td>Room cash</td>
                        <td>(-) Rp. {{ number_format($totalRoomCash, 0, ',', '.') }}</td>
                        <td> - </td>
                        <td>Rp. {{ number_format($guestIndividaulReservation->reservation->deposit - $totalRoomCash, 0 ,',', '.') }}</td>
                     </tr>
                     {{-- Telephone cash --}}
                     @if(!empty($billTelephone))
                     <tr>
                        <td> - </td>
                        <td>Telephone cash</td>
                        <td>(-) Rp. {{ number_format($totalTelephone, 0, ',', '.') }}</td>
                        <td> - </td>
                        {{-- Rumus. deposit - total cash - telp cash --}}
                        <td>Rp. 
                           {{ number_format($guestIndividaulReservation->reservation->deposit - $totalRoomCash - $totalTelephone, 0, ',', '.') }}
                        </td>
                     </tr>
                     @endif
                     {{-- miscellaneous cash --}}
                     @if(!empty($billMiscellaneous))
                     <tr>
                        <td> - </td>
                        <td>Miscellaneous cash</td>
                        <td>(-) Rp. {{ number_format($totalMiscellaneous, 0, ',', '.') }}</td>
                        <td> - </td>
                        {{-- Rumus, deposit - room cash - telp cash - miscell cash --}}
                        <td>Rp. 
                           {{ number_format      ($guestIndividaulReservation->reservation->deposit - $totalRoomCash - $totalTelephone - $totalMiscellaneous, 0, ',', '.') }}
                        </td>
                     </tr>
                     @endif
                     {{-- minibar  --}}
                     <tr>
                        <td></td>
                        <td>Mini bar</td>
                        <td>(-) Rp. {{ number_format($totalCashMinibar, 0, ',', '.') }}</td>
                        <td> - </td>
                        <td>Rp. 
                           {{ number_format($guestIndividaulReservation->reservation->deposit - $totalRoomCash - $totalTelephone - $totalMiscellaneous - $totalCashMinibar, 0, ',', '.') }}
                        </td>
                     </tr>
                     {{-- drycleaning --}}
                     <tr>
                        <td></td>
                        <td>Drycleaning</td>
                        <td>(-) Rp. {{ number_format($totalDrycleaning, 0, ',', '.') }}</td>
                        <td> - </td>
                        <td>Rp. 
                           {{ number_format($guestIndividaulReservation->reservation->deposit - $totalRoomCash - $totalTelephone - $totalMiscellaneous - $totalCashMinibar - $totalDrycleaning, 0, ',', '.') }}
                        </td>
                     </tr>
                     {{-- final credit --}}
                     <tr>
                        <td> <?php echo date('d-m-Y') ?> </td>
                        <td> 
                           @if($guestIndividaulReservation->reservation->deposit >= $totalAllCashGuest)
                              Refund
                           @else
                              <font color="red">Repayment</font>
                           @endif
                        </td>
                        <td> - </td>
                        {{-- rumus total deposit di kurangi semua cash--}}
                        <td>Rp. 
                           {{ number_format($guestIndividaulReservation->reservation->deposit - $totalRoomCash - $totalTelephone - $totalMiscellaneous - $totalCashMinibar - $totalDrycleaning, 0, ',', '.') }}
                        </td>
                        {{-- jumlah sisa/kurang --}}
                        <td>Rp. 0
                           {{-- {{ number_format($guestIndividaulReservation->reservation->deposit - $totalAllCashGuest, 0, ',', '.') }} --}}
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>