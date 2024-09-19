calenderAvailability = async (date='',property_id) => {
  //  showLoader()
    let data = {
        'date':date,
        'property_id':property_id
    };
    const response = await fetch(site_url+"/calender", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            'Content-Type': 'application/json',
        }
    });
    const results = await response.json();
    if(response.status==200){
        hideLoader();
        $("#Calendars").html('');
        $("#Calendars").append(results.data);
    }
    
}