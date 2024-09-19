
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>BNB Rentals Admin Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend-assets/img/favicon.png') }}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body class="h-100">
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="javascript:void();"> <h4>BNB Rental Forget Password</h4></a>
                                <form class="mt-5 mb-5 login-input" id="forgetPasswordLink">
                                    <div class="form-group">
                                        @csrf
                                        <input type="email" class="form-control" placeholder="Email" name="email" autocomplete="off">
                                        <span class="text-danger error-email"></span>
                                    </div>
                                    <button class="buttonload submit w-100 btn d-none">
                                        <i class="fa fa-refresh fa-spin"></i>Please wait...
                                    </button>
                                    <button class="btn login-form__btn submit w-100"  type="submit">Send Password Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('assets/plugins/common/common.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script>
       $("#forgetPasswordLink").on("submit",function(e){
            e.preventDefault();
            $(".buttonload").removeClass("d-none");
            $(".buttonload").addClass("disabled");
            $(".login-form__btn").addClass("d-none");
            let formData = new FormData($("#forgetPasswordLink")[0]);
            $.ajax({
                type: 'POST',
                url:"{{ route('admin.send.forget.password.link') }}",
                data:formData,
                contentType: false,
                processData: false,
                cache:false,
                success:function(res){
                    if(res.status=='1'){
                        toastr.success(res.msg)
                        $("#forgetPasswordLink")[0].reset(0);
                        $(".buttonload").addClass("d-none");
                        $(".buttonload").removeClass("disabled");
                        $(".login-form__btn").removeClass("d-none");
                    }else if(res.status==='500'){
                        toastr.error(res.msg);
                        $(".buttonload").addClass("d-none");
                        $(".buttonload").removeClass("disabled");
                        $(".login-form__btn").removeClass("d-none");
                    }
                    else {
                        toastr.error(res.msg);
                        $(".buttonload").addClass("d-none");
                        $(".buttonload").removeClass("disabled");
                        $(".login-form__btn").removeClass("d-none");
                    
                    }
                },error: function(xhr, ajaxOptions, thrownError){
                    if(xhr.responseJSON.status==500) {
                        toastr.error(xhr.responseJSON.msg);
                        $(".buttonload").addClass("d-none");
                        $(".buttonload").removeClass("disabled");
                        $(".login-form__btn").removeClass("d-none");
                    }else{
                        let error = xhr.responseJSON.errors;
                        $(".error-email").text(error.email);
                        $(".error-password").text(error.password);
                        $(".buttonload").addClass("d-none");
                        $(".buttonload").removeClass("disabled");
                        $(".login-form__btn").removeClass("d-none");
                    }
                }
            });
        });
    </script>
</body>
</html>
