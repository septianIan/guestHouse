   {{-- plan room --}}
   <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
         <i class="nav-icon fa fa-columns"></i>
         <p>
            Plan room
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ route('chartPlan.roomArragement') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Available Rooms
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('chartPlan.todayEAList') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Today EA List
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('chartPlan.todayEDList') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Today ED List
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Today Arrival List
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Today Departure List
               </p>
            </a>
         </li>
      </ul>
   </li>

   {{-- rooms status --}}
   <li class="nav-item">
      <a href="{{ route('rooms.status') }}" class="nav-link">
         <i class="nav-icon fas fa-info"></i>
         <p>
            Rooms Status
         </p>
      </a>
   </li>

   {{-- Reserved reservation --}}
   <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
         <i class="nav-icon fas fa-check-square"></i>
         <p>
            Reserved Reservation
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Individual Reservation
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Group Reservation
               </p>
            </a>
         </li>
      </ul>
   </li>

   {{-- cencelled reservation --}}
   <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
         <i class="nav-icon fas fa-user-times"></i>
         <p>
            Cancelled Reservation
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ route('reservation.reservation.cancelGuest') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Individual Cancel
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('reservation.reservation.cancelGroup') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Group Cancel</p>
            </a>
         </li>
      </ul>
   </li>

   {{-- calendar --}}
   <li class="nav-item">
      <a href="{{ route('schedulerCalendar.reservation') }}" class="nav-link">
         <i class="nav-icon fas fa-calendar-alt"></i>
         <p>
            Calendar
         </p>
      </a>
   </li>

   {{-- calendar --}}
   <li class="nav-item">
      <a href="{{ route('cashierSummaryCalendar.reservation') }}" class="nav-link">
         <i class="nav-icon fas fa-calendar-alt"></i>
         <p>
            Cashier Summary
         </p>
      </a>
   </li>