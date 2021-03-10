<li class="nav-header">Menu registration</li>

   <li class="nav-item">
      <a href="{{ route('reception.registration.index') }}" class="nav-link">
         <i class="nav-icon fas fa-user-plus"></i>
         <p>
            Registration
         </p>
      </a>
   </li>

   <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
         <i class="nav-icon fa fa-columns"></i>
         <p>
            Reservation
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ route('reception.checkIn.individualCheckIn') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Individual Reservation
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('reception.checkIn.groupCheckIn') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Group Registration
               </p>
            </a>
         </li>
      </ul>
   </li>

   {{-- Check Out --}}
   <li class="nav-header">Menu cashier</li>
   <li class="nav-item">
      <a href="{{ route('reception.cashier.index') }}" class="nav-link">
         <i class="nav-icon fas fa fa-outdent"></i>
         <p>
            Check Out
         </p>
      </a>
   </li>