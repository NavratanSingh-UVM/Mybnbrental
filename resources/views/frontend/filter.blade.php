<div class="mt-6 form-search-01 customsearch">
    <form class=" mx-n1" id="accordion-5">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group p-1">
                    <input type="hidden" name="state_id" value="{{request()->state_id}}">
                    <label for="key-word" class="sr-only">Key Word</label>
                    <input type="text" class="form-control border-0 shadow-xxs-1 bg-white" id="input" placeholder="Enter keyword..." name="destination_or_listing_id" value="{{request()->destination_or_listing_id}}">
                </div>                                    
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6 p-0">
                        <div class="form-group p-1">
                            <label for="key-word" class="sr-only">Check In</label>
                            <input type="text" class="form-control border-0 shadow-xxs-1 bg-white" id="start_date" placeholder="Check In" name="check_in" value="{{request()->check_in}}">
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="form-group p-1">
                            <label for="key-word" class="sr-only">Check Out</label>
                            <input type="text" class="form-control border-0 shadow-xxs-1 bg-white" id="end_date" placeholder="Check Out" name="check_out" value="{{request()->check_out}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-inline">
            <div class="form-group p-1">
                <label for="bedroom" class="sr-only">Select Bedrooms</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="Bedrooms" data-style="bg-white" id="bedroom" name="bedroom">
                    <option>Studio</option>
                   @for ($i =1 ;$i<=20;$i++)
                        <option value="{{$i}}" @selected($i==request()->bedroom)>@if($i<10)0{{$i}}@else{{$i}}@endif</option>    
                   @endfor
                </select>
            </div>
            <div class="form-group p-1">
                <label for="sleeps" class="sr-only">Select Sleeps</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="Sleeps" data-style="bg-white" id="sleeps" name="sleeps">
                    @for ($i =1 ;$i<=20;$i++)
                        <option value="{{$i}}" @selected($i==request()->sleeps)>@if($i<10)0{{$i}}@else{{$i}}@endif</option>    
                    @endfor
                </select>
            </div>
            <div class="form-group p-1">
                <label for="property_types" class="sr-only">Property Types</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="Property Types" data-style="bg-white" id="property_types" name="property_types">
                   @foreach ($propertyTypes as $propertyType)
                       <option value="{{$propertyType->id}}"  @selected($propertyType->id==request()->property_types)>{{$propertyType->property_type_name}}</option>
                   @endforeach
                </select>
            </div>
            <div class="form-group p-1">
                <label for="property_sort_by" class="sr-only">Property Sort By</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="Property Sort By" data-style="bg-white" id="property_sort_by" name="property_sort_by">
                    <option value="">Property Sort By</option>
                    <option value="bedsDesc" @selected("bedsDesc" ==request()->property_sort_by)>Bedrooms: Most to Least</option>
                    <option value="bedsAsc"  @selected("bedsAsc" ==request()->property_sort_by)>Bedrooms: Least to Most </option>
                    <option value="priceAsc"  @selected("priceAsc" ==request()->property_sort_by)>Price: Low to High</option>
                    <option value="priceDesc"  @selected("priceDesc" ==request()->property_sort_by)>Price: High to Low</option>
                </select>
            </div>
            <div class="form-group p-1">
                <label for="region" class="sr-only">Region</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="Region" data-style="bg-white" id="region" name="region" onchange="getCityByRegionId(this.value,'selectpicker')">
                    @foreach ($regions as $region)
                        <option value="{{$region->id}}" @selected($region->id == request()->region)>{{$region->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group p-1">
                <label for="city_name" class="sr-only">City</label>
                <select class="form-control border-0 shadow-xxs-1 bg-transparent font-weight-600 selectpicker" title="City" data-style="bg-white" id="city_name" name="city">
                    <option value=""></option>
                    @if (!empty($cities))
                        @foreach ($cities as $city)
                            <option value="{{$city->id}}" @selected($city->id ==request()->city)>{{$city->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group p-1">
                <a href="#advanced-search-filters-5" class="btn btn-primary border-0 shadow-xxs-1 text-gray-light" data-toggle="collapse" data-target="#advanced-search-filters-5" aria-expanded="true" aria-controls="advanced-search-filters-5"> <span>More Filters</span> <span class="ml-auto">...</span> </a>
            </div>
            <div id="advanced-search-filters-5" class="row pt-2 collapse p-1 w-100" data-parent="#accordion-5">
                {{-- @dd(request()->amenities) --}}
                @foreach ($amenities as $amenity)
                    <div class="col-sm-6 col-md-4 col-lg-3 py-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="amenities[]" id="check_{{$amenity->id}}" value="{{$amenity->id}}" @if(request()->amenities !=null) @checked(in_array($amenity->id,request()->amenities)) @endif>
                            <label class="custom-control-label justify-content-start" for="check_{{$amenity->id}}">{{$amenity->name}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary btn-block shadow-none">Search</button>
        </div>
    </form>
</div>