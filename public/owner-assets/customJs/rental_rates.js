var ratesNotesDescription;
let table;
$(function() {
    ClassicEditor.create( document.querySelector( '#rates_notes' ) ).then( editor => {
        ratesNotesDescription = editor;
    }).catch( error => {
        console.error( error );
    });
     table = $('#property_rates').DataTable({
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
            url:site_url+"/admin/property-listing/get-property-rates",
            data:function(d){
               d.property_id =$("input[name='property_listing_id']").val()
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'session_name', name: 'session_name',orderable: false},
            {data: 'from_date', name: 'from_date',orderable: false},
            {data: 'to_date', name: 'to_date',orderable: false},
            {data: 'nightly_rate', name: 'nightly_rate',orderable: false},
            {data: 'minimum_stay', name: 'minimum_stay',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#property_rates').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'An error has been reported by DataTables: ', message);
    })
    $(".dataTables_wrapper").css("width","100%");
    $('.mega-menu').on('click',function(){
        try {
           table.state.clear();
        }
        catch(err) {
           console.log(err.message);
        }
    });

    $(".add_rates").on('click',function() {
        showLoader();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let formData = {
            'property_listing_id':$("input[name='property_listing_id']").val(),
            'session_name':$("input[name=session_name]").val(),
            'from_date':$("input[name=from_date]").val(),
            'to_date':$("input[name=to_date]").val(),
            'nightly_rate':$("input[name=nightly_rate]").val(),
            'minimum_stay':$("input[name=minimum_stay]").val(),
        };
        $.ajax({
            url:site_url+"/admin/property-listing/property-rates-store",
            type:"POST",
            data:formData,
            success:function(res){
                hideLoader();
                
                if(res.status=='1'){
                    toastr.success(res.msg)
                    table.draw()
                    $("input[name=session_name]").val("");
                    $("input[name=from_date]").val("");
                    $("input[name=to_date]").val("");
                    $("input[name=nightly_rate]").val("");
                    $("input[name=minimum_stay]").val("");
                }else{
                    toastr.error(res.msg)
                    $("input[name=session_name]").val("");
                    $("input[name=from_date]").val("");
                    $("input[name=to_date]").val("");
                    $("input[name=nightly_rate]").val("");
                    $("input[name=minimum_stay]").val("");
                }
            },error: function(xhr, ajaxOptions, thrownError){
                hideLoader();
                let error = xhr.responseJSON.errors;
                $(".session_name").text("");
                $(".from_date").text("");
                $(".to_date").text("");
                $(".nightly_rate").text("");
                $(".minimum_stay").text("");
                $(".session_name").text(error.session_name);
                $(".from_date").text(error.from_date);
                $(".to_date").text(error.to_date);
                $(".nightly_rate").text(error.nightly_rate);
                $(".minimum_stay").text(error.minimum_stay);
            }
        })
    });
})

$(".rental_rates").on('click',function(e){
    e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
    showLoader();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    let formData = {
        "property_listing_id":$("input[name=property_listing_id]").val(),
        "admin_fees":$("input[name=admin_fees]").val(),
        "cleaning_fees":$("input[name=cleaning_fees]").val(),
        "refundable_damage_deposite":$("input[name=refundable_damage_deposite]").val(),
        "danage_waiver":$("input[name=danage_waiver]").val(),
        "peet_fee":$("input[name=peet_fee]").val(),
        "pet_rate_unit":$("select[name=pet_rate_unit]").val(),
        "extra_person_fee":$("input[name=extra_person_fee]").val(),
        "after_guest":$("select[name=after_guest]").val(),
        "poolheating_fee":$("input[name=poolheating_fee]").val(),
        "pool_heating_fees_perday":$("select[name=pool_heating_fees_perday]").val(),
        "check_in":$("input[name=check_in]").val(),
        "check_out":$("input[name=check_out]").val(),
        "tax_rates":$("input[name=tax_rates]").val(),
        "change_over":$("select[name=change_over]").val(),
        "rates":$("select[name=all_rates_are_in]").val(),
        "rates_notes":ratesNotesDescription.getData(),
    };
    $.ajax({
        url:site_url+"/admin/property-listing/store-rental-rates",
        type:"POST",
        data:formData,
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
            let error = xhr.responseJSON.errors;
            $(".all_rates_are_in").text("");
            $(".all_rates_are_in").text(error.rates);
            $(".tax_rates").text("");
            $(".tax_rates").text(error.tax_rates);
        }
    });
})

//  Edit Rental Rates function 
function editRentalRates(id) {
    showLoader();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:site_url+"/admin/property-listing/get-rental-rates",
        type:"POST",
        data:{"id":id},
        cache:false,
        success:function(res){
            hideLoader();
            if(res.status=='1'){
                $('#rental_rates_edit').modal('toggle');
                let form = $("#update_rental_rates");
                form.find("input[name=id]").val(res.data.id);
                form.find("input[name=session_name]").val(res.data.session_name);
                form.find("input[name=from_date]").val(res.data.from_date);
                form.find("input[name=to_date]").val(res.data.to_date);
                form.find("input[name=nightly_rate]").val(res.data.nightly_rate);
                form.find("input[name=minimum_stay]").val(res.data.minimum_stay);
            }
        }
    })
}


// Upadte Rental Rates 
$(".update_rental_rates").on('click',function() {
    showLoader();
    let formData = new FormData($("#update_rental_rates")[0]);
    $.ajax({
        url:site_url+"/admin/property-listing/update-rental-rates",
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
                table.draw();
                $('#update_rental_rates')[0].reset();
                $('#rental_rates_edit').modal('hide');
            }else{
                toastr.error(res.msg);
            }
        }
    });
});

function rentalRatesDelete(id) {
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
                url: site_url+"/admin/property-listing/delete-rental-rates",
                type: 'POST',
                dataType: "json",
                data:{'id':id},
                cache:false,
                success:function (res) {
                    hideLoader();
                    toastr.success(res.msg);
                    table.draw();
                }
            });
        }
    });
}