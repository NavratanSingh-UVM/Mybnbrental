$(".location_info").on('click',function(e) {
     e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
    showLoader();
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
        }
    }); 
});