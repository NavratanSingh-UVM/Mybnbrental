<div class="tab-pane tab-pane-parent fade px-0" id="locations" role="tabpanel" aria-labelledby="location-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0"
            id="heading-location">
            <h5 class="mb-0">
                <button class="btn btn-block collapse-parent collapsed border shadow-none"
                    data-toggle="collapse" data-number="3." data-target="#location-collapse"
                    aria-expanded="true" aria-controls="location-collapse">
                    <span class="number">3.</span> Location
                </button>
            </h5>
        </div>
        <div id="location-collapse" class="collapse collapsible"
            aria-labelledby="heading-location" data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-6">
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="form-group">
                                           <label for="address_address">Address</label>
                                           <input type="text" id="address-input" name="location" class="form-control map-input" placeholder="Search address" value="{{ $propertyListing->location ?? '' }}">
                                           <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                                           <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                                       </div>
                                       <div id="address-map-container" style="width:100%;height:400px; ">
                                           <div style="width: 100%; height: 100%" id="address-map"></div>
                                       </div>
                                        <!--<label for="location">Address</label>-->
                                        <!--<input type="text" class="form-control" id="location" name="location" placeholder="Search address" value="{{ $propertyListing->location ?? '' }}">-->
                                    </div>
                                    <!--<div class="col-md-12">-->
                                    <!--    <div id="map"-->
                                    <!--        style="width:100%;height:600px;margin-top:10px;">-->
                                    <!--    </div>-->
                                    <!--    <div id="infowindow-content">-->
                                    <!--        <span id="place-name" class="title"></span><br />-->
                                    <!--        <span id="place-address"></span>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="iframe_link">Iframe Link(Embed Link)</label>
                                            <input type="text" class="form-control" id="iframe_link" name="iframe_link" value="{{ $propertyListing->iframe_link_google ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="longitude">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $propertyListing->longitude ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="latitude">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $propertyListing->latitude ?? '' }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void(0)" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16">
                            <i class="fal fa-long-arrow-left"></i>
                        </span>
                        Prev step
                    </a>
                    <button class="btn btn-lg btn-primary next-button mb-3 location_info">@if(!empty($propertyListing)) Update Next @else Next step @endif
                        <span class="d-inline-block ml-2 fs-16">
                            <i class="fal fa-long-arrow-right"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
