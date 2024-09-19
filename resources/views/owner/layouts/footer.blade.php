        </div>
    </div>
</div>
<script src="{{ asset('owner-assets/vendors/jquery.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/slick/slick.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/counter/countUp.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/chartjs/Chart.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/dropzone/js/dropzone.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/hc-sticky/hc-sticky.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/jparallax/TweenMax.min.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/mapbox-gl/mapbox-gl.js')}}"></script>
<script src="{{ asset('owner-assets/vendors/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('owner-assets/js/theme.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script> --}}
<script src="{{ asset('assets/js/fullcalender.js') }}"></script>

<script>
    $(".alert-block").delay(3200).fadeOut(300);
    function showLoader(){
        $("#loader").removeClass('d-none');
    }
    function hideLoader(){
        $("#loader").addClass('d-none');
    }
    $(document).ready(function() {
            $('.select').select2();
    });
    let site_url = {!! json_encode(url("/"))!!}
</script>
@stack('js')
</body>
</html>