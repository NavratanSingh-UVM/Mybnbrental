<div class="tab-pane tab-pane-parent fade show active px-0" id="description" role="tabpanel" aria-labelledby="description-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0"id="heading-description">
            <h5 class="mb-0">
                <button class="btn btn-lg collapse-parent btn-block border shadow-none" data-toggle="collapse" data-number="1." data-target="#description-collapse" aria-expanded="true" aria-controls="description-collapse">
                    <span class="number">1.</span> Description
                </button>
            </h5>
        </div>
        <div id="description-collapse" class="collapse show collapsible" aria-labelledby="heading-description" data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-6">
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="property-name">Property Name</label>
                                            <input type="text" name="property_name" class="form-control" placeholder="Property Name" id='property-name' value="{{ $propertyListing->property_name ?? '' }}">
                                            <span class="property_name text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="property-photo">Property Photo</label>
                                            <div class="custom-file">
                                                @if (!empty($propertyListing))
                                                    <img src="{{ url('public/storage/upload/property_image/main_image/' . $propertyListing->property_main_photos) }}" alt="" srcset="" height="100" width="100">
                                                    <input type="hidden" name="old_image" value="{{ $propertyListing->property_main_photos ?? '' }}">
                                                @endif
                                                <input type="file" class="form-control"  id="property-photo"  name="property_main_photo" accept=".png, .jpg, .jpeg, .jpg">
                                                <span class="property_main_photo text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="square-feet">Square Feet</label>
                                            <input type="text" name="square_feet" class="form-control" placeholder="Square feet" id="square-feet" value="{{ $propertyListing->square_feet ?? '' }}">
                                            <span class="square_feet text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="propery-type">Property Type</label>
                                            <select class="form-control" name="property_type" id="propery-type">
                                                <option value="">Select Property type </option>
                                                @foreach ($propertyTypes as $propertyType)
                                                    <option value="{{ $propertyType->id }}" @if (!empty($propertyListing)) @selected($propertyType->id == $propertyListing->property_type_id) @endif>{{ $propertyType->property_type_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="property_type text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bedrooms">Bedrooms</label>
                                            <select class="form-control" name="bedrooms" id="bedrooms">
                                                <option value="">Select Bedrooms</option>
                                                @for ($i = 1; $i <= 20; $i++)
                                                    @if ($i == 20)
                                                        <option value="{{ $i }}+_bedrooms" @if (!empty($propertyListing)) @selected($i . '+_bedrooms' == $propertyListing->bedrooms) @endif>{{ $i }}+ Bedrooms </option>
                                                    @else
                                                        <option value="{{ $i }}_bedrooms" @if (!empty($propertyListing)) @selected($i . '_bedrooms' == $propertyListing->bedrooms) @endif>{{ $i }} Bedrooms </option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <span class="bedrooms text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sleeps">Sleeps</label>
                                            <div class="form-row">
                                                <!--<div class="col-6">-->
                                                    <input type="text" name="sleeps1" class="form-control" placeholder="Sleeps" id="sleeps" value="{{ $propertyListing->sleeps ?? '' }}">
                                                </div>
                                                <!--<div class="col-6">-->
                                                <!--    <input type="text" name="sleeps2" class="form-control" placeholder="sleeps" id="sleeps">-->
                                                <!--</div>-->
                                            <!--</div>-->
                                            <span class="sleeps text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="avg-night">Avg. Night</label>
                                            <div class="input-group">
                                                <input type="text" name="avg_night"  class="form-control"  placeholder="Avg Night" id="avg-night" value="{{ $propertyListing->avg_night_rates ?? '' }}">
                                                <div class="input-group-append">
                                                    <select name="avg_night_rate" id="" class="form-control">
                                                        <option value="">Select </option>
                                                        <option value="Nightly Rate"
                                                            @selected('Nightly Rate' == ($propertyListing != '' ? $propertyListing->avg_rate_unit : ''))>Nightly
                                                            Rate</option>
                                                        <option value="Weekly Rate"
                                                            @selected('Weekly Rate' == ($propertyListing != '' ? $propertyListing->avg_rate_unit : ''))>Weekly
                                                            Rate</option>
                                                        <option value="Monthly Rate"
                                                            @selected('Monthly Rate' == ($propertyListing != '' ? $propertyListing->avg_rate_unit : ''))>Monthly
                                                            Rate</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="avg_night text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="baths">Baths</label>
                                            <input type="text" name="baths"
                                                class="form-control" placeholder="Baths"
                                                id="baths"
                                                value="{{ $propertyListing->baths ?? '' }}">
                                            <span class="baths text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control h-150px" rows="6" id="property_description" name="description">{{ $propertyListing->description ?? '' }}</textarea>
                                            <span class="description text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="property_location">Country</label>
                                            <select class="form-control  select" name="country_name" id="country_name" onchange="getStateByCountryId(this.value)">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        @if (!empty($propertyListing)) @selected($country->id === $propertyListing->country_id) @endif>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="country text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state_name">State</label>
                                            <select class="form-control  select" name="state" id="state_name" onchange="getRegionByStateId(this.value)">
                                                <option value="">Select State</option>
                                                @if (!empty($states))
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}"
                                                            @if (!empty($propertyListing)) @selected($state->id === $propertyListing->state_id) @endif>
                                                            {{ $state->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="state text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="region_name">Region</label>
                                            <select class="form-control  select" name="region_name" id="region_name" onchange="getCityByRegionId(this.value)">
                                                <option value="">Select Region</option>
                                                @if (!empty($regions))
                                                    @foreach ($regions as $region)
                                                        <option value="{{ $region->id }}"
                                                            @if (!empty($propertyListing)) @selected($region->id === $propertyListing->region_id) @endif>
                                                            {{ $region->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="region text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city_name">City</label>
                                            <select class="form-control select" name="city_name" id="city_name" onchange="getSubCityByCityId(this.value)">
                                                <option value="">Select city</option>
                                                @if (!empty($cities))
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            @if (!empty($propertyListing)) @selected($city->id === $propertyListing->city_id) @endif>
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="city text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sub_city_name">Sub City</label>
                                            <select class="form-control select" name="sub_city" id="sub_city_name">
                                                <option value="">Select sub city</option>
                                                @if (!empty($sub_cities))
                                                    @foreach ($sub_cities as $sub_city)
                                                        <option value="{{ $sub_city->id }}"
                                                            @if (!empty($propertyListing)) @selected($sub_city->id === $propertyListing->sub_city_id) @endif>
                                                            {{ $sub_city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="sub_city text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" name="address"
                                                class="form-control" placeholder="Address"
                                                id="address"
                                                value="{{ $propertyListing->address ?? '' }}">
                                            <span class="address text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="town">Town</label>
                                            <input type="text" name="town"
                                                class="form-control" placeholder="Town"
                                                id="town"
                                                value="{{ $propertyListing->town ?? '' }}">
                                            <span class="town text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zipcode">Zipcode</label>
                                            <input type="text" name="zipcode"
                                                class="form-control" placeholder="Zipcode"
                                                id="zipcode"
                                                value="{{ $propertyListing->zip_code ?? '' }}">
                                            <span class="zipcode text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt">
                                        <div class="form-group">
                                            <label for="video_link">Youtube Video Link(Embed Link)</label>
                                            <input type="text" class="form-control" name="youtube_video_link" id="video_link" value="{{ $propertyListing->youtube_video_link ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-lg btn-primary next-button property_information" type="button">@if(!empty($propertyListing)) Update Next @else Next step @endif
                        <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
