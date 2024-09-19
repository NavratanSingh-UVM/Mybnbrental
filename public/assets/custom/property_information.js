var descriptionEditor;
$(function (){
    // Description Editor 
	ClassicEditor.create( document.querySelector( '#description' ) ).then( editor => {
            descriptionEditor=editor;
    }).catch( error => {
     console.error( error );
    });
    
})

$(".property_information").on("click",function() {
    showLoader();
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var form = $("listing_form");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let formData = new FormData();
    let sleeps1 = $("input[name='sleeps1']").val() !=undefined?$("input[name='sleeps1']").val():"";
    let sleeps2 = $("input[name='sleeps2']").val() !=undefined?$("input[name='sleeps2']").val():"";
    let sleeps = (sleeps1)+(sleeps2 !=""?"-"+sleeps2:"");
    formData.append("property_listing_id",$("input[name='property_listing_id']").val() !=undefined?$("input[name='property_listing_id']").val():"");
    formData.append("property_name",$("input[name='property_name']").val() !=undefined?$("input[name='property_name']").val():"");
    formData.append("square_feet",$("input[name='square_feet']").val() !=undefined?$("input[name='square_feet']").val():"");
    formData.append("property_type",$("select[name='property_type']").val() !=undefined?$("select[name='property_type']").val():"");
    formData.append("bedrooms",$("select[name='bedrooms']").val() !=undefined?$("select[name='bedrooms']").val():"");
    formData.append("sleeps",sleeps);
    formData.append("avg_night",$("input[name='avg_night']").val()+" "+$("select[name='avg_night_rate']").val());
    formData.append("property_main_image",$("#property-photo").prop('files')[0] !=undefined?$("#property-photo").prop('files')[0]:"");
    formData.append("baths",$("input[name='baths']").val());
    formData.append("description", descriptionEditor.getData());
    formData.append("country",$("select[name='country_name']").val());
    formData.append("state",$("select[name='state']").val());
    formData.append("region",$("select[name='region_name']").val());
    formData.append("city",$("select[name='city_name']").val());
    formData.append("sub_city",$("select[name='sub_city']").val());
    formData.append("address",$("input[name='address']").val());
    formData.append("town",$("input[name='town']").val());
    formData.append("zipcode",$("input[name='zipcode']").val());
    formData.append("property_old_image",$("input[name=old_image]").val());
    formData.append("youtube_video_link",$("input[name=youtube_video_link]").val());
    $.ajax({
        url:site_url+"/admin/property-listing/store",
        type:"POST",
        contentType: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success:function(res){
            if(res.status=='1'){
                hideLoader();
                $("input[name='property_listing_id']").val(res.property_id);
                nextStepWizard.removeAttr('disabled').trigger('click')
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
            let error = xhr.responseJSON.errors;
            $(".property_name").text("");
            $(".property_main_photo").text("");
            $(".square_feet").text("");
            $(".property_type").text("");
            $(".bedrooms").text("");
            $(".sleeps").text("");
            $(".avg_night").text("");
            $(".baths").text("");
            $(".description").text("");
            $(".country").text("");
            $(".state").text("");
            $(".region").text("");
            $(".city").text("");
            $(".sub_city").text("");
            $(".address").text("");
            $(".town").text("");
            $(".zipcode").text("");
            $(".property_name").text(error.property_name);
            $(".property_main_photo").text(error.property_main_image);
            $(".square_feet").text(error.square_feet);
            $(".property_type").text(error.property_type);
            $(".bedrooms").text(error.bedrooms);
            $(".sleeps").text(error.sleeps);
            $(".avg_night").text(error.avg_night);
            $(".baths").text(error.baths);
            $(".description").text(error.description);
            $(".country").text(error.country);
            $(".state").text(error.state);
            $(".region").text(error.region);
            $(".city").text(error.city);
            $(".sub_city").text(error.sub_city);
            $(".address").text(error.address);
            $(".town").text(error.town);
            $(".zipcode").text(error.zipcode);
        }
    });
});