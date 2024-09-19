@extends('frontend.layouts.master')
@section('content')
<div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <div class="border border-3 border-danger"></div>
        <div class="card  bg-white shadow p-5">
            <div class="mb-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="100" height="100" fill="currentColor" class="bi bi-check-circle" width="100" height="100" viewBox="0 0 48 48">
                    <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path><path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
                </svg>
            </div>
            <div class="text-center">
                <h1>Payment Failed !</h1>
                <p>{{Session::get('error')}} </p>
                <a href="{{route('frontend.index')}}">
                    <button class="btn btn-outline-danger">Back Home</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection