@extends('admin.layouts.master')
@push('title')
    Craete Main Aminity
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
                        <div class="col-md-6"><h4 style="color:black">Manage Main Aminity</h4></div>
                        <div class="col-md-6 text-right"><a href="{{ route('admin.master.manage.sub.aminity') }}" class="btn mb-1 btn-primary float-right">Back <span class="btn-icon-right"><i class="fa fa-angle-double-left"></i></span>
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
                                    <form class="form-valide" method="post" action="{{ route('admin.master.store.sub.aminities') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Main Aminity <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="main_aminity_name">
                                                    <option value="">Select main Aminites</option>
                                                    @foreach ($mainAminities as $aminities)
                                                        <option value="{{ $aminities->id }}">{{ $aminities->aminity_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('main_aminity_name')
                                                 <span class="text-danger">{{ $message }}</span>   
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Aminity Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="sub_aminity_name" placeholder="Enter a aminity.." value="{{ old('sub_aminity_name') }}">
                                                @error('sub_aminity_name')
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