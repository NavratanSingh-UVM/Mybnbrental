$(".sync_now").on("click",function () {
    showLoader();
    
    let import_calender_url = $("input[name=import_calender_url]").val();
    let property_listing_id = $("input[name=property_listing_id]").val() !=""?$("input[name=property_listing_id]").val():1;
    let formData = {
        property_listing_id:property_listing_id,
        import_calender_url:import_calender_url,
    };
    $.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    $.ajax({
		type:'POST',
		url: site_url+"/admin/property-listing/calender-synchronization",
		data: formData,
		cache:false,
		dataType: 'json',
		success:(res) => {
			hideLoader();

			if(res.status=='1'){
                toastr.success(res.msg)
                getEvent();
               /*  window.setTimeout(() => {
                    nextStepWizard.removeAttr('disabled').trigger('click')
                }, 1000); */
				
			}else{
                toastr.error(res.msg)
            }
		}

		
	})
})


$(".calender_syncronization").on("click",function(){
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    nextStepWizard.removeAttr('disabled').trigger('click');
})