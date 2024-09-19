@extends('frontend.layouts.master')
@push('css')
<style>
    .pageheading strong {
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        color: #1e1d85;
        line-height: normal;
    }
    .pageheading p {
        letter-spacing: 2.5px;
        font-size: 16px;
    }
    .citylist {
        border-top: 1px dashed #cdcccc;
        padding-top: 20px;
    }
    .citylist h2 {
        font-size: 22px;
    }
    ul.countriesList {
        padding: 0px;
        margin: 0px;
    }
    .countriesList li {
        display: inline-block;
        vertical-align: top;
        position: relative;
        width: 24%;
        padding: 5px 0 5px 22px;
        font-size: 13px;
        text-transform: uppercase;
    }
    .countriesList li:before {
        content: "\f041";
        font-family: "font awesome 5 pro";
        position: absolute;
        left: 0;
        top: 5px;
        font-size: 16px;
    }
    .countriesList li a {
        color: #797d8a;
    }
        </style>
@endpush
@section('content')
<main id="content">
    <section class="pb-4 page-title shadow">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pt-6 pt-lg-2 lh-15 pb-5">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Properties</li>
                </ol>
                <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">Our Properties</h1>
            </nav>
        </div>
    </section>
    <section class="pt-8 pt-md-8 pb-11 bg-gray-01">
        <div class="container">
            <div class="pageheading">
                <strong>Don't Forget  ANY CORNER OF THE WORLD</strong>
                <p>SELECT AN AREA IN THE MAPS TO START THE SEARCH</p>
            </div>
            <div class="citylist">
                <h2>United States Vacation Rentals</h2>
                <ul class="countriesList">
                    @foreach($states as $state)
                        <li><a href="{{ route('frontend.property.listing',['state_id'=>$state->id]) }}">{{ $state->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</main>

@endsection