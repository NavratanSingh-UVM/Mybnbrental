@php
    $routeMaster = ['admin.master.manage.main.aminity','admin.master.create.main.aminity','admin.master.edit.main.aminities','admin.master.manage.sub.aminity','admin.master.create.sub.aminity','admin.master.edit.sub.aminities'];
    $routeLocationCountry = ['admin.location.country','admin.location.country.create','admin.location.country.edit'];
    $routeLocationState = ['admin.location.state','admin.location.state.create','admin.location.state.edit'];
    $routeLocationRegion = ['admin.location.region','admin.location.region.create','admin.location.region.edit'];
    $routeLocationCity = ['admin.location.city','admin.location.city.create','admin.location.city.edit'];
    $routeLocationCities = ['admin.location.cities','admin.location.cities.create','admin.location.cities.edit'];
@endphp
<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['admin.user.management'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.user.management') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.user.management'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">User Management</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['admin.manage.owner.billing.detail'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.manage.owner.billing.detail') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.manage.owner.billing.detail'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Owner Billing Details</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),array_merge($routeLocationCountry,$routeLocationState,$routeLocationRegion,$routeLocationCity,$routeLocationCities))) class="mega-menu mega-menu-sm active" @endif>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Location</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.location.country') }}" @if(in_array(request()->route()->getName(),$routeLocationCountry)) class="active" @endif>Manage Country</a></li>
                            <li><a href="{{ route('admin.location.state') }}" @if(in_array(request()->route()->getName(),$routeLocationState)) class="active" @endif>Manage State</a></li>
                            <li><a href="{{ route('admin.location.region') }}" @if(in_array(request()->route()->getName(),$routeLocationRegion)) class="active" @endif>Manage Region</a></li>
                            <li><a href="{{ route('admin.location.city') }}" @if(in_array(request()->route()->getName(),$routeLocationCity)) class="active" @endif>Manage City</a></li>
                            <li><a href="{{ route('admin.location.cities') }}" @if(in_array(request()->route()->getName(),$routeLocationCities)) class="active" @endif>Manage Cites</a></li>
                        </ul>
                    </li>
                    <li @if(in_array(request()->route()->getName(),$routeMaster)) class="mega-menu mega-menu-sm active" @endif>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i> <span class="nav-text">Amenites</span>
                        </a>
                        <ul aria-expanded="false">
                            <li @if (in_array(request()->route()->getName(),['admin.master.manage.main.aminity','admin.master.create.main.aminity','admin.master.edit.main.aminities']))class="active"@endif><a href="{{ route('admin.master.manage.main.aminity') }}">Manage Main Amenites</a></li>
                            <li @if (in_array(request()->route()->getName(),['admin.master.manage.sub.aminity','admin.master.create.sub.aminity','admin.master.edit.sub.aminities']))class="active"@endif><a href="{{ route('admin.master.manage.sub.aminity') }}">Manage Sub Amenites </a></li>
                        </ul>
                    </li>

                    <li @if(in_array(request()->route()->getName(),['admin.property.listing.index','admin.property.listing.create'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.property.listing.index') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.property.listing.index'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Manage Listing</span>
                        </a>
                    </li>

                    <li @if(in_array(request()->route()->getName(),['admin.owner.subscription'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.owner.subscription') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.owner.subscription'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Featured Listing Subscription</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['property.booking_details'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.property.booking_details') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['property.booking_details'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Property Booking Details</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['admin.partner.listing.manage.payment','admin.partner.listing.manage.listing'])) class="mega-menu mega-menu-sm active" @endif>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i> <span class="nav-text">Partner Listng</span>
                        </a>
                        <ul aria-expanded="false">
                            <li @if (in_array(request()->route()->getName(),['admin.partner.listing.manage.payment']))class="active"@endif><a href="{{ route('admin.partner.listing.manage.payment') }}">Manage Payment</a></li>
                            <li @if (in_array(request()->route()->getName(),['admin.partner.listing.manage.listing']))class="active"@endif><a href="{{ route('admin.partner.listing.manage.listing') }}">Manage Listing</a></li>
                        </ul>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['admin.cancel.booking.list'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.cancel.booking.list') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.cancel.booking.list'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Cancel Booking</span>
                        </a>
                    </li>
                    <li @if(in_array(request()->route()->getName(),['owner.payment.reminder'])) class="mega-menu mega-menu-sm active" @endif>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Email Template</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.email.template.payment.reminder') }}" @if(in_array(request()->route()->getName(),['admin.email.templatepayment.reminder'])) class="active" @endif>Payment Reminder</a></li>
                            <li><a href="{{ route('admin.email.template.cancellation.message') }}" @if(in_array(request()->route()->getName(),['admin.email.template.cancellation.message'])) class="active" @endif>Cancellation</a></li>
                            <li><a href="{{ route('admin.email.template.welcome.message') }}" @if(in_array(request()->route()->getName(),['admin.email.template.store.welcome.message'])) class="active" @endif>Welcome Message</a></li>
                            <li><a href="{{ route('admin.email.template.invite.to.leave.a.review') }}" @if(in_array(request()->route()->getName(),['admin.email.template.invite.to.leave.a.review'])) class="active" @endif>Invite To Leave A Review</a></li>
                        </ul>
                    </li>
                     <li @if(in_array(request()->route()->getName(),['admin.tax.list'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.tax.list') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.tax.list'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text"> Tax </span>
                        </a>
                    </li>
                     <li @if(in_array(request()->route()->getName(),['admin.insurance.list'])) class="mega-menu mega-menu-sm active" @endif>
                        <a href="{{ route('admin.insurance.list') }}" aria-expanded="false" @if(in_array(request()->route()->getName(),['admin.insurance.list'])) class="active" @endif>
                            <i class="icon-grid menu-icon"></i><span class="nav-text"> Insurance </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->