let count = 0
function previewFiles(input) {
  const preview = document.getElementById('preview')
  const {
    files
  } = input

  Array.from(files).forEach(file => {
    const reader = new FileReader()
    reader.onload = e => {
      const div = document.createElement('div')
      div.setAttribute("class","image")
      const img = document.createElement('img')
      const button = document.createElement('span')
      img.src = e.target.result
      img.width = 200
      img.height = 200
      img.alt = `file-${++count}`

      button.textContent = "X"
      button.addEventListener('click', () => {
        preview.removeChild(div)
      })

      div.appendChild(img)
      div.appendChild(button)

      preview.appendChild(div)
    }
    reader.readAsDataURL(file)
  })
}

$(".upload_gellery_image").on("click",function() {
	showLoader();
	var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
	var formData = new FormData();
	let TotalFiles = $('#upload_galery_image')[0].files.length;
	let files = $('#upload_galery_image')[0];
	for (let i = 0; i < TotalFiles; i++) {
		formData.append('files' + i, files.files[i]);
	}
	formData.append('TotalFiles', TotalFiles);
	formData.append("property_listing_id",$("input[name=property_listing_id]").val())
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:'POST',
		url: site_url+"/admin/property-listing/store-gallery-image",
		data: formData,
		cache:false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: (res) => {
			hideLoader();
			if(res.status=='1'){
				 nextStepWizard.removeAttr('disabled').trigger('click')
			}else{
				nextStepWizard.removeAttr('disabled').trigger('click')
			}
		},
		error: function(data){
		console.log(data.responseJSON.errors.files[0]);
		console.log(data.responseJSON.errors);
		}
	})
})