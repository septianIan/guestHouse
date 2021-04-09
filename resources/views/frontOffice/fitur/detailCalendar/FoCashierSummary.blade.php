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
                     <center>
                        <h3>FRONT OFFICE CASHIER SUMMARY</h3>
                        <p>Date : {{ $date }}</p>
                        <p>Cleck : {{ auth()->user()->name }}</p>
                     </center>
                  </div>
               </div>
               <div class="row invoice-info">
                  <div class="col-sm-9 invoice-col">
                     <p>
                        
                     </p>
                  </div>
                  <div class="col-sm-3 invoice-col">
                     <p>

                     </p>
                  </div>
               </div>
               <div class="row invoice-info">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Revenue</th>
                           <th>Amount (Rp)</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($income as $pay)
                           <tr>
                              <td>{{ $pay['methodPayment'] }}</td>
                              <td>Rp. {{ number_format($pay['income'], 0, ',', '.') }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                        <tr>
                           <td>Total</td>
                           <td>Rp. {{ number_format($total, 0 ,',', '.') }}</td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>
</html>