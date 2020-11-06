<li class="nav-header">Other Menu</li>

   <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
         <i class="nav-icon fa fa-columns"></i>
         <p>
            Chart Plan
            <i class="right fas fa-angle-left"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="{{ route('reservation.chartPlan.calendar') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Calendar
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('reservation.chartPlan.dateBetween') }}" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>
                  Between Date
               </p>
            </a>
         </li>
      </ul>
   </li>

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

   <li class="nav-item">
      <a href="pages/calendar.html" class="nav-link">
         <i class="nav-icon fas fa-calendar-alt"></i>
         <p>
            Calendar
            <span class="badge badge-info right">2</span>
         </p>
      </a>
   </li>