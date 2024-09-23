function getEvent() {
    try {
        $.ajax({
            url: site_url+"/admin/property-listing/get-property-event",
            method: "POST",
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Content-Type": "application/json",
            },
            data: JSON.stringify({
                id: $("input[name=property_listing_id]").val()
            }),
            async: false,
            success: function(data) {
             
                var calendarEl = document.getElementById('calendar1');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        right: 'prev,next today',
                        center: 'title',
                        left: 'dayGridMonth'
                    },  
                    initialDate: moment().format('YYYY-MM-DD'),
                    navLinks: true,
                    editable:false,
                    selectable: true,
                    events: JSON.parse(data.data),
                    select: function(datetime) {
                        const startdate = moment(datetime.start).format('YYYY-MM-DD');
                        const today_date = moment().format('YYYY-MM-DD');
                        if (startdate < today_date) {
                            alert("Back date event not allowed ");
                            calendar.unselect();
                            return false;
                        }
                        $("#bookingEvent").modal('show');
                        $(".start_date").val(moment(datetime.start).format('YYYY-MM-DD'));
                        $("#property_id").val($("input[name=property_listing_id]").val());
                        $(".end_date").val(moment(datetime.end).subtract(1, 'days').format('YYYY-MM-DD'));
                    },
                    eventClick:function(events){
                          var id=events.el.fcSeg.eventRange.def.extendedProps.event_id;
                          var minimum_stay=events.el.fcSeg.eventRange.def.extendedProps.minimum_stay;
                          var rate=events.el.fcSeg.eventRange.def.extendedProps.rate;
                          var name=events.el.fcSeg.eventRange.def.title;
                          var start_date=moment(events.el.fcSeg.eventRange.range.start).format('YYYY-MM-DD');
                          var end_date=moment(events.el.fcSeg.eventRange.range.end).subtract(1, 'days').format('YYYY-MM-DD');
                        //    console.log(events);
                          $("#bookingEvent").modal('show');
                        $(".start_date").val(moment(start_date).format('YYYY-MM-DD'));
                        $("#customer_name").val(name);
                        $("#block_calender_id").val(id);
                        $("#property_id").val($("input[name=property_listing_id]").val());
                        $(".end_date").val(moment(end_date).format('YYYY-MM-DD'));
                        $("#rate").val(rate);
                        $("#rate_minimum_stay").val(minimum_stay);
                    }

                });
                calendar.render();
            },
        });
    } catch (error) {
        console.log(error.message)
   }
}

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
				
			}else{
                toastr.error(res.msg)
            }
		}

		
	})
})


$(".calender_syncronization").on("click",function(e){
    e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
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
})