var rentalPoliciesDescription;
var cancelPolicesDescription;
$(function () {
    ClassicEditor.create( document.querySelector( '#rental_policies' ) ).then( editor => {
        rentalPoliciesDescription = editor;
    }).catch( error => {
        console.error( error );
    });
    // ClassicEditor.create( document.querySelector( '#cancel_polices' ) ).then( editor => {
    //     cancelPolicesDescription = editor;
    // }).catch( error => {
    //     console.error( error );
    // });
})

$(".rental_policies").on("click",function(){
    showLoader();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    let formData = new FormData();
    formData.append("property_listing_id",$("input[name=property_listing_id]").val());
    formData.append("rental_policies",rentalPoliciesDescription.getData());
    formData.append("cancel_rental_polices",$("input[type='radio'][name=cancelletion_policies]:checked").val());
    /* formData.append("upload_rental_polices",$("#upload_rental_policies").prop('files')[0] !=undefined?$("#upload_rental_policies").prop('files')[0]:"");
    formData.append("cancel_rental_polices",cancelPolicesDescription.getData());
    formData.append("upload_cancel_rental_polices",$("#upload_cancel_policies").prop('files')[0] !=undefined?$("#upload_cancel_policies").prop('files')[0]:""); */
    $.ajax({
        url:site_url+"/admin/property-listing/store-rental-policies",
        type:"POST",
        contentType: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success:function(res){
           hideLoader();
           if(res.status=='1'){
              nextStepWizard.removeAttr('disabled').trigger('click');
           }
        } 
    })
})