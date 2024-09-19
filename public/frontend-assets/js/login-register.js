$(function () {
    $("#toggle_password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
       var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#password").attr("type", type);
    });
});
$(function () {
    $("#toggle_pwd").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
       var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#reg_password").attr("type", type);
    });
});

$(function () {
    $("#toggle_cfpwd").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
       var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
        $("#cnf_password").attr("type", type);
    });
});
$("#owner-register-form").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/auth/owner-register",
        type: "POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(res){
            hideLoader();
            if(res.status=='1'){
                toastr.success(res.msg);
                // window.setTimeout(() => {
                //     window.location.href=res.url; 
                //  }, 2000);
                $('#owner-register-form')[0].reset();
                $("#login-register-modal").modal('show');
                $('#myTab a[href="#login"]').tab('show')
            }else{
                toastr.error(res.msg);
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
            $(".full_name_error").text("");
            $(".username_error").text("");
            $(".country_code_error").text("");
            $(".phone_error").text("");
            $(".password_error").text("");
            $(".cnf_password_error").text("");
            $(".verify_error").text("");
            $(".type_error").text("");
            let error = xhr.responseJSON.errors;
            $(".full_name_error").text(error.full_name);
            $(".username_error").text(error.username);
            $(".country_code_error").text(error.country_code);
            $(".phone_error").text(error.phone);
            $(".password_error").text(error.password);
            $(".cnf_password_error").text(error.cnf_password);
            $(".verify_error").text(error.verify);
            $(".verify_error").text(error.phone);
            $(".type_error").text(error.type);
        }
    })
})

$("#owner_login_form").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/auth/owner-login",
        type: "POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(res){
            hideLoader();
            if(res.status=='1'){
                toastr.success(res.msg);
                window.setTimeout(() => {
                    window.location.href=res.url; 
                 }, 2000);

            }else{
                toastr.error(res.msg);
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
            $(".username_error").text("");
            $(".password_error").text("");
            let error = xhr.responseJSON.errors;
            $(".username_error").text(error.username);
            $(".password_error").text(error.password);
        }
    })
})