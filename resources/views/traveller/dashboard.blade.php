@extends('traveller.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
       <div class="d-flex flex-wrap flex-md-nowrap mb-6">
          <div class="mr-0 mr-md-auto">
             <h2 class="mb-0 text-heading fs-22 lh-15">Welcome back, {{auth()->user()->name}}!</h2>
             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At iusto, laboriosam. Atque</p>
          </div>
          <div>
             {{-- <a href="dashboard-add-new-property.html" class="btn btn-primary btn-lg">
                <span>Add New Property</span>
                <i class="fad fa-plus"></i>
             </a> --}}
          </div>
       </div>
       <div class="row">
          <div class="col-sm-6 col-xxl-3 mb-6">
             <div class="card">
                <div class="card-body row align-items-center px-6 py-7">
                   <div class="col-5">
                      <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-blue badge-circle">
                         <i class="fad fa-house"></i>
                      </span>
                   </div>
                   <div class="col-7 text-center">
                      <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="29" data-decimals="0" data-duration="0" data-separator="">29</p>
                      <p>Total Properties</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-sm-6 col-xxl-3 mb-6">
             <div class="card">
                <div class="card-body row align-items-center px-6 py-7">
                   <div class="col-5">
                      <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-green badge-circle">
                         <i class="fad fa-bell"></i>
                      </span>
                   </div>
                   <div class="col-7 text-center">
                      <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="1730" data-decimals="0" data-duration="0" data-separator="">1730</p>
                      <p>Total Bookings</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-sm-6 col-xxl-3 mb-6">
             <div class="card">
                <div class="card-body row align-items-center px-6 py-7">
                   <div class="col-4">
                      <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-yellow badge-circle">
                         <i class="fad fa-eye"></i>
                      </span>
                   </div>
                   <div class="col-8 text-center">
                      <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="329" data-decimals="0" data-duration="0" data-separator="">329</p>
                      <p>Total Visitor Reviews</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-sm-6 col-xxl-3 mb-6">
             <div class="card">
                <div class="card-body row align-items-center px-6 py-7">
                   <div class="col-5">
                      <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-pink badge-circle">
                         <i class="fad fa-money-bill"></i>
                      </span>
                   </div>
                   <div class="col-7 text-center">
                      <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="914" data-decimals="0" data-duration="0" data-separator="">914</p>
                      <p>Total Payments</p>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
            <div class="col-xxl-4 mb-6">
                <div class="card px-7 py-6 h-100">
                    <div class="card-body p-0">
                        <h2 class="mb-2 text-heading fs-22 lh-15">Recent Activities</h2>
                    </div>
                </div>
            </div>
       </div>
    </div>
 </main>
@endsection