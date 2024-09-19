@extends('owner.layouts.master')
@push('css')
<link rel="stylesheet" href="{{asset('traveller-assets/css/chat.css')}}" rel="text/css">
@endpush
@section('content')
  <section class="message-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                <h5> Quick replies page </h5>
                </div>
            </div>
        </div>
    </section>
@endsection