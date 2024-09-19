@extends('frontend.layouts.master')
@push('css')
<link rel="stylesheet" href="{{ asset('calender-assets/style.css') }}">
@endpush

@section('content')
<main id="content">
    <section>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pt-3 pb-3">
                    <li class="breadcrumb-item fs-12 letter-spacing-087"><a
                            href="{{ route('frontend.index') }}">Home</a></li>
                    <li class="breadcrumb-item fs-12 letter-spacing-087"><a
                            href="{{ route('frontend.property.listing') }}">Listing</a></li>
                    <li class="breadcrumb-item fs-12 letter-spacing-087 active">{{ $PropertyListing->property_name }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="container-fluid">
            <div class="position-relative" data-animate="zoomIn">
                <div class="row galleries m-n1">
                    <div class="col-lg-6 p-1">
                        <div class="item item-size-4-3">
                            <div class="card p-0 hover-zoom-in">
                                <a href="{{url('public/storage/upload/property_image/main_image/'.$PropertyListing->property_main_photos)}}"
                                    class="card-img" data-gtf-mfp="true" data-gallery-id="01"
                                    style="background-image:url({{ url('public/storage/upload/property_image/main_image/'.$PropertyListing->property_main_photos) }})"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 p-1">
                        <div class="row m-n1">
                            @if(!empty($PropertyListing->property_gallery_image))
                                @foreach($PropertyListing->property_gallery_image as $key=> $propertyGalleryImage)
                                    @if($key < 3) 
                                        <div class="col-md-6 p-1">
                                            <div class="item item-size-4-3">
                                                <div class="card p-0 hover-zoom-in">
                                                    <a href="{{ url('public/storage/upload/property_image/gallery_image/'.$propertyGalleryImage->image_name) }}" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url({{ url('public/storage/upload/property_image/gallery_image/'.$propertyGalleryImage->image_name) }})"></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($key==4)
                                        <div class="col-md-6 p-1">
                                            <div class="item item-size-4-3">
                                                <div class="card p-0 hover-zoom-in">
                                                    <a href="{{ url('public/storage/upload/property_image/gallery_image/'.$propertyGalleryImage->image_name) }}"
                                                        class="card-img" data-gtf-mfp="true" data-gallery-id="01"
                                                        style="background-image:url({{ url('public/storage/upload/property_image/gallery_image/'.$propertyGalleryImage->image_name) }})"></a>
                                                    <a href="javascript:void(0)" class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                                                        <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+{{ $PropertyListing->property_gallery_image->count()-4 }}</p>
                                                        <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View more</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="primary-content pt-8">
        <div class="container">
            <div class="row">
                <article class="col-lg-8 pr-xl-7">
                    <section class="pb-7 border-bottom">
                        <div class="d-sm-flex justify-content-sm-between">
                            <div>
                                <h2 class="fs-35 font-weight-600 lh-15 text-heading">{{ $PropertyListing->property_name}}</h2>
                                <p class="mb-0"><i class="fal fa-map-marker-alt mr-2"></i>{{ $PropertyListing->city->name??"" }}, {{ $PropertyListing->region->name??"" }},{{$PropertyListing->state->name??"" }}</p>
                            </div>
                            <div class="mt-2 text-lg-right">
                                <p class="fs-22 text-heading font-weight-bold mb-0"> @if($PropertyListing->currency->currency_name =='EURO') € @elseif($PropertyListing->currency->currency_name=='AUD') &#x20B3;@elseif($PropertyListing->currency->currency_name=='USD')
                                    &#36;@elseif($PropertyListing->currency->currency_name=='GBP') &#163; @endif {{
                                    $PropertyListing->avg_night_rates }} / {{
                                    ucfirst(trim($PropertyListing->avg_rate_unit,"ly")) }}
                                </p>
                            </div>
                        </div>
                        <h4 class="fs-22 text-heading mt-6 mb-2">Description</h4>
                        <p class="mb-0 lh-214">{!! $PropertyListing->description !!}</p>
                    </section>
                    <section class="pt-6 border-bottom">
                        <h4 class="fs-22 text-heading mb-6">Facts and Features</h4>
                        <div class="row">
                            <div class="col-lg-3 col-sm-4 mb-6">
                                <div class="media">
                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                        <i class="fa fa-bed" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                            Bedrooms</h5>
                                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{
                                            trim($PropertyListing->bedrooms,"_bedrooms") }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 mb-6">
                                <div class="media">
                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                        <i class="fa fa-bath" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                            bathrooms</h5>
                                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $PropertyListing->baths
                                            }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 mb-6">
                                <div class="media">
                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                            Guests</h5>
                                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $PropertyListing->sleeps
                                            }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 mb-6">
                                <div class="media">
                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                        <i class="fa fa-trophy" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                            Status</h5>
                                        <p class="mb-0 fs-13 font-weight-bold text-heading">Active</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="pt-6 border-bottom pb-4">
                        <h4 class="fs-22 text-heading mb-4">What this place offers</h4>
                        <div class="row">
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Property ID</dt>
                                <dd>{{ $PropertyListing->id }}</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Price</dt>
                                <dd>@if($PropertyListing->currency->currency_name =='EURO') €
                                    @elseif($PropertyListing->currency->currency_name=='AUD') &#x20B3;
                                    @elseif($PropertyListing->currency->currency_name=='GBP') &#163; @endif {{
                                    $PropertyListing->avg_night_rates}}</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Property type</dt>
                                <dd>{{ $PropertyListing->property_types->property_type_name }}</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Guest</dt>
                                <dd>{{ $PropertyListing->sleeps }}</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Bedrooms</dt>
                                <dd>{{ trim($PropertyListing->bedrooms,"_bedrooms") }}</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Size</dt>
                                <dd>{{ $PropertyListing->square_feet }}SqFt</dd>
                            </dl>
                            <dl class="col-sm-6 mb-0 d-flex">
                                <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Bathrooms</dt>
                                <dd>{{ $PropertyListing->baths }}</dd>
                            </dl>
                        </div>
                    </section>
                    <section class="pt-6 border-bottom pb-4">
                        <h4 class="fs-22 text-heading mb-4">Amenities</h4>
                        @if (!empty($PropertyListing->property_aminities))
                        @foreach ($PropertyListing->property_aminities as $mainAmminites)
                        <strong>{{ucfirst($mainAmminites->mainAmenities->aminity_name)}}</strong>
                        <ul class="list-unstyled mb-0 row no-gutters">
                            @foreach(App\Http\Helper\Helper::getSubAmenites($mainAmminites->aminities_id,$mainAmminites->property_id)
                            as $subAminity )
                            <li class="col-sm-3 col-6 mb-2"> <i class="far fa-check mr-2 text-primary"></i>
                                {{$subAminity->subAminites->name}}
                            </li>
                            @endforeach
                        </ul>
                        @endforeach
                        @endif

                    </section>
                    <section class="pt-6 border-bottom pb-4">
                        <div class="additional-rates">
                            <ul class="list-inline" style="padding-left:0">
                                @if($PropertyListing->admin_fees !=null ) <li>Admin Fees:<span> &#36; {{
                                        (float)$PropertyListing->admin_fees }}</span></li> @endif
                                @if($PropertyListing->cleaning_fees !=null ) <li>Cleaning Fees:<span> &#36; {{
                                        (float)$PropertyListing->cleaning_fees }}</span></li> @endif
                                @if($PropertyListing->refundable_damage_deposite !=null ) <li>Ref. Damage Amount:<span>
                                        &#36; {{ (float)$PropertyListing->refundable_damage_deposite }}</span></li>
                                @endif
                                @if($PropertyListing->danage_waiver !=null ) <li>Damage Waiver Amount:<span> &#36; {{
                                        (float)$PropertyListing->danage_waiver }}</span></li> @endif
                                @if($PropertyListing->peet_fee !=null ) <li>Pet Fes:<span> &#36; {{
                                        (float)$PropertyListing->peet_fee }}/{{$PropertyListing->pet_fees_unit}}</span>
                                </li> @endif
                                @if($PropertyListing->extra_person_fee !=null ) <li>Extra Person Fees:(After
                                    {{$PropertyListing->after_guest}} Guests)<span> &#36; {{
                                        (float)$PropertyListing->extra_person_fee }}</span></li> @endif
                                @if($PropertyListing->poolheating_fee !=null ) <li>Pool Heating Fees:<span> &#36; {{
                                        (float)$PropertyListing->poolheating_fee }} /
                                        {{$PropertyListing->pool_heating_fees_perday}}</span></li> @endif
                                @if($PropertyListing->tax_rates !=null ) <li>Tax Rate:<span> {{
                                        (float)$PropertyListing->tax_rates }} % </span></li> @endif

                            </ul>
                            <div class="additional-rates">
                                <h5 class="sub-title">notes:</h5>
                                <p>{!! $PropertyListing->rates_notes !!}</p>
                            </div>
                            @if ($PropertyListing->rental_policies !=null)
                            <div class="additional-rates">
                                <h5 class="sub-title">Rental Policies:</h5>
                                <p>{!! $PropertyListing->rental_policies !!}</p>
                            </div>
                            @endif
                            @if ($PropertyListing->cancelletion_policies_id !=null)
                            <div class="additional-rates">
                                <h5 class="sub-title">Cancel Rental Polices:</h5>
                                <p><strong>{!! $PropertyListing->cancelletionPolicies->name
                                        !!}:</strong><span>{{$PropertyListing->cancelletionPolicies->description}}</span>
                                </p>
                                <p><strong>Note:{{$PropertyListing->cancelletionPolicies->note}}</strong></p>
                            </div>
                            @endif
                        </div>
                    </section>
                    <section class="pt-6 border-bottom pb-4">
                        <h4 class="fs-22 text-heading mb-4">Availability</h4>
                        <div class="container">
                            <div class="row">
                                <div id="Calendars">

                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h4 class="fs-22 text-heading lh-15 mb-5 pt-3">Rating & Reviews</h4>
                        <div class="card border-0 mb-4">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-sm-6 mb-6 mb-sm-0">
                                        <div class="bg-gray-01 rounded-lg pt-2 px-6 pb-6">
                                            <h5 class="fs-16 lh-2 text-heading mb-6">Avarage User Rating</h5>
                                            <p class="fs-40 text-heading font-weight-bold mb-6 lh-1">
                                                @if($PropertyListing->reviews_rating->count() >=1) {{
                                                round($PropertyListing->reviews_rating->sum('rating')/$PropertyListing->reviews_rating->count(),1)
                                                }} @else 0 @endif <span
                                                    class="fs-18 text-gray-light font-weight-normal">/5</span></p>
                                            <ul class="list-inline">
                                                @for($i=1;$i<=5;$i++) @if($PropertyListing->reviews_rating->count() >=1)
                                                    @if($PropertyListing->reviews_rating->sum('rating')/$PropertyListing->reviews_rating->count()
                                                    >=$i)
                                                    <li
                                                        class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    @else
                                                    <li
                                                        class="list-inline-item bg-gray-04 text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    @endif
                                                    @else
                                                    <li
                                                        class="list-inline-item bg-gray-04 text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    @endif
                                                    @endfor
                                            </ul>
                                        </div>
                                    </div>
                                    @php
                                    $fiveStarRating = 0;
                                    $fourStarRating = 0;
                                    $threeStarRating = 0;
                                    $twoStarRating = 0;
                                    $oneStarRating = 0;
                                    foreach ($PropertyListing->reviews_rating as $key => $review):
                                    if ($review->rating=='5') :
                                    $fiveStarRating++;
                                    elseif ($review->rating=='4') :
                                    $fourStarRating++;
                                    elseif ($review->rating=='3') :
                                    $threeStarRating++;
                                    elseif ($review->rating=='2') :
                                    $twoStarRating++;
                                    elseif ($review->rating=='1') :
                                    $oneStarRating++;
                                    endif;
                                    endforeach;
                                    @endphp
                                    {{-- @dd($fiveStarRating); --}}
                                    <div class="col-sm-6 pt-3">
                                        <h5 class="fs-16 lh-2 text-heading mb-5">Rating Breakdown</h5>
                                        <div class="d-flex align-items-center mx-n1">
                                            <ul class="list-inline d-flex px-1 mb-0">
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="d-block w-100 px-1">
                                                <div class="progress rating-progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: @if($fiveStarRating>=1){{round(($fiveStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0}} @else 0 @endif%"
                                                        aria-valuenow="@if($fiveStarRating>=1){{   round(($fiveStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0 }}@else 0 @endif"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted px-1">@if($fiveStarRating>=1){{
                                                round(($fiveStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0
                                                }}@else 0 @endif %</div>
                                        </div>
                                        <div class="d-flex align-items-center mx-n1">
                                            <ul class="list-inline d-flex px-1 mb-0">
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="d-block w-100 px-1">
                                                <div class="progress rating-progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width:@if($fourStarRating>=1){{round(($fourStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0}}@else 0 @endif%"
                                                        aria-valuenow="@if($fourStarRating>=1){{ round(($fourStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0 }} @else 0 @endif"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted px-1">
                                                @if($fourStarRating>=1){{round(($fourStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0
                                                }}@else 0 @endif%</div>
                                        </div>
                                        <div class="d-flex align-items-center mx-n1">
                                            <ul class="list-inline d-flex px-1 mb-0">
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="d-block w-100 px-1">
                                                <div class="progress rating-progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: @if($threeStarRating>=1){{round(($threeStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0}}@else 0 @endif%"
                                                        aria-valuenow="@if($threeStarRating>=1) {{ round(($threeStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0 }} @else 0 @endif"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted px-1">
                                                @if($threeStarRating>=1){{round(($threeStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0}}@else
                                                0 @endif%</div>
                                        </div>
                                        <div class="d-flex align-items-center mx-n1">
                                            <ul class="list-inline d-flex px-1 mb-0">
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="d-block w-100 px-1">
                                                <div class="progress rating-progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width:@if($twoStarRating>=1){{round(($twoStarRating/$PropertyListing->reviews_rating->sum('rating')*100),0)??0 }} @else 0 @endif%"
                                                        aria-valuenow="@if($twoStarRating>=1) {{ round(($twoStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0 }} @else 0 @endif"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted px-1">@if($twoStarRating>=1){{
                                                round(($twoStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0
                                                }} @else 0 @endif%</div>
                                        </div>
                                        <div class="d-flex align-items-center mx-n1">
                                            <ul class="list-inline d-flex px-1 mb-0">
                                                <li class="list-inline-item text-warning mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                                <li class="list-inline-item text-border mr-1"><i
                                                        class="fas fa-star"></i></li>
                                            </ul>
                                            <div class="d-block w-100 px-1">
                                                <div class="progress rating-progress">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: @if($oneStarRating>=1){{ round(($oneStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0 }} @else 0 @endif % "
                                                        aria-valuenow="@if($oneStarRating>=1){{ round(($oneStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0 }} @else 0 @endif"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted px-1">@if($oneStarRating>=1) {{
                                                round(($oneStarRating/$PropertyListing->reviews_rating->sum('rating')*100),1)??0
                                                }} @else 0 @endif%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="pt-5">
                        <div class="card border-0 mb-4">
                            <div class="card-body p-0">
                                <h3
                                    class="fs-16 lh-2 text-heading mb-0 d-inline-block pr-4 border-bottom border-primary">
                                    {{ $PropertyListing->reviews_rating->count() }} Reviews</h3>
                                @foreach ($PropertyListing->reviews_rating as $reviews)
                                <div class="media border-top py-6 d-sm-flex d-block text-sm-left text-center">
                                    <div
                                        class="w-82px h-82 mr-2 bg-gray-01 rounded-circle fs-25 font-weight-500 text-muted d-flex align-items-center justify-content-center text-uppercase mr-sm-8 mb-4 mb-sm-0 mx-auto my-text">
                                        {{ $reviews->guest_name }}</div>
                                    <div class="media-body">
                                        <div class="row mb-1 align-items-center">
                                            <div class="col-sm-6 mb-2 mb-sm-0">
                                                <h4 class="mb-0 text-heading fs-14">{{ $reviews->guest_name }}</h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <ul
                                                    class="list-inline d-flex justify-content-sm-end justify-content-center mb-0">
                                                    @for ($i = 1; $i <=5; $i++) @if ($reviews->rating >=$i)
                                                        <li class="list-inline-item mr-1"><span
                                                                class="text-warning fs-12 lh-2"><i
                                                                    class="fas fa-star"></i></span></li>
                                                        @else
                                                        <li class="list-inline-item mr-1"><span
                                                                class="text-border fs-12 lh-2"><i
                                                                    class="fas fa-star"></i></span></li>
                                                        @endif

                                                        @endfor

                                                </ul>
                                            </div>
                                        </div>
                                        <p class="mb-3 pr-xl-17">{{ $reviews->reviews }}</p>
                                        <div class="d-flex justify-content-sm-start justify-content-center">
                                            <p class="mb-0 text-muted fs-13 lh-1">{{ date('d M
                                                y',strtotime($reviews->created_at)) }} at {{ date('h:i
                                                a',strtotime($reviews->created_at)) }}</p><a href="#"
                                                class="mb-0 text-heading border-left border-dark hover-primary lh-1 ml-2 pl-2">Reply</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <h3 class="fs-16 lh-2 text-heading mb-4">Write A Review</h3>
                                <form id="reviews">
                                    <div class="form-group mb-4 d-flex justify-content-start">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $PropertyListing->id }}">
                                        <div class="rate-input">
                                            <input type="radio" id="star5" name="rate" value="5">
                                            <label for="star5" title="text" class="mb-0 mr-1 lh-1"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star4" name="rate" value="4">
                                            <label for="star4" title="text" class="mb-0 mr-1 lh-1"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star3" name="rate" value="3">
                                            <label for="star3" title="text" class="mb-0 mr-1 lh-1"><i  class="fas fa-star"></i></label>
                                            <input type="radio" id="star2" name="rate" value="2">
                                            <label for="star2" title="text" class="mb-0 mr-1 lh-1"><i  class="fas fa-star"></i></label>
                                            <input type="radio" id="star1" name="rate" value="1">
                                            <label for="star1" title="text" class="mb-0 mr-1 lh-1"><i class="fas fa-star"></i></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <input placeholder="Your Name"
                                                    class="form-control form-control-lg border-0" name="name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <input type="email" placeholder="Email" name="email"
                                                    class="form-control form-control-lg border-0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-6">
                                        <textarea class="form-control form-control-lg border-0"
                                            placeholder="Your Review" name="message" rows="5"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary px-10 mb-2">Submit</button>
                                </form>
                            </div>
                        </div>
                    </section>
                    @if ($PropertyListing->iframe_link_google !=null)

                    <section class="py-6 border-bottom">
                        <h4 class="fs-22 text-heading mb-6">Location</h4>
                        {!! $PropertyListing->iframe_link_google !!}
                    </section>
                    @endif
                    @if($PropertyListing->youtube_video_link !=null)
                    <section class="py-6 border-bottom">
                        <h4 class="fs-22 text-heading mb-6">Video Tour</h4>
                        {!! $PropertyListing->youtube_video_link??"" !!}
                    </section>
                    @endif
                </article>
                <aside class="col-lg-4 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
                    <div class="primary-sidebar-inner">
                        <div class="card border-0 widget-request-tour">
                            <ul class="nav nav-tabs d-flex" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active px-3" data-toggle="tab" href="#schedule" role="tab"
                                        aria-selected="true">Book Now</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link px-3" data-toggle="tab" href="#request-info" role="tab"
                                        aria-selected="false">Send Message</a>
                                </li>
                            </ul>
                            <div class="card-body px-sm-6 shadow-xxs-2 pb-5">
                                <div class="tab-content pt-1 pb-0 px-0 shadow-none">
                                    <div class="tab-pane fade show active" id="schedule" role="tabpanel">
                                        <form id='bookingInformation'>
                                            @csrf
                                            <input type="hidden" name="property_id" value="{{$PropertyListing->id}}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2">
                                                        <input class="form-control form-control-lg border-0"  placeholder="Check-In" name="check_in" id="check_in"  autocomplete="off">
                                                        <span class="text-danger check_in"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2">
                                                        <input class="form-control form-control-lg border-0"
                                                            placeholder="Check-Out" name="check_out" id="check_out" autocomplete="off" onchange="calcuateRate()"><span class="text-danger check_out"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="guests" class="sr-only">Select Guest</label>
                                                        <select class="form-control form-control-lg border-0" title="guests" data-style="bg-white" id="guests" name="guests" onchange="calcuateRate()">
                                                            <option value="">Select Guests</option>
                                                            @for ($i=1;$i<=25;$i++) 
                                                                @if($i==25) 
                                                                    <option  value="{{ $i }}+">{{ $i }} + Guests</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }} Guests</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                        <span class="text-danger guests"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="children" class="sr-only">Select Children</label>
                                                        <select class="form-control form-control-lg border-0" title="children" data-style="bg-white" id="children" name="children" onchange="calcuateRate()">
                                                            <option value="">Select Children</option>
                                                            @for ($i=1;$i<=25;$i++) 
                                                                @if($i==25) 
                                                                    <option value="{{ $i }}+">{{ $i }} + Children</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }} Children</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                        <span class="text-danger children"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($PropertyListing->peet_fee !=null)
                                            <div class="petlist">
                                                <strong>Pets</strong>
                                                <ul>
                                                    <li><input type="radio" name="pet" value="1" onchange="calcuateRate()"> Yes</li>
                                                    <li><input type="radio" name="pet" value="0" onchange="calcuateRate()"> No</li>
                                                </ul>
                                            </div>
                                            @endif
                                            @if($PropertyListing->poolheating_fee !=null)
                                            <div class="petlist">
                                                <strong>Pool Heating</strong>
                                                <ul>
                                                    <li><input type="radio" name="pool_heating" value="1" onchange="calcuateRate()"> Yes</li>
                                                    <li><input type="radio" name="pool_heating" value="0" onchange="calcuateRate()"> No</li>
                                                </ul>
                                            </div>
                                            @endif
                                            <span class="text-danger pet"></span>
                                            <div class="extralisting">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Book
                                                Now</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="request-info" role="tabpanel">
                                        <p>Please fill up your booking details and owner will get back to you.</p>
                                        <form id="request-enquiry">
                                            @csrf
                                            <input type="hidden" name="property_id" value="{{ $PropertyListing->id }}">
                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-lg border-0" placeholder="Check In" name="check_in" id="start_date" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-lg border-0" placeholder="Check out" name="check_out" id="end_date" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control form-control-lg border-0" placeholder="No Of Guest" name="no_of_guest">
                                            </div>
                                            <div class="form-group mb-4">
                                                <textarea class="form-control border-0" rows="4" name="description" placeholder="Enter Your Notes"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block rounded"> Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body px-6 py-4 text-center">
                                <a href="javascript:void(0);" class="d-block mb-2">
                                    @php
                                        if($PropertyListing->owner_profile_image !=null):
                                            $imgUrl = url('public/storage/upload/owner_image/'.$PropertyListing->owner_profile_image);
                                        else:
                                            $imgUrl = asset('frontend-assets/img/3135715.png');
                                        endif;
                                    @endphp
                                    <img src="{{ $imgUrl }}" class="rounded-circle" alt="" style="width: 100px;">
                                </a>
                                <a href="#" class="fs-16 lh-214 text-dark mb-0 font-weight-500 hover-primary">{{
                                    $PropertyListing->owner_first_name
                                    !=NULL?$PropertyListing->owner_first_name:$PropertyListing->user->name }}</a>
                                <p class="mb-0">{{$PropertyListing->owner_type }}</p>
                                <a href="#" class="text-body">{{ $PropertyListing->owner_email }}</a>
                                <a href="#" class="text-heading font-weight-600 d-block mb-4">{{
                                    $PropertyListing->owner_phone }}</a>
                                <a href="javascript:void(0)"
                                    class="d-flex align-items-center justify-content-center mt-4 text-heading hover-primary">
                                    <span
                                        class="badge badge-circle border fs-13 font-weight-bold  mr-2">{{count(App\Http\Helper\Helper::ownerRelatedProperty($PropertyListing->owner_first_name,$PropertyListing->owner_first_name==NULL?$PropertyListing->user->id:""))
                                        }}</span>
                                    <span class="font-weight-500 mr-2">Listed Properties</span>
                                    <span class="text-primary fs-16"><i class="far fa-long-arrow-right"></i></span>
                                </a>
                                @if ($PropertyListing->upload_rental_polices !=null)
                                <a href="{{url('public/storage/upload/document/rental_policies/'.$PropertyListing->upload_rental_polices)}}"
                                    class="d-flex align-items-center justify-content-center mt-4 text-heading hover-primary">
                                    <span class="badge badge-circle border fs-13 font-weight-bold  mr-2">Rental Polices
                                    </span>
                                </a>
                                @endif
                                @if($PropertyListing->upload_cancel_rental_polices !=null)
                                <a href="{{url('public/storage/upload/document/rental_policies/'.$PropertyListing->upload_cancel_rental_polices)}}"
                                    class="d-flex align-items-center justify-content-center mt-4 text-heading hover-primary">
                                    <span class="badge badge-circle border fs-13 font-weight-bold  mr-2">Cancel Rental
                                        Polices</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <section class="pt-6 pb-8">
        <div class="container">
            <h4 class="fs-22 text-heading mb-6">Similar Homes You May Like</h4>
            <div class="slick-slider"
                data-slick-options="{&quot;slidesToShow&quot;: 3, &quot;dots&quot;:false,&quot;arrows&quot;:false,&quot;responsive&quot;:[{&quot;breakpoint&quot;: 1200,&quot;settings&quot;: {&quot;slidesToShow&quot;:3,&quot;arrows&quot;:false}},{&quot;breakpoint&quot;: 992,&quot;settings&quot;: {&quot;slidesToShow&quot;:2}},{&quot;breakpoint&quot;: 768,&quot;settings&quot;: {&quot;slidesToShow&quot;: 1}},{&quot;breakpoint&quot;: 576,&quot;settings&quot;: {&quot;slidesToShow&quot;: 1}}]}">
                @foreach($similarProperties as $similarProperty)
                <div class="box">
                    <div class="card shadow-hover-2">
                        <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                            <img src="{{  url('public/storage/upload/property_image/main_image/'.$similarProperty->property_main_photos) }}"
                                alt="">
                        </div>
                        <div class="card-body pt-3">
                            <h2 class="card-title fs-20 mb-0">
                                <a href="{{ route('property.listing.details',encrypt($similarProperty->id)) }}"
                                    class="text-dark hover-primary"> {{ $similarProperty->property_name }}</a>
                            </h2>
                            <p class="card-text font-weight-500 text-gray-light mb-2">{{
                                $similarProperty->city->name??"" }}, {{ $similarProperty->region->name??"" }},{{
                                $similarProperty->state->name??"" }}</p>
                            <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                                <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="{{ $similarProperty->sleeps  }} Guests"> {{
                                    $similarProperty->sleeps }} Guest</li>
                                <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="{{ trim($similarProperty->bedrooms," _bedrooms") }}
                                    Bedrooms"> {{ trim($similarProperty->bedrooms,"_bedrooms") }} Bedrooms</li>
                                <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="{{ $similarProperty->baths }} bathrooms"> {{
                                    $similarProperty->baths }} Bathrooms </li>
                            </ul>
                        </div>

                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                            <p class="fs-22 font-weight-bold text-heading mb-0">$799 <small>night</small></p>
                            <ul class="list-inline mb-0">
                                <li><a href="{{route('property.listing.details',encrypt($similarProperty->id))}}" class="bookButton">Book Now</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
</main>
<div class="position-fixed pos-fixed-bottom-right p-6 z-index-10">
    <a href="#"
        class="gtf-back-to-top bg-white text-primary hover-white bg-hover-primary shadow p-0 w-52px h-52 rounded-circle fs-20 d-flex align-items-center justify-content-center"
        title="Back To Top"><i class="fal fa-arrow-up"></i>
    </a>
</div>
@endsection
@push('js')
<script src="{{asset('frontend-assets/js/custom/custom.js')}}"></script>
<script src="{{asset('frontend-assets/js/custom/calender-avaliblity.js')}}"></script>
<script>
    $(document).ready(function(){
        disableddates = {!!App\Http\Helper\Helper::getPropertyBookingDate($PropertyListing->id)!!};
        ratesIsAvailable = {!!App\Http\Helper\Helper::getPropertyRatesWhichDate($PropertyListing->id)!!};  
        calenderAvailability("","{{$PropertyListing->id}}");
    })
</script>
@endpush