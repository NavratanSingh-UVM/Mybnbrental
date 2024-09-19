@extends('admin.layouts.master')
@push('title')
   Profile Update
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
                        <div class="col-md-6"><h4 style="color:black">My Profile</h4></div>
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
                                   <form action="{{ route('admin.store.profile') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                           <div class="row mb-6">
                                             <div class="col-lg-12">
                                               <div class="col-sm-6 col-xl-6 col-xxl-6">
                                                @if(auth()->user()->image !=null)
                                                  <img src="{{ url('public/storage/profile_image/'.auth()->user()->image) }}" alt="My Profile" class="w-25">
                                                 @else
                                                <img src="{{ asset('owner-assets/img/my-profile.png') }}" alt="My Profile" class="w-25">
                                                @endif
                                                 <div class="custom-file mt-4 h-auto">
                                                 <input type="file" class="custom-file-input" hidden id="customFile" name="file">
                                               <label class="btn btn-secondary btn-lg btn-block" for="customFile">
                                                  <span class="d-inline-block mr-1"><i class="fal fa-cloud-upload"></i></span>Upload profile image</label>
                                              </div>
                                             {{-- <p class="mb-0 mt-2"> *minimum 500px x 500px </p> --}}
                                             
                                            </div>
                                              <div>
                                                 <div class="col-md-6">
                                                  <label for="inputEmail4" class="form-label">Name</label>
                                                  <input type="text" class="form-control" id="firstName" name="firstName" value="{{ Auth()->user()->name }}">
                                                    @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                 </div>
                                                  <div class="col-md-6">
                                                  <label for="inputEmail4" class="form-label">Email</label>
                                                  <input type="Email" class="form-control" id="email" name="email" value="{{ Auth()->user()->email }}">
                                                   @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                 </div>
                                                  <div class="col-md-6">
                                                  <label for="inputEmail4" class="form-label">Phone</label>
                                                  <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth()->user()->phone }}">
                                                   @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                 </div>
                                                <div class="col-md-6">
                                                 <label for="inputPassword4" class="form-label">Old Password</label>
                                                 <input type="password" class="form-control" id="oldPassword" name="oldPassword" value="{{Auth()->user()->show_password}}">
                                                  @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                 <div class="col-md-6">
                                                 <label for="inputPassword4" class="form-label">New Password</label>
                                                 <input type="password" class="form-control" id="newPassword" name="newPassword">
                                                  @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                 <div class="col-md-6">
                                                 <label for="inputPassword4" class="form-label">Confirm Password</label>
                                                 <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
                                                  @error('newPassword')
                                                     <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                              </div>
                                             </div>
                                           </div>
                                          <div class="d-flex justify-content-end flex-wrap">
                                           <button class="btn btn-lg btn-primary ml-4 mb-3">Update Profile</button>
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