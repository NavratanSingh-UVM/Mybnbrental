<!doctype html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>My BNB Rentals</title>
        <script src="{{ asset('frontend-assets/js/font.js') }}"></script>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&amp;family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/fontawesome-pro-5/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/slick/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/magnific-popup/magnific-popup.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/chartjs/Chart.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/dropzone/css/dropzone.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/timepicker/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/mapbox-gl/mapbox-gl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/vendors/dataTables/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend-assets/css/themes.css') }}">
        <link rel="icon" href="{{ asset('frontend-assets/img/favicon.png') }}"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        @stack('css')
    </head>
    <body class="topheader">
        <div class="loading d-none">Please Wait &#8230;</div>