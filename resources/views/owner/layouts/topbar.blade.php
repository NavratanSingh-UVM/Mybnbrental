            <header class="main-header shadow-none shadow-lg-xs-1 bg-white position-relative d-none d-xl-block">
                <div class="container-fluid">
                    <nav class="navbar navbar-light py-0 row no-gutters px-3 px-lg-0">
                        <div class="col-md-12 d-flex flex-wrap justify-content-md-end order-0 order-md-1">
                            <div class="dropdown border-0 py-1 text-right">
                                <a href="#" class="dropdown-toggle text-heading pr-3 pr-sm-6 d-flex align-items-center justify-content-end" data-toggle="dropdown">
                                    <div class="mr-4 w-48px">
                                        @if (auth()->user()->image ==null)
                                            <img src="{{asset('owner-assets/img/agent-1.jpg')}}" alt="" srcset="">
                                        @else
                                            <img src="{{ url('public/storage/profile_image/'.auth()->user()->image) }}" alt=" {{ Auth()->user()->name }}" class="rounded-circle">
                                        @endif                                    </div>
                                    <div class="fs-13 font-weight-500 lh-1">
                                        {{ Auth()->user()->name }}
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right w-100">
                                    <a class="dropdown-item" href="{{ route('owner.edit.profile') }}">My Profile</a>
                                    <a class="dropdown-item" href="{{ route('owner.logout') }}">Logout</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>