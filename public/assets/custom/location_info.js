$(".location_info").on('click',function() {
    showLoader();
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var formData = {
        "property_listing_id":$("input[name=property_listing_id]").val(),
        "location":$("#location").val(),
        "iframe_link_google":$("#iframe_link").val(),
        "lat":$("#latitude").val(),
        "long":$("#longitude").val(),
    }
     $.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
    });
    $.ajax({
        url:site_url+"/admin/property-listing/location-info-store",
        type:"POST",
        cache: false,
        data: formData,
        success:function(res){
           hideLoader();
           if(res.status=='1'){
                nextStepWizard.removeAttr('disabled').trigger('click')
           }
        }
    }); 
});