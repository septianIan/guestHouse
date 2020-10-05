<nav class="mt-2">
   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <li class="nav-item">
         <a href="{{ route('reservation.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
               Home
            </p>
         </a>
      </li>

      <li class="nav-item">
         <a href="{{ route('reservation.reservation.index') }}" class="nav-link">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>
               Individual Reservation
            </p>
         </a>
      </li>

      <li class="nav-item">
         <a href="{{ route('reservation.reservationGroup.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
               Group Reservation
            </p>
         </a>
      </li>

      {{-- <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
               Charts
               <i class="right fas fa-angle-left"></i>
            </p>
         </a>
         <ul class="nav nav-treeview">
            <li class="nav-item">
               <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
               </a>
            </li>
         </ul>
      </li> --}}

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
               <a href="{{ route('reservation.calender.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                     Calendar
                  </p>
               </a>
            </li>
            <li class="nav-item">
               <a href="" class="nav-link">
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
   </ul>
</nav>
