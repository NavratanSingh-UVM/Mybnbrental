let tables;
 $(function() {
    tables = $('#reviews_rating').DataTable({
        "language": {
            "zeroRecords": "No record(s) found.",
            searchPlaceholder: "Search records"
        },
        "bDestroy": true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        searchable:false,
        bStateSave: true,
        "bPaginate": false,
        "bFilter": false, 
        "bInfo": false, 
        scrollX: true,
        "bLengthChange" : false,
        ajax:{
            url:site_url+"/admin/property-listing/get-reviews-rating",
            data:function(d){
               d.property_id =$("input[name='property_listing_id']").val()
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'reviews_heading', name: 'reviews_heading',orderable: false},
            {data: 'guest_name', name: 'guest_name',orderable: false},
            {data: 'reviews', name: 'reviews',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#reviews_rating').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'An error has been reported by DataTables: ', message);
    })
    $('.mega-menu').on('click',function(){
        try {
            tables.state.clear();
        }
        catch(err) {
           console.log(err.message);
        }
    });
    $(".add_reviews").on("click",function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       let formData = {
            "property_listing_id":$("input[name=property_listing_id]").val() !=""?$("input[name=property_listing_id]").val():1,
            "reviews_heading":$("input[name=reviews_heading]").val(),
            "guest_name":$("input[name=guest_name]").val(),
            "place":$("input[name=place]").val(),
            "reviews":$("textarea[name=reviews]").val(),
            "rating":$("select[name=rating]").val()
       }
       $.ajax({
            url:site_url+"/admin/property-listing/store-reviews-rating",
            type:"POST",
            data:formData,
            success:function(res){
                hideLoader();
                toastr.success(res.msg);
                if(res.status=='1'){
                    tables.draw()
                    $("input[name=reviews_heading]").val("");
                    $("input[name=guest_name]").val("");
                    $("input[name=place]").val("");
                    $("textarea[name=reviews]").val("");
                    $("select[name=rating]").val("");
                }
            },error: function(xhr, ajaxOptions, thrownError){
                hideLoader();
                let error = xhr.responseJSON.errors;
                console.log(error);
            }
             
        });
    });
});

$(".craete_property").on("click",function(e) {
    e.preventDefault();
    toastr.success("Property Created Successfully !")
    window.setTimeout(() => {
        window.location.href=site_url+"/owner/my-property-listing"; 
     }, 2000);
})


function editReviewsRating(id) {
    showLoader();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:site_url+"/admin/property-listing/reviews-rates-get-by-id",
        type:"POST",
        dataType:'json',
        data:{"id":id},
        // cache:false,
        success:function(res){
            hideLoader();
            if(res.status=='1'){
                $('#revies_rating').modal('toggle');
                let form = $("#update_reviews_rating");
                form.find("input[name=id]").val(res.data.id);
                form.find("input[name=reviews_heading]").val(res.data.reviews_heading);
                form.find("input[name=guest_name]").val(res.data.guest_name);
                form.find("input[name=place]").val(res.data.place);
                form.find("textarea[name=reviews]").val(res.data.reviews);
                $('select[name^="rating_update"] option[value="'+res.data.rating+'"]').attr("selected","selected");
                $('select').select2();

            }
        }
    })
}

$(".update_reviews").on('click',function() {
    showLoader();
    let formData = new FormData($("#update_reviews_rating")[0]);
    $.ajax({
        url:site_url+"/admin/property-listing/reviews-rating-update",
        type:"POST",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(res){
            hideLoader();
            console.log(res);
            if(res.status=='1'){
                toastr.success(res.msg);
                tables.draw();
                $('#update_reviews_rating')[0].reset();
                $('#revies_rating').modal('hide');
            }else{
                toastr.error(res.msg);
            }
        }
    });
});



function reviewsDelete(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: site_url+"/admin/property-listing/reviews-rating-delete",
                type: 'POST',
                dataType: "json",
                data:{'id':id},
                cache:false,
                success:function (res) {
                    hideLoader();
                    toastr.success(res.msg);
                    tables.draw();
                }
            });
        }
    });
}

