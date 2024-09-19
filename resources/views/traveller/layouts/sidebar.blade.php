{{-- @dd(Route::current()->getName()) --}}
<div class="db-sidebar bg-white">
    <nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
       <div class="sticky-area shadow-xs-1">
          <div class="d-flex w-100">
             
             <div class="logobg-color bg-secondary px-xl-2">
                <a class="navbar-brand" href="{{route('frontend.index')}}">
                   <img src="{{asset('traveller-assets/img/logo.png')}}" alt="">
                </a>               
             </div>
             <!-- Responsive Top section -->
             <div class="ml-auto d-flex align-items-center ">
                <div class="d-flex align-items-center d-xl-none">
                   <div class="dropdown px-3">
                      <a href="#" class="dropdown-toggle d-flex align-items-center text-heading" data-toggle="dropdown">
                         <div class="w-48px">
                            <img src="{{asset('traveller-assets/img/testimonial-5.jpg')}}" alt="{{auth()->user()->name}}" class="rounded-circle">
                         </div>
                         <span class="fs-13 font-weight-500 d-none d-sm-inline ml-2">
                         {{auth()->user()->name}}
                         </span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                         <a class="dropdown-item" href="javascript:void(0)">My Profile</a>
                         <a class="dropdown-item" href="javascript:void(0)">Logout</a>
                      </div>
                   </div>
                </div>
 
                <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse" data-target="#primaryMenuSidebar" aria-controls="primaryMenuSidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
             </div>
          </div>
          <div class="collapse navbar-collapse bg-white" id="primaryMenuSidebar">
             <ul class="list-group list-group-flush w-100 customlisting">
                <li class="list-group-item pt-2 pb-2">
                   <ul class="list-group">
                     <li><a href="{{route('traveller.dashboard')}}" @if(Route::current()->getName()=='traveller.dashboard') class="active" @endif>Dashboard</a></li>
                     <li><a href="{{route('traveller.booking')}}"  @if(in_array(Route::current()->getName(),['traveller.booking','traveller.booking.details','traveller.pay.remaining.balance','cancel.booking'])) class="active" @endif>Your Booking</a></li>
                     <li><a href="{{route('traveller.booking.transaction.histories')}}" @if(Route::current()->getName()=='traveller.booking.transaction.histories') class="active" @endif>Booking Transaction Histories</a></li>
                     <li><a href="{{route('chat')}}"@if(Route::current()->getName()=='chat') class="active" @endif>Message<i class="fa fa-bell-o notification-bell" aria-hidden="true"></i> @if(App\Http\Helper\Helper::getTotalUnreadMesage(auth()->user()->id) >0)<span class="btn__badge pulse-button ">{{App\Http\Helper\Helper::getTotalUnreadMesage(auth()->user()->id)}}</span>@endif</a></li>
                     <li><a href="{{route('cancel.bokking.list')}}"@if(Route::current()->getName()=='cancel.bokking.list') class="active" @endif>Your Cancel Booking </a></li>
                     <li><a href="{{route('traveller.switch.to.host')}}"@if(Route::current()->getName()=='traveller.switch.to.host') class="active" @endif>Switch to Host </a></li>
                   </ul>
                </li>
 
             </ul>
          </div>
       </div>
    </nav>
 </div>
 <div class="page-content">