var rentalPoliciesDescription;
var cancelPolicesDescription;
$(function () {
    ClassicEditor.create( document.querySelector( '#rental_policies' ) ).then( editor => {
        rentalPoliciesDescription = editor;
    }).catch( error => {
        console.error( error );
    });
})

$(".rental_policies").on("click",function(e){
    e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
    showLoader();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let formData = new FormData();
    formData.append("property_listing_id",$("input[name=property_listing_id]").val());
    formData.append("rental_policies",rentalPoliciesDescription.getData());
   // formData.append("upload_rental_polices",$("#upload_rental_policies").prop('files')[0] !=undefined?$("#upload_rental_policies").prop('files')[0]:"");
    formData.append("cancel_rental_polices",$("input[type='radio'][name=cancelletion_policies]:checked").val());
    // formData.append("upload_cancel_rental_polices",$("#upload_cancel_policies").prop('files')[0] !=undefined?$("#upload_cancel_policies").prop('files')[0]:"");
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
            $parent.removeClass('show active');
            $parent.next().addClass('show active');
            $parent.find('.collapsible').removeClass('show');
            $parent.next().find('.collapsible').addClass('show');
            var id = $parent.attr('id');
            var $nav_link = $('a[href="#' + id + '"]');
            $nav_link.removeClass('active');
            $nav_link.find('.number').html($nav_link.data('number'));
            var $prev = $nav_link.parent().next();
            $prev.find('.nav-link').addClass('active');
            $nav_link.find('.number').html('<i class="fal fa-check text-primary"></i>');
            $parent.find('.number').html('<i class="fal fa-check text-primary"></i>');
           }else if(res.status=='1' && res.msg=='create'){
            toastr.success("Property Created Successfully !")
            window.setTimeout(() => {
                window.location.href=site_url+"/owner/my-property-listing"; 
             }, 2000);
           }
        } 
    })
})