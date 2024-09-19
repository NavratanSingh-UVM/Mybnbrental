@extends('frontend.layouts.master')
@section('content')
<main id="content">
    <section>
        <div class="container">
            <form class="property-search d-none d-lg-block" action="{{route('frontend.property.listing')}}">
                <div class="row align-items-center ml-lg-0 py-lg-0 shadow-sm-2 bg-white py-lg-2 py-6 px-3 w-md-100" data-animate="fadeInDown" id="accordion-3">
                    <div class="col-md-6 col-lg-3 order-1">
                        <label class="text-uppercase font-weight-500 letter-spacing-093 mb-1">Destination Or Listing Id</label>
                        <div class="position-relative">
                            <input type="text" class="form-control bg-transparent shadow-none border-top-0 border-right-0 border-left-0 border-bottom rounded-0 h-24 lh-17 pl-0 pr-4 font-weight-600 border-color-input placeholder-muted" placeholder="Where are you going or Listing Id" id="input"  name="destination_or_listing_id"> 
                            <i class="far fa-location position-absolute pos-fixed-right-center pr-0 fs-18 mt-n3"></i>

                        </div>

                    </div>                        
                    
                    <div class="col-md-6 col-lg-3 col-xl-3 pt-6 pt-md-0 order-2">
                        <label class="text-uppercase font-weight-500 letter-spacing-093">Check In</label>
                        <div class="position-relative">
                            <input type="text" name="check_in" id="start-date" class="form-control bg-transparent shadow-none border-top-0 border-right-0 border-left-0 border-bottom rounded-0 h-24 lh-17 pl-0 pr-4 font-weight-600 border-color-input placeholder-muted" placeholder="Select Date" autocomplete="off"> <i class="far fa-calendar position-absolute pos-fixed-right-center pr-0 fs-18 mt-n3"></i> </div>
                    </div>

                    <div class="col-md-6 col-lg-3 col-xl-3 pt-6 pt-md-0 order-3">
                        <label class="text-uppercase font-weight-500 letter-spacing-093">Check Out</label>
                        <div class="position-relative">
                            <input type="text" name="check_out" id="end-date" class="form-control bg-transparent shadow-none border-top-0 border-right-0 border-left-0 border-bottom rounded-0 h-24 lh-17 pl-0 pr-4 font-weight-600 border-color-input placeholder-muted" placeholder="Select Date" autocomplete="off"> <i class="far fa-calendar position-absolute pos-fixed-right-center pr-0 fs-18 mt-n3"></i> </div>
                    </div>
                    
                    <div class="col-sm pt-6 pt-lg-0 order-sm-4 order-5">
                        <button type="submit" class="btn btn-primary shadow-none fs-16 font-weight-600 w-100 py-lg-3"> Search </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section style="height: 80vh">
        
        <div class="sabivideo_wrapper d-none d-lg-block">
            <iframe src="https://www.youtube.com/embed/eyDksYyi7is?playlist=eyDksYyi7is&rel=0&loop=1&autoplay=1&mute=1&controls=0&rel=0&showinfo=0"></iframe>
        </div>
        
        <div class="slick-slider mx-0 d-lg-none" data-slick-options='{"slidesToShow": 1, "autoplay":true,"dots":false,"arrows":true}'>
            <div class="box px-0 d-flex flex-column">
                <div class="bg-cover custom-vh-04 d-flex align-items-center" style="background-image: url({{ asset('frontend-assets/img/slider1.jpg') }})">
                </div>
            </div>
            <div class="box px-0 d-flex flex-column">
                <div class="bg-cover custom-vh-04 d-flex align-items-center" style="background-image: url({{ asset('frontend-assets/img/slider2.jpg') }})">
                </div>
            </div>
            <div class="box px-0 d-flex flex-column">
                <div class="bg-cover custom-vh-04 d-flex align-items-center" style="background-image: url({{ asset('frontend-assets/img/slider3.jpg') }})">
                </div>
            </div>
        </div>
    </section>
    <section class="pt-9 pb-9 pb-lg-11 bg-gray-04">
        <div class="container">
            <h2 class="text-center text-dark line-height-base font-weight-600">Featured Properties </h2> 
            <span class="heading-divider mx-auto mb-7"></span>
            <div class="slick-slider custom-arrow-spacing-30" data-slick-options='{"slidesToShow": 3, "autoplay":true,"dots":true,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow": 2,"arrows":false,"autoplay":true}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"autoplay":true,"arrows":false}}]}'>
                @if(!empty($featuredProperties))
                    @foreach ($featuredProperties as $featureProperty)
                        <div class="box">
                            <a href="{{ route('property.listing.details',$featureProperty->id) }}">
                                <div class="card" data-animate="fadeInUp">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top"> 
                                        <img src="{{ url('public/storage/upload/property_image/main_image/'.$featureProperty->property_main_photos)}}" alt="">
                                    </div>
                                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-22 font-weight-bold text-heading mb-0 lh-1">
                                        @php
                                        $avg_night_rates =  explode(" ",$featureProperty->avg_night_rates);
                                        @endphp
                                            @if($featureProperty->currency->currency_name =='EURO')€ @elseif($featureProperty->currency->currency_name=='USD') &#36; @elseif($featureProperty->currency->currency_name=='GBP') 	&#163; @endif {{ $featureProperty->avg_night_rates }}
                                            <small>{{ ucfirst(trim($featureProperty->avg_rate_unit,"ly")) }}</small>
                                        </p> 
                                        <span class="badge badge-primary"><a href="{{route('property.listing.details',$featureProperty->id)}}"> Book Now </a></span> 
                                    </div>
                                    <div class="card-body py-2">
                                        <h2 class="fs-20 mb-0">{{ $featureProperty->property_name??"" }}</h2>
                                        <p class="font-weight-500 text-gray-light mb-0">{{ $featureProperty->city->name??"" }}, {{ $featureProperty->region->name??"" }},{{ $featureProperty->state->name??"" }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent pt-3 pb-4">
                                        <ul class="list-inline d-flex justify-content-between mb-0 flex-wrap">
                                            <li data-toggle="tooltip" title="{{  $featureProperty->sleeps  }} Guests"> {{ $featureProperty->sleeps }} Guests </li>
                                            <li data-toggle="tooltip" title="{{  trim($featureProperty->bedrooms,"_bedrooms")}} Bedrooms"> {{  trim($featureProperty->bedrooms,"_bedrooms")}} Bedrooms </li>
                                            {{-- <li data-toggle="tooltip" title="6 Bed"> 6 Bed </li> --}}
                                            <li data-toggle="tooltip" title="{{ $featureProperty->baths }} Bathrooms"> {{ $featureProperty->baths }} Bathrooms </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="bg-accent pt-10 pb-lg-11 pb-8 bg-patten-04">
        <div class="container container-xxl">
            <h2 class="text-dark text-center mxw-751 fs-26 lh-184 px-md-8"> We have the most listings and constant updates. So you’ll never miss out.</h2> <span class="heading-divider mx-auto"></span>
            <div class="row mt-8">
                <div class="col-lg-4 mb-6 mb-lg-0" data-animate="zoomIn">
                    <div class="card border-hover shadow-2 shadow-hover-lg-1 pl-5 pr-6 py-6 h-100 hover-change-image">
                        <div class="row no-gutters">
                            <div class="col-sm-3"> <img src="{{ asset('frontend-assets/img/group-16.png') }}" alt="Buy a new home"> </div>
                            <div class="col-sm-9">
                                <div class="card-body p-0 pl-0 pl-sm-5 pt-5 pt-sm-0"> <a href="" class="d-flex align-items-center text-dark hover-secondary"><h4 class="fs-20 lh-1625 mb-1">Best Price Guarantee </h4>
                                    <span class="ml-2 text-primary fs-42 lh-1 hover-image d-inline-flex align-items-center"> 
                                        <svg class="icon icon-long-arrow"><use xlink:href="#icon-long-arrow"></use></svg></span></a>
                                    <p class="mb-0">Book with the peace of mind knowing that you will not find the same property for less anywhere else.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-6 mb-lg-0" data-animate="zoomIn">
                    <div class="card border-hover shadow-2 shadow-hover-lg-1 pl-5 pr-6 py-6 h-100 hover-change-image">
                        <div class="row no-gutters">
                            <div class="col-sm-3"> <img src="{{ asset('frontend-assets/img/group-17.png') }}" alt="Sell a home"> </div>
                            <div class="col-sm-9">
                                <div class="card-body p-0 pl-0 pl-sm-5 pt-5 pt-sm-0"> <a href="#" class="d-flex align-items-center text-dark hover-secondary"><h4 class="fs-20 lh-1625 mb-1">Book Direct. No Middleman!</h4> 
                                    <span class="ml-2 text-primary fs-42 lh-1 hover-image d-inline-flex align-items-center"> 
                                        <svg class="icon icon-long-arrow"><use xlink:href="#icon-long-arrow"></use></svg></span></a>
                                    <p class="mb-0">We do not charge any fee from travelers.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-6 mb-lg-0" data-animate="zoomIn">
                    <div class="card border-hover shadow-2 shadow-hover-lg-1 pl-5 pr-6 py-6 h-100 hover-change-image">
                        <div class="row no-gutters">
                            <div class="col-sm-3"> <img src="{{ asset('frontend-assets/img/group-21.png') }}" alt="Rent a home"> </div>
                            <div class="col-sm-9">
                                <div class="card-body p-0 pl-0 pl-sm-5 pt-5 pt-sm-0"> <a href="#" class="d-flex align-items-center text-dark hover-secondary"><h4 class="fs-20 lh-1625 mb-1">All The Privacy Of Home</h4> <span class="ml-2 text-primary fs-42 lh-1 hover-image d-inline-flex align-items-center"><svg class="icon icon-long-arrow"><use xlink:href="#icon-long-arrow"></use></svg></span></a>
                                    <p class="mb-0">Enjoy full kitchen, pool, yards, laundry and more..</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-single-image-02 py-lg-13 py-11">
        <div class="container">
            <div class="row">
                <div class="col-ld-6 col-sm-7" data-animate="fadeInLeft">
                    <div class="pl-6 border-4x border-left border-primary">
                        <h2 class="text-heading lh-15 fs-md-32 fs-25">For more information about our services,<span class="text-primary"> get in touch</span> with our expert consultants</h2>
                        <p class="lh-2 fs-md-15 mb-0">Trusted by a community of thousands of users.</p>
                    </div>
                </div>
                <div class="col-ld-6 col-sm-5 text-center mt-sm-0 mt-8" data-animate="fadeInRight"> <i class="fal fa-phone fs-40 text-primary"></i>
                    <p class="fs-13 font-weight-500 letter-spacing-173 text-uppercase lh-2 mt-3">Call for help now!</p>
                    <p class="fs-md-42 fs-32 font-weight-600 text-secondary lh-1">+1 954-655-3494</p> <a href="#" class="btn btn-lg btn-primary mt-2 px-10">Contact us</a> </div>
            </div>
        </div>
    </section>    
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">COMING SOON!!!</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('frontend-assets/img/comingsoon.jpg')}}" alt="" class="img-fluid">
                    <p>"Our website & App are currently undergoing testing as we fine-tune every aspect to ensure your vacation rental experience is nothing short of extraordinary.</p>
                    <p>Stay tuned for the big reveal, where you'll discover a treasure trove of stunning properties, unforgettable destinations, and seamless booking experiences. Your dream vacation is just a click away!"</p>
                    <p>We apologize for any inconvinience. Please check out Instagram page <a href="http://instagram.com/mybnb_rentals" target="_blank">@myBNB_rentals</a></p>
                </div>
            </div>
        </div>
    </div> 
</main>
@endsection

@push('js')
    <script src="{{asset('frontend-assets/js/auto_complete.js')}}"></script>
    <script>
        autocomplete(document.getElementById('input'));
        $(document).ready(function() {
            $("#myModal").modal('show');
            $("#start-date").datepicker({
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                defaultDate: "-1w",
                minDate: 0,
                onClose: function(selectedDate) {
                    $("#end-date").datepicker("option", "minDate", selectedDate);
                }   
            });

            $("#end-date").datepicker({
                defaultDate: "-1w",
                changeMonth: true,
                changeYear: true,
                minDate: 0,
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function(selectedDate) {
                    $("#start-date").datepicker("option", "maxDate", selectedDate);
                }
            });
        });

    </script>
@endpush