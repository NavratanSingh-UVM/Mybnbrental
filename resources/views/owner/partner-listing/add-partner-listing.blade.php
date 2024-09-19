@extends('owner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Create Partner Lisiting</h2>
        </div>
        <form id="partnerListing">
            @csrf
            <div class="row mb-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="text-heading">Title</label>
                                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="">
                                        <span class="title"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="text-heading">Address</label>
                                        <input type="text" class="form-control form-control-lg" id="address" name="address" value="">
                                        <span class="address text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description" class="text-heading">Description</label>
                                        <textarea name="description" id="description" class="form-control form-control-lg"></textarea>
                                        <span class="description text-danger" ></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="text-heading">Email</label>
                                        <input type="text" class="form-control form-control-lg" id="email" name="email">
                                        <span class="email text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="text-heading">Phone</label>
                                        <input type="text" class="form-control form-control-lg" id="phone" name="phone">
                                        <span class="phone text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website" class="text-heading">Website</label>
                                        <input type="text" class="form-control form-control-lg" id="website" name="website">
                                        <span class="website text-danger"></span>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location" class="text-heading">Location (Google Map Link)</label>
                                        <input type="text" class="form-control form-control-lg" id="location" name="location">
                                        <span class="location text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_categories" class="text-heading">Business Category</label>
                                        <select name="business_category" id="business_categories" class="form-control form-control-lg">
                                            <option value="">Select Business Category</option>
                                            @foreach ($businessCategories as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="business_category text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state_name" class="text-heading">State</label>
                                        <select name="state" id="state_name" class="form-control form-control-lg" onchange="getRegionByStateId(this.value)">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="state text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="region_name" class="text-heading">Region</label>
                                        <select name="region" id="region_name" class="form-control form-control-lg" onchange="getCityByRegionId(this.value)">
                                            <option value="">Select Region</option>
                                        </select>
                                        <span class="region text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city_name" class="text-heading">City</label>
                                        <select name="city" id="city_name" class="form-control form-control-lg">
                                            <option value="">Select City</option>
                                        </select>
                                        <span class="city text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="text-heading">Gallery (Upload Photos)</label>
                                        <input type="file" class="form-control form-control-lg" id="image" onchange="image_select()" multiple>
                                        <span class="images text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="gallery" id="gallery">
                                        <div class="row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end flex-wrap">
                <button class="btn btn-lg btn-primary ml-4 mb-3" type="submit">Add</button>
            </div>
        </form>
    </div>
 </main>
@endsection
@push('js')
    <script src="{{asset('assets/custom.js')}}"></script>
    <script>
       let images = [];
        image_select = () =>{
            let image = document.getElementById('image').files;
            for(var i =0; i<image.length;i++) {
                if (check_dublicate(image[i].name)) {
                    images.push({
                        name: image[i].name,
                        url: URL.createObjectURL(image[i]),
                        file: image[i],
                    });
                }
            }
            document.getElementById('gallery').innerHTML = "";
            document.getElementById('gallery').innerHTML = image_show();
        }


        check_dublicate = (image)=>{
            var dublicate_image = true;
            for (i = 0; i < images.length; i++) {
                if (images[i].name == name) {
                    dublicate_image = false;
                    break;
                }
            }
            return dublicate_image;
        }

        image_show = () =>{
            var img = `<div class="row">`;
            images.forEach((i)=>{
                img +=` <div class="col-md-2 mt-4">
                    <div class="dele">
                        <img src="${i.url}" alt="" srcset="">
                        <i class="fa fa-trash" aria-hidden="true" onclick=image_delete(${images.indexOf(i)})></i>
                    </div>                                                
                </div>`
            })
            img +=`</div>`;
            return img;
        }

        image_delete = (e) =>{
            images.splice(e,1);
            document.getElementById('gallery').innerHTML = "";
            document.getElementById('gallery').innerHTML = image_show();
        }

        partnerListing.onsubmit = async (e) => {
            e.preventDefault();
            showLoader();
            var formData = new FormData(partnerListing);
            for (i = 0; i < images.length; i++) {
                formData.append("images[]", images[i].file);
            }
            const response = await fetch("{{route('owner.store.partner.listing')}}",{
                method:"POST",
                body:formData,
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    // 'Content-Type': 'application/json',
                }
            });

            const result =await response.json();
            if(response.status==422) {
                hideLoader() 
                $("input").removeClass('is-invalid');
                $("textarea").removeClass('is-invalid');
                $("span").text('');
                var i=1;
                for (let error in result.errors) {
                    errors = safeRedactName(error,"images.")
                    errors=errors.replace(/[0-9]/g, '');
                    if(error=='description'){
                        $("textarea[name="+error+"]").addClass('is-invalid');
                    }else if(errors =='images'){
                        $("#image").addClass('is-invalid');
                    }
                    else if(errors =='business_category'){
                        $("#business_categories").addClass('is-invalid');
                    }
                    else{
                        $("input[name="+errors+"]").addClass('is-invalid');
                        $("select[name="+errors+"]").addClass('is-invalid');
                    }
                    $("." + errors).text(result.errors[error]);
                    $("." + error).text(result.errors[error]);
                }
            }

            if(response.status==200){
                hideLoader();
                toastr.success(result.msg);
                setTimeout(() => {
                    window.location.href=result.url;
                }, 3000);
            
            }

        }
        

        function safeRedactName(text, name) {
            return text.replaceAll(name, "images");
        }
    </script>
@endpush