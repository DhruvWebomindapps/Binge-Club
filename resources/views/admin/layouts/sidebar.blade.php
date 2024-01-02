 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/dashboard') }}">
         <div class="sidebar-brand-icon rotate-n-15">
             {{-- <i class="fas fa-laugh-wink"></i> --}}
         </div>
         <div class="sidebar-brand-text mx-3"><img src="{{ asset('frontend/assets/image/home/white-logo.svg') }}" /></div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('dashboard') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span>
         </a>
     </li>
     <hr class="sidebar-divider">
     @role('super-admin')
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-arrow-alt-circle-right"></i>
             <span>Master</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ url('admin/master/state') }}">State</a>
                 <a class="collapse-item" href="{{ url('admin/master/city') }}">City</a>
                 <a class="collapse-item" href="{{ url('admin/master/location') }}">Location</a>
                 <a class="collapse-item" href="{{ url('admin/master/screen') }}">Screen</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
             aria-expanded="true" aria-controls="collapseThree">
             <i class="fas fa-arrow-alt-circle-right"></i>
             <span>Addons</span>
         </a>
         <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ url('admin/master/cake') }}" aria-expanded="true">
                     <i class="fas fa-birthday-cake"></i>
                     <span class="ms-1">Cakes</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/gift') }}" aria-expanded="true">
                     <i class="fas fa-gift"></i>
                     <span class="ms-1">Gifts</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/decoration') }}" aria-expanded="true">
                     <i class="fal fa-lights-holiday"></i>
                     <span class="ms-1">Decorations</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/snacks') }}" aria-expanded="true">
                     <i class="fas fa-cookie-bite"></i>
                     <span class="ms-1">Snacks</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/bouquet') }}" aria-expanded="true">
                     <i class="fas fa-fan"></i>
                     <span class="ms-1">Bouquet</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/other') }}" aria-expanded="true">
                     <i class="fas fa-camera-retro"></i>
                     <span class="ms-1">Others</span>
                 </a>
                 <a class="collapse-item" href="{{ url('admin/master/package') }}" aria-expanded="true">
                     <i class="fas fa-box"></i>
                     <span class="ms-1">Packages</span>
                 </a>
             </div>
         </div>
     </li>
     @endrole
     <li class="nav-item {{ Request::is('admin/booking') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ url('admin/booking') }}" aria-expanded="true">
             <i class="material-icons">theaters</i>
             <span>All Booking</span>
         </a>
     </li>
     <li class="nav-item {{ Request::is('admin/today/bookings') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ url('admin/today/bookings') }}" aria-expanded="true">
             <i class="material-icons">theaters</i>
             <span>Today's Booking</span>
         </a>
     </li>
     <li class="nav-item {{ Request::is('admin/upcoming/bookings') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ url('admin/upcoming/bookings') }}" aria-expanded="true">
             <i class="material-icons">theaters</i>
             <span>Upcoming Booking</span>
         </a>
     </li>
     <li class="nav-item {{ Request::is('admin/cancelled/bookings') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ url('admin/cancelled/bookings') }}" aria-expanded="true">
             <i class="material-icons">theaters</i>
             <span>Cancelled Booking</span>
         </a>
     </li>
     @role('super-admin')
     <li class="nav-item {{ Request::is('admin/customers') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ url('admin/customers') }}" aria-expanded="true">
            <i class='fas fa-users'></i>
            <span>Customer</span>
         </a>
     </li>
     <li class="nav-item {{ Request::is('admin/blogs') ? 'active' : '' }}">
         <a class="nav-link collapsed" href="{{ route('allblogs') }}" aria-expanded="true">
            <i class='fas fa-newspaper'></i>
            <span>Blogs</span>
         </a>
     </li>
     @endrole
 </ul>
 <style>
     .show {
         visibility: initial !important;
     }
 </style>
 <!-- End of Sidebar -->
