// Date Picker intilizition
// function DisableSpecificDates(date) {
//     var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
//     return [disableddates.indexOf(string) == -1];
// }
// function checkRatesIsAvailable(date) {
//     var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
//     return [ratesIsAvailable.indexOf(string) == -1];
// }
$(function() {
    $('#check_in').datepicker({ 
        defaultDate: "-1w",
        beforeShowDay: function (date) {
            var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
             // check if date is in your array of dates
             console.log(ratesIsAvailable.indexOf(string) );
            if(disableddates.indexOf(string) == -1 && ratesIsAvailable.indexOf(string) != -1) {
                return [true, '', ''];
            }
            else {

                return [false, '', ''];
            }

        },
        changeYear: true,
        minDate: 0,
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#check_out").datepicker("option", "minDate", selectedDate);
        }
    });
    $('#check_out').datepicker({ 
        changeYear: true,
        defaultDate: "-1w",
        beforeShowDay: function (date) {
            var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
             // check if date is in your array of dates
             console.log(ratesIsAvailable.indexOf(string) );
            if(disableddates.indexOf(string) == -1 && ratesIsAvailable.indexOf(string) != -1) {
                return [true, '', ''];
            }
            else {

                return [false, '', ''];
            }

        },
        minDate: 0,
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#check_out").datepicker("option", "maxDate", selectedDate);
        }
    });
    $('#start_date').datepicker({ 
        defaultDate: "-1w",
        dateFormat: "mm/dd/yy",
        minDate: 0,
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#end_date").datepicker("option", "minDate", selectedDate);
        }
    });
    $('#end_date').datepicker({ 
        dateFormat: "mm/dd/yy",
        defaultDate: "-1w",
        minDate: 0,
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#end_date").datepicker("option", "maxDate", selectedDate);
        }
    });
});

// Rate Summery 
calcuateRate = async () => {
    showLoader();
    if($("#check_in").val() ==''){
        $(".check_in").text("Please first select check in date");
        hideLoader();
        return false;
    }
    let data = {
        start_date: $("#check_in").val(),
        end_date: $("#check_out").val(),
        adult: $("#guests").val(),
        child: $("#children").val(),
        pet_fees: $("input[name=pet]:checked").val(),
        pool_heating:$("input[name=pool_heating]:checked").val(),
        property_id: $("input[name=property_id]").val(),
    };
    const response = await fetch(site_url+'/calculte-rate', {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Content-Type": "application/json",
        },
    });
    const result = await response.json();
    if (response.status == 200) {
        $(".extralisting").html("");
        $(".extralisting").append(result.data);
        $(".comment-btn").find('button').removeAttr('disabled');
        hideLoader();
    }else if(result.status=='500'){
        hideLoader();
        $("#result").html("");
        toastr.error(result.msg);
    }
};


// Request inquiry
$("#request-enquiry").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/property-enquiry-store",
        type: "POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(res){
            hideLoader();
            console.log(res);
            if(res.status=='1'){
                toastr.success(res.msg);
                window.setTimeout(() => {
                    window.location.reload(); 
                }, 2000);

            }else{
                toastr.error(res.msg);
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
            if(xhr.status ==401){
                $("#login-register-modal").modal('show');
            }   
        }
    })
})

// Reviews Store 

$("#reviews").on("submit",function(e){
    e.preventDefault();
    showLoader();
    $.ajax({
        url:site_url+"/store-reviews-rating",
        type: "POST",
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success:function(res){
            hideLoader();
            console.log(res);
            if(res.status=='1'){
                toastr.success(res.msg);
                window.setTimeout(() => {
                    window.location.reload(); 
                }, 2000);

            }else{
                toastr.error(res.msg);
            }
        },error: function(xhr, ajaxOptions, thrownError){
            hideLoader();
        }
    })
})


// Store Booking Information

bookingInformation.onsubmit = async (e)=>{
    e.preventDefault();
    showLoader();
    const response = await fetch(site_url+"/store-booking-information",{
        method:"POST",
        body: new FormData(bookingInformation),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })

    const result = await response.json();
    if(result.status==500){
        hideLoader();
        toastr.error(result.msg);
        return false;
    }
    if(response.status==401){
        hideLoader();
        $("#login-register-modal").modal('show');
    }
    if(response.status==500) {
        hideLoader();
        toastr.error(response.statusText);
    }

    if(response.status==422){
        hideLoader();
        $("#getQuote").find("span").text('');
        for(let index in result.errors){
            $("."+index).text(result.errors[index]);
        }
    }
    if(response.status ==200){
        
        window.setTimeout(() => {
            hideLoader();
            window.location.href = result.url; 
        }, 2000);
    }

    if(!result.status && response.status !=401){
        hideLoader();
        toastr.error(result.msg);
        window.setTimeout(() => {
            window.location.reload(); 
        }, 2000);
    }

}



