    <script src="{{ asset('frontend-assets/vendors/jquery.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/slick/slick.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/waypoints/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/counter/countUp.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/dropzone/js/dropzone.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/hc-sticky/hc-sticky.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/jparallax/TweenMax.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/mapbox-gl/mapbox-gl.js')}}"></script>
    <script src="{{ asset('frontend-assets/vendors/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('frontend-assets/js/theme.js')}}"></script>
    <script src="{{ asset('frontend-assets/js/login-register.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
    {{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}
    <script>
        let site_url = {!! json_encode(url('/'))!!}
        function showLoader(){
            $(".loading").removeClass('d-none');
        }
        function hideLoader(){
            $(".loading").addClass('d-none');
        }
        showPassword =()=>{
            var x = document.getElementById("password");
            if(x.type === "password"){
                x.type = "text";
            }else{
                x.type = "password";
            }
        }
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    @stack('js')
   
</body>
</html>
    