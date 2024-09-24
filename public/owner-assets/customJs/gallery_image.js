let images = [];
function image_select() {
    let image = document.getElementById("property-gallery-image").files;

    for (var i = 0; i < image.length; i++) {
        if (check_dublicate(image[i].name)) {
            images.push({
                name: image[i].name,
                url: URL.createObjectURL(image[i]),
                file: image[i],
            });
        } else {
            alert(image[i].name + " has been already Uploaded");
        }
    }
    //    $("#container").html();
    document.getElementById("container").innerHTML = image_show();
}

function image_show() {
    var img = "";
    images.forEach((i) => {
        img += `<div class="image_container">
        <img src="${i.url}" alt="Image" srcset="">
        <span class="position-absolute" onclick=delete_image(${images.indexOf(
            i
        )})>&times;</span>
        </div>`;
    });
    return img;
}

function delete_image(e) {
    images.splice(e, 1);
    document.getElementById("container").innerHTML = image_show();
}

function check_dublicate(name) {
    var dublicate_image = true;
    for (i = 0; i < images.length; i++) {
        if (images[i].name == name) {
            dublicate_image = false;
            break;
        }
    }
    return dublicate_image;
}

$(".upload_gellery_image").on("click",async function(e) {
    e.preventDefault();
    var $parent = $(this).parents('.tab-pane');
	showLoader();
	let formData = new FormData();
	formData.append("property_listing_id",$("input[name=property_listing_id]").val());
	let TotalFiles =images.length;
	formData.append("TotalFiles",TotalFiles);
	for (let i = 0; i < TotalFiles; i++) {
		formData.append("files"+i, images[i].file);
	}
	const response = await fetch(
		site_url+"/admin/property-listing/store-gallery-image",
		{
			method: "POST",
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
					"content"
				),
				// "Content-Type": "application/json",
			},
			body: formData,
		});
		
	const result = await response.json();
	if (response.status == 405) {
		hideLoader();
		console.log(response.statusText);
	}
	if (response.status == 419) {
		hideLoader();
		console.log(response.statusText);
	}
	if (response.status == 500) {
		hideLoader();
		 toastr.error(response.msg);
		  toastr.error(results.message);
		//console.log(response.statusText);
	}
	if (response.status == 422) {
		hideLoader();
		$("span").text("");
		for (let error in results.errors) {
			$("." + error).text(results.errors[error]);
		}
	}
	if (response.status == 200) {
		hideLoader();
        document.getElementById("container").innerHTML = await showImage($("input[name=property_listing_id]").val());
		if(result.status=='1'){
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
		}else{
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



async function deleteImage(properyId,imageId) {
	showLoader();
    try {
        const response = await fetch(site_url+"/admin/property-listing/delete-property-image",{
            method:"POST",
            body:JSON.stringify({"id":imageId}),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                'Content-Type': 'application/json',
            }
        });
        const results = await response.json();
        if(response.status==500){
            hideLoader();
            toastr.error(response.statusText);
        }
        if(results.status==500) {
            hideLoader();
            toastr.error(results.message);
            
        }
        if(response.status==200){
            document.getElementById("container").innerHTML ="";
            document.getElementById("container").innerHTML = await showImage(properyId);
            hideLoader();
            toastr.success(results.message);
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
	
}


showImage = async (property_id)=>{
    showLoader();
    try {
        const response = await fetch(site_url+"/admin/property-listing/get-property-gallery-image",{
            method:"POST",
            body:JSON.stringify({"property_id":property_id}),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                'Content-Type': 'application/json',
            }
        })
        const results = await response.json();
        if(response.status==500){
            hideLoader();
            toastr.error(response.statusText);
        }
        if(results.status==500) {
            hideLoader();
            toastr.error(results.message);
            console.log(results);
        }
        if(response.status==200){
            var img = '';
            for(let index in results.data){
                img +=`<div class="image_container" id='${results.data[index].id}'>
                <img src="${results.data[index].url}" alt="Image" srcset="">
                <span class="position-absolute" onclick=deleteImage(${results.data[index].property_id},${results.data[index].id})>&times;</span>
                </div>` 
            }
            
            hideLoader();
            return img;
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
}

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#container').sortable({
        containment: "parent",
        tolerance: 'pointer',
        helper: 'clone',
        update: function (event, ui) {
            var property_id = $("input[name=property_listing_id]").val();
            var picsOrder = {};
            picsOrder = $(this).sortable('toArray');
            $('.image_container ').each(function () {
                $(this).removeClass('thbSel');
                $('#' + picsOrder[0]).addClass('thbSel');
            });
			// console.log(picsOrder);
            $.ajax({
                url:site_url+"/admin/property-listing/update-gallery-image-order",
                type:"POST",
                data:{"picsOrder":picsOrder,"property_id":property_id},
                success:function(data){
                    console.log(data);
                }
            });
        }
    });
});