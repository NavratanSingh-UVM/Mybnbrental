$(".create_property").on("click",function() {
    showLoader();

    var formData = new FormData();
    let property_listing_id = $("input[name='property_listing_id']").val();
    let first_name = $("input[name='first_name']").val();
    let last_name = $("input[name='last_name']").val();
    let phone = $("input[name='phone']").val();
    let owner_address = $("input[name='owner_address']").val();
    let email = $("input[name='email']").val();
    let city = $("input[name='city']").val();
    let ouwner = $("input[name='ouwner']").val();
    let state = $("input[name='state']").val();
    let zipcode = $("input[name='zipcode']").val();
    let owner_fax = $("input[name='owner_fax']").val();
    let owner_old_profile_image = $("input[name='owner_old_image']").val();
    let owner_profile_image = $("#profile_image").prop('files')[0] !=undefined?$("#profile_image").prop('files')[0]:"";
    formData.append("property_listing_id",property_listing_id);
    formData.append("first_name",first_name);
    formData.append("last_name",last_name);
    formData.append("phone",phone);
    formData.append("owner_address",owner_address);
    formData.append("email",email);
    formData.append("city",city);
    formData.append("owner_type",ouwner);
    formData.append("state",state);
    formData.append("zipcode",zipcode);
    formData.append("owner_fax",owner_fax);
    formData.append("owner_profile_image",owner_profile_image);
    formData.append("owner_old_profile_image",owner_old_profile_image);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:site_url+"/admin/property-listing/store-owner_information",
        type:"POST",
        contentType: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success:function(res){
            if(res.status=='1'){
                hideLoader();
                toastr.success(res.msg)
                window.setTimeout(() => {
                    window.location.href=res.url; 
                 }, 2000);
            }
        }
    });


});