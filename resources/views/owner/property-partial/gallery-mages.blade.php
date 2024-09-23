<div class="tab-pane tab-pane-parent fade px-0" id="photo" role="tabpanel" aria-labelledby="photo-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0" id="heading-photo">
           <h5 class="mb-0">
              <button class="btn btn-block collapse-parent collapsed border shadow-none" data-toggle="collapse" data-number="4." data-target="#photo-collapse"aria-expanded="true" aria-controls="photo-collapse">
                 <span class="number">4.</span> photo
              </button>
           </h5>
        </div>
        <div id="photo-collapse" class="collapse collapsible" aria-labelledby="heading-photo" data-parent="#collapse-tabs-accordion">
           <div class="card-body py-4 py-md-0 px-0">
                <div class="card mb-6">
                    <div class="card-body p-6">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="property-gallery-image" class="form-label">Property Gallery Image</label>
                                <input type="file" class="form-control" id="property-gallery-image" placeholder="Name" name="property-gallery-image" accept="image/png, image/gif, image/jpeg , image/jpg" multiple accept="" onchange="image_select()" />
                            </div>
                            <div class="col-md-12">
                                <div class="card-body d-flex flex-wrap justify-content-start" id="container">
                                    @if($propertyListing !='')
                                        @if ($propertyListing?->property_gallery_image?->count() >0)
                                            @foreach ($propertyListing->property_gallery_image as $galleryImages)
                                                <div class="image_container" id="{{$galleryImages->id}}">
                                                    <img src="{{ url('storage/upload/property_image/gallery_image/'.$galleryImages->image_name) }}" alt="Image" srcset="">
                                                    <span class="position-absolute" onclick="deleteImage({{$galleryImages->property_id}},{{$galleryImages->id}})">&times;</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                       <a href="javascript:void()" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button"> 
                            <span class="d-inline-block text-primary mr-2 fs-16">
                                <i class="fal fa-long-arrow-left"></i>
                            </span>
                            Prev step
                       </a>
                       <button class="btn btn-lg btn-primary next-button mb-3 upload_gellery_image">@if(!empty($propertyListing)) Update Next @else Next step @endif
                           <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span>
                       </button>
                   </div>
               </div>
           </div>
       </div>
    </div>
</div>