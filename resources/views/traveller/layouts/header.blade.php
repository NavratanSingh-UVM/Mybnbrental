<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>My BNB Rentals</title>
        <script src="{{asset('traveller-assets/js/font.js')}}"></script>

        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&amp;family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/fontawesome-pro-5/css/all.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/bootstrap-select/css/bootstrap-select.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/slick/slick.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/magnific-popup/magnific-popup.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/jquery-ui/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/chartjs/Chart.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/dropzone/css/dropzone.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/animate.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/timepicker/bootstrap-timepicker.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/mapbox-gl/mapbox-gl.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/vendors/dataTables/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/css/themes.css')}}">
        <link rel="stylesheet" href="{{asset('traveller-assets/css/admincustom.css')}}">
        <link rel="icon" href="{{asset('traveller-assets/img/favicon.png')}}"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        @stack('css')
    </head>
<body>
        <div class="loader1 d-none" id="loader">
            <img src="{{ asset('assets/images/loader/200w.gif') }}" alt="" srcset="">
            <span>Please Wait .....</span>
        </div>
      <div class="wrapper dashboard-wrapper">
         <div class="d-flex flex-wrap flex-xl-nowrap">