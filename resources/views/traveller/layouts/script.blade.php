</div>
</div>
</div>
<script src="{{asset('traveller-assets/vendors/jquery.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/slick/slick.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/counter/countUp.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/dropzone/js/dropzone.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/hc-sticky/hc-sticky.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/jparallax/TweenMax.min.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/mapbox-gl/mapbox-gl.js')}}"></script>
<script src="{{asset('traveller-assets/vendors/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('traveller-assets/js/theme.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(".alert-block").delay(3200).fadeOut(300);
    function showLoader(){
        $("#loader").removeClass('d-none');
    }
    function hideLoader(){
        $("#loader").addClass('d-none');
    }
    let site_url = {!! json_encode(url("/"))!!}
</script>
@stack('js')
