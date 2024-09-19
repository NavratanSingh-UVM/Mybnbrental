@extends('frontend.layouts.master')
@push('css')
    <style>
        .customsearch input{
            width: 100% !important;
        }
        .form-search-01 .btn{
            width: 188px;
        }
        .form-search-01 a.btn{
            color: #ffffff !important;
        }
    </style>
@endpush
@section('content')
<main id="content">
    <section class="pb-4 page-title shadow">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('location.property') }}">USA</a></li>
                    {{-- <li class="breadcrumb-item @if(request()->input('type')=='state') active @endif" aria-current="page">
                        @if(request()->input('type')=='region' || $types=='Region')
                            <a href="{{ route('frontend.property.listing',['state_id'=>$state_name->id,'type'=>"state"]) }}"> {{ $state_name->name??"" }}</a>
                        @else
                            {{ $state_name?->name }}
                        @endif
                    </li> --}}
                    {{-- @dd($types); --}}
                    {{-- @if(request()->input('type')=='region' && request()->input('type') !='city' || $types =='Region')
                        <li class="breadcrumb-item" aria-current="page">{{ $region_name->name??"" }}</li>
                    @elseif(request()->input('type')=='city' || $types=='City')
                        <li class="breadcrumb-item @if(request()->input('type')=='region') active @endif" aria-current="page"> <a href="{{ route('frontend.property.listing',['state_id'=>$state_name->id,'type'=>"region","region"=>$region_name->id]) }}"> {{$region_name->name??"" }}</a></li>
                    @endif --}}
                    {{-- @if (request()->input('type')=='city' || $types=='City')
                        <li class="breadcrumb-item active" aria-current="page">{{ $city_name->name??"" }}</li>
                    @endif --}}
                    {{-- @dd($types) --}}
                    {{-- @if(request()->input('type')=='sub_city' && request()->input('type') !='city' || $types =='sub_city')
                        <li class="breadcrumb-item @if(request()->input('type')=='region') active @endif" aria-current="page"> <a href="{{ route('frontend.property.listing',['state_id'=>$state_name->id,'type'=>"city","region"=>$region_name->id,'city'=>$city_name->id]) }}"> {{$cityName->name??"" }}</a></li>
                    @endif --}}
                    {{-- @if (request()->input('type')=='sub_city')
                        <li class="breadcrumb-item active" aria-current="page">{{ $subCityName->name??"" }}</li>
                    @endif --}}
                </ol>
                {{-- @if(request()->input('type')=='state')
                    <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ $state_name->name??"" }} Vacation Rentals</h1>
                @elseif (request()->input('type')=='region')
                    <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ $region_name->name??"" }} Vacation Rentals</h1>
                @elseif (request()->input('type')=='city')
                <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ $city_name->name??"" }} Vacation Rentals</h1>
                @elseif (request()->input('type')=='sub_city')
                <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">{{ $subCityName->name??"" }} Vacation Rentals</h1>
                @endif --}}
                <div class="mt-6 form-search-01">
                    @include('frontend.filter')
                </div>
            </nav>
        </div>
    </section>
    <section class="pt-8 pt-md-8 pb-11 bg-gray-01">
        <div class="container">
            <div class="row">
                @if (!empty($properties) && count($properties)>0)
                    @foreach ($properties as $property)
                    <a href="{{ route('property.listing.details',$property->id) }}" class="text-dark hover-primary">
                        <div class="col-lg-4 col-md-6 pb-6">
                            <div class="card shadow-hover-2" data-animate="fadeInUp">
                                <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top"> 
                                    <img src="{{  url('public/storage/upload/property_image/main_image/'.$property->property_main_photos) }}" alt="">
                                </div>
                                <div class="card-body pt-3">
                                    <h2 class="card-title fs-20 mb-0">
                                        {{ $property->property_name }}</h2>
                                        <p class="card-text font-weight-500 text-gray-light mb-2">{{ $property->city->name??"" }}, {{ $property->region->name??"" }},{{ $property->state->name??"" }}</p>
                                    <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                                        <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="{{ $property->sleeps }} Guests"> {{ $property->sleeps }} Guests </li>
                                        <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="{{  trim($property->bedrooms,"_bedrooms")}} Bedrooms"> {{  trim($property->bedrooms,"_bedrooms")}} Bedrooms </li>
                                        {{-- <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="6 Beds"> 6 Be</li> --}}
                                        <li class="list-inline-item text-gray fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="{{ $property->baths }} bathrooms"> {{ $property->baths }} Bath </li>
                                    </ul>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                    <p class="fs-22 font-weight-bold text-heading mb-0">
        
                                         @if($property->currency->currency_name =='EURO') € @elseif($property->currency->currency_name=='USD') &#36; @elseif($property->currency->currency_name=='GBP') 	&#163; @endif {{ $property->avg_night_rates }}
                                        <small>{{ ucfirst(trim($property->avg_rate_unit,"ly")) }}</small>
                                    </p>
                                    <ul class="list-inline mb-0">
                                        <li><a href="{{route('property.listing.details',$property->id)}}" class="bookButton">Book Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                @else
                    <h1 class="mx-auto">Record Not Found</h1>
                @endif
            </div>
            <nav class="pt-6">
                <ul class="pagination rounded-active justify-content-center mb-0">
                    @if ($properties->lastPage() >1)
                        <li class="{{ ($properties->currentPage() == 1) ? ' disabled' : '' }} page-item">
                            <a class="page-link" href="{{ $properties->url($properties->currentPage()-1) }}">
                                <i class="far fa-angle-double-left"></i><
                            </a> 
                        </li>
                        @for ($i = 1; $i <= $properties->lastPage(); $i++)
                            <li class="{{ ($properties->currentPage() == $i) ? ' active' : '' }} page-item"><a class="page-link" href="{{ $properties->url($i) }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item {{ ($properties->currentPage() == $properties->lastPage()) ? ' disabled' : '' }}"><a class="page-link" href="{{ $properties->url($properties->currentPage()+1) }}"><i class="far fa-angle-double-right"></i></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </section>
</main>
@endsection
@push('js')
    <script src="{{asset('frontend-assets/js/auto_complete.js')}}"></script>
    <script src="{{asset('assets/custom.js')}}"></script>
    <script>
        autocomplete(document.getElementById('input'));
        $(function() {
            $('#start_date').datepicker({ 
                defaultDate: "-1w",
                dateFormat: "mm/dd/yy",
                minDate: 0,
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function(selectedDate) {
                    $("#end_date").datepicker("option", "minDate", selectedDate);
                }
            });
            $('#end_date').datepicker({ 
                dateFormat: "mm/dd/yy",
                defaultDate: "-1w",
                minDate: 0,
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function(selectedDate) {
                    $("#end_date").datepicker("option", "maxDate", selectedDate);
                }
            });
        })
    </script>
@endpush