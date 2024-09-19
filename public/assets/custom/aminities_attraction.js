$(".nextBtn2").on('click',function() {
    showLoader();
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var subAminitiesId = [];
    $("input[type=checkbox]:checked").each(function() {
        subAminitiesId.push($(this).val());
    });
    if(subAminitiesId.length <=0) {
        alert("Please Select atlest one Aminities");
        hideLoader();
        return false;
    }else{
        $.ajax({
            url:site_url+"/admin/property-listing/store-step2",
            type:"POST",
            cache: false,
            data:{'property_id':$("input[name='property_listing_id']").val(),'sub_aminities_id':subAminitiesId},
            success:function(res) {
             if(res.status=='1'){
                 hideLoader();
                 $("input[name='property_listing_id']").val(res.property_id);
                 nextStepWizard.removeAttr('disabled').trigger('click')
             }
            },error: function(xhr, ajaxOptions, thrownError){
                hideLoader();
            }
        })
    }
});