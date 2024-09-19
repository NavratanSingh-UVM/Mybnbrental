@extends('traveller.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
   <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
    @include('flash-message.flash-message')
      <div class="mb-6">
         <h2 class="mb-0 text-heading fs-22 lh-15">My Profile</h2>
      </div>
      <form action="{{ route('traveller.store.profile') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row mb-6">
            <div class="col-lg-12">
               <div class="card mb-6">
                  <div class="card-body px-6 pt-6 pb-5">
                     <div class="row">
                        <div class="col-sm-6 col-xl-6 col-xxl-6">
                           @if(auth()->user()->image !=null)
                           <img src="{{ url('public/storage/profile_image/'.auth()->user()->image) }}" alt="My Profile" class="w-25">
                           @else
                           <img src="{{ asset('owner-assets/img/my-profile.png') }}" alt="My Profile" class="w-25">
                           @endif
                           <div class="custom-file mt-4 h-auto">
                              <input type="file" class="custom-file-input" hidden id="customFile" name="file">
                              <label class="btn btn-secondary btn-lg btn-block" for="customFile">
                              <span class="d-inline-block mr-1"><i class="fal fa-cloud-upload"></i></span>Upload
                              profile image</label>
                           </div>
                           {{-- <p class="mb-0 mt-2">
                              *minimum 500px x 500px
                           </p> --}}
                        </div>
                        <div class="form-group col-md-6 px-4">
                            <label for="firstName" class="text-heading">Name</label>
                            <input type="text" class="form-control form-control-lg border-0" id="firstName" name="firstName" value="{{ Auth()->user()->name }}">
                        </div>
                        <div class="form-group col-md-6 px-4">
                            <label for="lastName" class="text-heading">Email</label>
                            <input type="email" class="form-control form-control-lg border-0" id="email" name="email" value="{{ Auth()->user()->email }}">
                        </div>
                        <div class="form-group col-md-6 px-4">
                            <label for="phone" class="text-heading">Phone</label>
                            <input type="number" class="form-control form-control-lg border-0" id="phone" name="phone" value="{{ Auth()->user()->phone }}">
                        </div>
                        <div class="form-group col-md-6 px-4">
                            <label for="oldPassword" class="text-heading">Old Password</label>
                            <input type="password" class="form-control form-control-lg border-0" id="oldPassword" name="oldPassword" value={{Auth()->user()->show_password}}>
                        </div>
                        <div class="form-group px-4 col-md-6 px-4">
                            <label for="newPassword" class="text-heading">New Password</label>
                            <input type="password" class="form-control form-control-lg border-0" id="newPassword" name="newPassword">
                            @error('newPassword')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 px-4">
                            <label for="confirmNewPassword" class="text-heading ">Confirm New Password</label>
                            <input type="password" class="form-control form-control-lg border-0" id="confirmNewPassword" name="confirmNewPassword">
                            @error('confirmNewPassword')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="d-flex justify-content-end flex-wrap">
            <button class="btn btn-lg btn-primary ml-4 mb-3">Update Profile</button>
         </div>
    </form>
   </div>
</main>
@endsection