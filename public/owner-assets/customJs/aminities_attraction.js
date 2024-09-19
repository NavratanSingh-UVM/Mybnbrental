$(".aminities_attraction").on('click',function(e) {
    showLoader();
    e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
    var subAminitiesId = [];
    $("input[type=checkbox]:checked").each(function() {
        subAminitiesId.push($(this).val());
    });
    if(subAminitiesId.length <=0) {
        alert("Please Select atlest one Aminities");
        hideLoader();
        return false;
    }else{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:site_url+"/admin/property-listing/store-step2",
            type:"POST",
            cache: false,
            data:{'property_id':$("input[name='property_listing_id']").val(),'sub_aminities_id':subAminitiesId},
            success:function(res) {
             if(res.status=='1'){
                 hideLoader();
                $("input[name='property_listing_id']").val(res.property_id);
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
             }
            },error: function(xhr, ajaxOptions, thrownError){
                hideLoader();
            }
        })
    }
});