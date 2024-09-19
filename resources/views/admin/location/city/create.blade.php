@extends('admin.layouts.master')
@push('title')
    Create City
@endpush
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    @include('flash-message.flash-message')
                    <div class="row">
                        <div class="col-md-6"><h4 style="color:black">Create City</h4></div>
                        <div class="col-md-6 text-right"><a href="{{ route('admin.location.city') }}" class="btn mb-1 btn-primary float-right">Back <span class="btn-icon-right"><i class="fa fa-angle-double-left"></i></span>
                        </a> </div>                                
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" method="post" action="{{ route('admin.location.city.store') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="country_name">Country Name<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="country_name" id="country_name">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" @selected(old('country_name')==$country->id)>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_name')
                                                 <span class="text-danger">{{ $message }}</span>   
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="state_name">State Name<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="state_name" id="state_name">
                                                    <option value="">Select State</option>
                                                </select>
                                                @error('state_name')
                                                 <span class="text-danger">{{ $message }}</span>   
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="region_name">Region Name<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="region_name" id="region_name">
                                                    <option value="">Select Region</option>
                                                </select>
                                                @error('region_name')
                                                 <span class="text-danger">{{ $message }}</span>   
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="city_name">City Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="city_name" name="name" placeholder="Enter a city.." value="{{ old('name') }}">
                                                @error('name')
                                                 <span class="text-danger">{{ $message }}</span>   
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection
@push('js')
<script src="{{ asset('assets/custom.js') }}"></script>
    
@endpush