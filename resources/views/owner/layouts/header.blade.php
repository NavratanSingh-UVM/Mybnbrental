<!doctype html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="">
        <title>My BNB Rentals</title>
        <script src="{{ asset('owner-assets/js/font.js') }}"></script>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&amp;family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/fontawesome-pro-5/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/bootstrap-select/css/bootstrap-select.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/slick/slick.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/magnific-popup/magnific-popup.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/jquery-ui/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/chartjs/Chart.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/dropzone/css/dropzone.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/animate.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/timepicker/bootstrap-timepicker.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/mapbox-gl/mapbox-gl.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/vendors/dataTables/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/css/themes.css')}}">
        <link rel="stylesheet" href="{{ asset('owner-assets/css/admincustom.css')}}">
       
        <link rel="icon" href="{{ asset('owner-assets/img/favicon.png') }}"> 
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        @stack('css')
    </head>
<body>
    <div class="loader1 d-none" id="loader">
        <img src="{{ asset('assets/images/loader/200w.gif') }}" alt="" srcset="">
        <span>Please Wait .....</span>
    </div>
    <div class="wrapper dashboard-wrapper">
        <div class="d-flex flex-wrap flex-xl-nowrap">
            