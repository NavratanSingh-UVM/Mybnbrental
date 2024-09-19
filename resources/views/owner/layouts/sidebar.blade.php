            <div class="db-sidebar bg-white">
                <nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
                    <div class="sticky-area shadow-xs-1">
                        <div class="d-flex w-100">
                            <div class="logobg-color bg-secondary px-xl-2">
                                <a class="navbar-brand" href="javascript:void(0)">
                                <img src="{{ asset('owner-assets/img/logo.png') }}" alt="">
                                </a>               
                            </div>
                            <!-- Responsive Top section -->
                            <div class="ml-auto d-flex align-items-center ">
                                <div class="d-flex align-items-center d-xl-none">
                                <div class="dropdown px-3">
                                    <a href="javascript:void(0)" class="dropdown-toggle d-flex align-items-center text-heading" data-toggle="dropdown">
                                        <div class="w-48px">
                                            @if (auth()->user()->image ==null)
                                                <img src="{{asset('owner-assets/img/agent-1.jpg')}}" alt="" srcset="">
                                            @else
                                                <img src="{{ url('public/storage/profile_image/'.auth()->user()->image) }}" alt=" {{ Auth()->user()->name }}" class="rounded-circle">
                                            @endif
                                        </div>
                                        <span class="fs-13 font-weight-500 d-none d-sm-inline ml-2">
                                            {{ Auth()->user()->name }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('owner.edit.profile') }}">My Profile</a>
                                        <a class="dropdown-item" href="{{ route('owner.logout') }}">Logout</a>
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
                                <li class="list-group-item pt-2 pb-2 accordion" id="accordionExample">
                                    <ul class="list-group">
                                        <li><a href="{{ route('owner.dashboard') }}" @if(Route::current()->getName() == 'owner.dashboard') class="active" @endif>Dashboard</a></li>
                                        <li><a href="{{ route('owner.my.property.listing') }}" @if(in_array(Route::current()->getName(),array('owner.create.property','owner.my.property.listing'))) class="active" @endif>My Property Listing</a></li>
                                        <li><a href="{{route('owner.property.booking')}}" @if(in_array(Route::current()->getName() ,['owner.property.owner.property.booking','owner.property.booking.details'])) class="active" @endif>My Bookings</a></li>
                                        <li><a href="{{route('owner.transaction')}}"@if(in_array(Route::current()->getName(),array('owner.transaction','owner.create.payment','owner.card.details'))) class="active" @endif>Feature Listing</a></li>
                                        <li><a href="{{ route('owner.billing.details') }}" @if(Route::current()->getName() =='owner.billing.details') class="active" @endif>Billing Details</a></li>
                                        <li><a href="{{ route('owner.booking.request') }}" @if(Route::current()->getName() == 'owner.booking.request') class="active" @endif>Enquiry Request</a></li>
                                        {{-- <li id="headingOne">
                                            <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" href="">Email Template</button>
                                            <div id="collapseOne" class="collapse @if(in_array(Route::current()->getName(),['owner.payment.reminder','owner.cancellation.message','owner.welcome.message','owner.invite.to.leave.a.review'])) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <ul class="p-0">
                                                    <li><a href="{{ route('owner.payment.reminder') }}" @if(Route::current()->getName()=='owner.payment.reminder') class="active" @endif>Payment Reminder</a></li>
                                                    <li><a href="{{ route('owner.cancellation.message') }}"  @if(Route::current()->getName()=='owner.cancellation.message') class="active" @endif>Cancellation</a></li>
                                                    <li><a href="{{ route('owner.welcome.message') }}"  @if(Route::current()->getName()=='owner.welcome.message') class="active" @endif>Welcome Message</a></li>
                                                    <li><a href="{{ route('owner.invite.to.leave.a.review') }}" @if(Route::current()->getName()=='owner.invite.to.leave.a.review') class="active" @endif>Invite To Leave A Review</a></li>

                                                </ul>
                                            </div>
                                        </li> --}}
                                       <!--<li id="headingTwo">-->
                                       <!--    <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" href="">Partner Listing</button>-->
                                       <!--    <div id="collapseTwo" class="collapse  @if(in_array(Route::current()->getName(),['owner.manage.payment','owner.manage.partner.listing','owner.create.partner.listing','owner.add.partner.listing.payment'])) show @endif" aria-labelledby="headingTwo" data-parent="#accordionExample">-->
                                       <!--         <ul class="p-0">-->
                                       <!--             <li><a href="{{ route('owner.manage.payment') }}" @if(in_array(Route::current()->getName(),['owner.manage.payment','owner.add.partner.listing.payment'])) class="active" @endif>Manage Payment</a></li>-->
                                       <!--             <li><a href="{{ route('owner.manage.partner.listing') }}" @if(in_array(Route::current()->getName(),['owner.manage.partner.listing','owner.create.partner.listing'])) class="active" @endif>Manage Partner Listing</a></li>-->
                                       <!--         </ul>-->
                                       <!--    </div>-->
                                       <!--</li>-->
                                       <li><a href="{{ route('owner.chat') }}" @if(Route::current()->getName() == 'owner.chat') class="active" @endif>Message @if(App\Http\Helper\Helper::getTotalUnreadMesage(auth()->user()->id)>0)<i class="fa fa-bell-o notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button ">{{App\Http\Helper\Helper::getTotalUnreadMesage(auth()->user()->id)}}</span> @endif</a></li>
                                       <li><a href="{{ route('owner.cancel.booking') }}" @if(Route::current()->getName() == 'owner.cancel.booking') class="active" @endif>Cancel Booking</a></li>
                                       <li><a href="{{ route('owner.switch.to.traveller') }}" @if(Route::current()->getName() == 'owner.switch.to.traveller') class="active" @endif>Switch to Traveller</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="page-content">