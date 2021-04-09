<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Guest House | @yield('title', 'Dashboard')</title>
   @include('frontOffice.template.components.style')
</head>
<body onload="window.print()">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="invoice p-3 mb-3">
               <div class="row">
                  <div class="col-12">
                     <h3>
                        <center>GUEST BILL</center>
                     </h3>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-9 invoice-col">
                     <p>
                        Name guest &nbsp &nbsp &nbsp &nbsp : {{ $masterBill->registration->getGuestName() }}<br>
                        Arrivale date  &nbsp &nbsp &nbsp &nbsp: {{ $masterBill->registration->arrivaleDate }}<br>
                        Departure Date &nbsp: {{ $masterBill->registration->departureDate }} <br>
                        Date birth &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp : {{ $masterBill->registration->dateBirth }} <br>
                        Address&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp: {{ $masterBill->registration->homeAddress }}
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <p>
                        Room : {{ $masterBill->chargeTo }} <br>
                     </p>
                  </div>
               </div>
               <div class="row invoice-info">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Description</th>
                           <th>Charge</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($masterBill->detailMasterBills as $detailMasterBill)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $detailMasterBill->date }}</td>
                              <td>
                                 {{ $detailMasterBill->description }}
                              </td>
                              <td>Rp. {{ number_format($detailMasterBill->charge, 0, ',', '.') }}</td>
                           </tr>
                        @endforeach
                           <tr>
                              <td colspan="3"><center><b>Total</b></center></td>
                              <td>Rp. {{ number_format($masterBill->detailMasterBills->sum('charge'), 0, ',', '.') }}</td>
                           </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-6">
            CHARGE TO : COMPANY/TRAVEL AGENT <br>
            KIND OF EXPANSES :
         </div>
         <div class="col-sm-6"><p class="float-right">Cleck : {{ auth()->user()->name }}</p></div>
      </div>
   </div>
</body>
</html>