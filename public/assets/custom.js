"use strict";

let getStateByCountryId = async (value) =>{
    showLoader();
    const response =await fetch(site_url+"/admin/location/get-state-by-country-id",{
        method:"POST",
        body:JSON.stringify({id:value}),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            'Content-Type': 'application/json',
        }
    });

    const results = await response.json();
    let html = `<option value="">Select State </option>`;
    if(response.status==200 && results.status==1){
        hideLoader();
        $.each(results.data,function(key,value){
            html +=`<option value="${value.id}">${value.name}</option>`
        });
       $("#state_name").html(html);
    }else{
        hideLoader();
        $("#state_name").html("");
        $("#state_name").html(html);

    }
}

let getRegionByStateId = async (value,selectBoxType='') =>{
    showLoader();
    const response =await fetch(site_url+"/admin/location/get-region-by-state-id",{
        method:"POST",
        body:JSON.stringify({id:value}),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            'Content-Type': 'application/json',
        }
    });

    const results = await response.json();
    let html = `<option value="">Select Region </option>`;
    if(response.status==200 && results.status==1){
        hideLoader();
        $.each(results.data,function(key,value){
            html +=`<option value="${value.id}">${value.name}</option>`
        });
        if(selectBoxType !='selectpicker'){
            $("#region_name").html(html);
        }else{
            $('#region_name').selectpicker('refresh').empty().append(html).selectpicker('refresh');
        }
    }else{
        hideLoader();
        $("#region_name").html("");
        $("#region_name").html(html);

    }
}

let getCityByRegionId = async (value,selectBoxType='') =>{
    showLoader();
    const response =await fetch(site_url+"/admin/location/get-city-by-region-id",{
        method:"POST",
        body:JSON.stringify({id:value}),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            'Content-Type': 'application/json',
        }
    });

    const results = await response.json();
    let html = `<option value="">Select City </option>`;
    if(response.status==200 && results.status==1){
        hideLoader();
        $.each(results.data,function(key,value){
            html +=`<option value="${value.id}">${value.name}</option>`
        });
        $("#city_name").html("");
        if(selectBoxType !='selectpicker'){
            $("#city_name").html(html);
        }else{
            $('#city_name').selectpicker('refresh').empty().append(html).selectpicker('refresh');


        }

    }else{
        hideLoader();
        if(selectBoxType !='selectpicker'){
            $('#city_name').selectpicker('refresh').empty().append(html).selectpicker('refresh').trigger('change');
        }else{

            $("#city_name").html("");
            $("#city_name").html(html);
        }

    }
}

let getSubCityByCityId = async (value) =>{
    showLoader();
    const response =await fetch(site_url+"/admin/location/get-sub-city-by-city-id",{
        method:"POST",
        body:JSON.stringify({id:value}),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            'Content-Type': 'application/json',
        }
    });

    const results = await response.json();
    let html = `<option value="">Select Region </option>`;
    if(response.status==200 && results.status==1){
        hideLoader();
        $.each(results.data,function(key,value){
            html +=`<option value="${value.id}">${value.name}</option>`
        });
        $("#sub_city").html("");
       $("#sub_city").html(html);
    }else{
        hideLoader();
        $("#sub_city").html("");
        $("#sub_city").html(html);

    }
}
