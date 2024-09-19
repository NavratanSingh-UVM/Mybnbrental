@extends('admin.layouts.master')
@push('title')
Create Property
@endpush
@push('css')
<link href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('assets/calender-css/fonts/icomoon/style.css') }}"> --}}
{{-- <link href='{{ asset('assets/calender-css/fullcalendar/packages/core/main.css') }}' rel='stylesheet' />
<link href='{{ asset('assets/calender-css/fullcalendar/packages/daygrid/main.css') }}' rel='stylesheet' /> --}}
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="{{ asset('assets/calender-css/css/bootstrap.min.css') }}">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
 <!-- Style -->
 <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
 @if (!empty($propertyListing))
<style>
   .stepwizard a {
      pointer-events: auto;
   }
</style>
@endif
@endpush
@section('content')
<!--**********************************
   Content body start
   ***********************************-->
<div class="content-body">
   <div class="row page-titles mx-0">
      <div class="col p-md-0">
         @include('flash-message.flash-message')
         <div class="row">
            <div class="col-md-6">
               <h4 style="color:black">Create Property</h4>
            </div>
            <div class="col-md-6 text-right">
               <a href="{{ route('admin.property.listing.index') }}" class="btn mb-1 btn-primary float-right">Back 
               <span class="btn-icon-right"><i class="fa fa-angle-double-left"></i></span>
               </a> 
            </div>
         </div>
      </div>
   </div>
   <!-- row -->
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
					<div class="stepwizard col-md-offset-3">
						<div class="stepwizard-row setup-panel">
							<div class="stepwizard-step">
								<a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
								<p>Property Information</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">2</a>
								<p>Aminites & Attraction</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">3</a>
								<p>Loaction Info</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">4</a>
								<p>Rental Rates</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-5" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">5</a>
								<p>Photos</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-6" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">6</a>
								<p>Rental Policies</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-7" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">7</a>
								<p>Calender</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-8" type="button" class="btn btn-default btn-circle" disabled aria-disabled="true">8</a>
								<p>Reviews</p>
							</div>
							<div class="stepwizard-step">
								<a href="#step-9" type="button" class="btn btn-default btn-circle" disabled>9</a>
								<p>Owner Information</p>
							</div>
						</div>
					</div>
                  	<form id="listing_form">
                     	<input type="hidden" name="property_listing_id" value="{{ $propertyListing->id??"" }}">
                     	<input type="hidden" name="user_id" value="{{ Auth()->user()->id }}">
                     	<div class="row setup-content m-auto" id="step-1">
							<div class="col-md-6">
								<div class="form-group">
									<label for="property-name">Property Name</label>
									<input type="text" name="property_name" class="form-control" placeholder="Property Name" id='property-name' value="{{ $propertyListing->property_name??"" }}">
									<span class="property_name text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="property-photo">Property Photo</label>
									<div class="custom-file">
										@if(!empty($propertyListing))
										<img src="{{ url('public/storage/upload/property_image/main_image/'.$propertyListing->property_main_photos) }}" alt="" srcset="" height="100" width="100">
										<input type="hidden" name="old_image" value="{{ $propertyListing->property_main_photos??"" }}">
										@endif
										<input type="file" class="form-control" id="property-photo" name="property_main_photo" accept=".png, .jpg, .jpeg, .jpg">
										{{-- <label class="custom-file-label">Choose file</label> --}}
										<span class="property_main_photo text-danger"></span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="square-feet">Square Feet</label>
									<input type="text" name="square_feet" class="form-control" placeholder="Square feet" id="square-feet" value="{{ $propertyListing->square_feet??"" }}">
									<span class="square_feet text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="propery-type">Property Type</label>
									<select class="form-control" name="property_type" id="propery-type">
										<option value="">Select Property type</option>
										@foreach ($propertyTypes as $propertyType)
										<option value="{{ $propertyType->id }}" @if (!empty($propertyListing))@selected($propertyType->id ==$propertyListing->property_type_id)@endif>{{  $propertyType->property_type_name }}</option>@endforeach
									</select>
									<span class="property_type text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="bedrooms">Bedrooms</label>
									<select class="form-control" name="bedrooms" id="bedrooms">
										<option value="">Select Bedrooms</option>
										@for($i=1;$i<=20;$i++)
											@if($i ==20)
												<option value="{{ $i }}+_bedrooms" @if (!empty($propertyListing))@selected($i."+_bedrooms" ==$propertyListing->bedrooms)@endif>{{ $i }}+ Bedrooms</option>
											@else
												<option value="{{ $i }}_bedrooms" @if (!empty($propertyListing))@selected( $i."_bedrooms" ==$propertyListing->bedrooms)@endif>{{ $i }} Bedrooms</option>
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
										<div class="col-6">
											<input type="text" name="sleeps1" class="form-control" placeholder="Sleeps" id="sleeps" value="{{ $propertyListing->sleeps??"" }}">
										</div>
										<div class="col-6">
											<input type="text" name="sleeps2" class="form-control" placeholder="sleeps" id="sleeps">
										</div>
									</div>
									<span class="sleeps text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group ">
									<label for="avg-night">Avg. Night</label>
									@if (!empty($propertyListing))		
										@php
											$avg_night = explode(" ",$propertyListing->avg_night_rates);		
										@endphp
									@endif
									<div class="input-group">
										<input type="text" name="avg_night" class="form-control" placeholder="Avg Night" id="avg-night" value="{{$propertyListing->avg_night_rates??'' }}">
										<div class="input-group-append">
											<select name="avg_night_rate" id="" class="form-control">
												<option value="">Select </option>
												<option value="Nightly Rate"@if(!empty($propertyListing))@selected("Nightly Rate" ==$propertyListing->avg_rate_unit)@endif>Nightly Rate</option>
												<option value="Weekly Rate"@if(!empty($propertyListing))@selected("Weekly Rate" == $propertyListing->avg_rate_unit)@endif>Weekly Rate</option>
												<option value="Monthly Rate" @if(!empty($propertyListing))@selected("Monthly Rate" ==$propertyListing->avg_rate_unit)@endif>Monthly Rate</option>
											 </select>
										</div>
									</div>
									<span class="avg_night text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="baths">Baths</label>
									<input type="text" name="baths" class="form-control" placeholder="Baths" id="baths" value="{{ $propertyListing->baths??"" }}">
									<span class="baths text-danger"></span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control h-150px" rows="6" id="description" name="description">{{ $propertyListing->description??"" }}</textarea>
									<span class="description text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="property_location">Country</label>
									<select class="form-control" name="country_name" id="country_name">
										<option value="">Select Country</option>
										@foreach ($countries as $country)
										<option value="{{ $country->id }}" @if (!empty($propertyListing))@selected($country->id ===$propertyListing->country_id)@endif>{{ $country->name }}</option>
										@endforeach
									</select>
									<span class="country text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="state_name">State</label>
									<select class="form-control" name="state" id="state_name">
										<option value="">Select State</option>
										@if (!empty($states))
										 	@foreach ($states as $state)
												<option value="{{ $state->id }}" @if (!empty($propertyListing))@selected($state->id ===$propertyListing->state_id)@endif>{{ $state->name }}</option>
										 	@endforeach
										@endif
									</select>
									<span class="state text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="region_name">Region</label>
									<select class="form-control" name="region_name" id="region_name">
										<option value="">Select Region</option>
										@if (!empty($regions))
											@foreach ($regions as $region)
												<option value="{{ $region->id }}" @if (!empty($propertyListing)) @selected($region->id ===$propertyListing->region_id)@endif>{{ $region->name }}</option>
											@endforeach
										@endif
									</select>
									<span class="region text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="city_name">City</label>
									<select class="form-control" name="city_name" id="city_name">
										<option value="">Select city</option>
											@if (!empty($cities))
												@foreach ($cities as $city)
													<option value="{{ $city->id }}" @if (!empty($propertyListing)) @selected($city->id ===$propertyListing->city_id) @endif>{{ $city->name }}</option>
												@endforeach
											@endif
									</select>
									<span class="city text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="sub_city_name">Sub City</label>
									<select class="form-control" name="sub_city" id="sub_city_name">
										<option value="">Select sub city</option>
											@if (!empty($sub_cities))
												@foreach ($sub_cities as $sub_city)
													<option value="{{ $sub_city->id }}" @if (!empty($propertyListing)) @selected($sub_city->id ===$propertyListing->sub_city_id) @endif>{{ $sub_city->name }}</option>
												@endforeach
											@endif
									</select>
									<span class="sub_city text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" name="address" class="form-control" placeholder="Address" id="address" value="{{ $propertyListing->address??"" }}">
									<span class="address text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="town">Town</label>
									<input type="text" name="town" class="form-control" placeholder="Town" id="town" value="{{ $propertyListing->town??"" }}">
									<span class="town text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="zipcode">Zipcode</label>
									<input type="text" name="zipcode" class="form-control" placeholder="Zipcode" id="zipcode" value="{{ $propertyListing->zip_code??"" }}">
									<span class="zipcode text-danger"></span>
								</div>
							</div>
							<div class="col-md-12 mt">
								<div class="form-group">
									<label for="video_link">Youtube Video Link  (Embed Link)</label>
									<input type="text" class="form-control" name="youtube_video_link" id="video_link" value="{{ $propertyListing->youtube_video_link??"" }}">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto">
								   <button type="button" class="btn btn-primary property_information">Next & Save</button>
								</div>
							</div>
                     	</div>
                     	<div class="row setup-content m-auto" id="step-2">
                        	<div class="col-md-12">
								@if (!empty($propertyListing))
									@php
										$subAminitiesId = [];
										$subAminities = $propertyListing->property_aminities->toArray();
										foreach ($subAminities as $key => $subAminitie):
											$subAminitiesId[] =  $subAminitie['sub_aminities_id'];
										endforeach;
									@endphp
								@endif
                           		<div class="card">
                             		@if(!empty($mainAminity))
                              			@foreach($mainAminity as $aminities)
                             		 		<div class="card-body">
                                 				<h4 class="card-title">{{ $aminities->aminity_name }}</h4>
                                				<div class="basic-form">
                                    				<div class="form-group">
                                       					@if(!empty($aminities->subAminities))
									   						<div class="row">
                                       							@foreach($aminities->subAminities as $subAminities)
																	<div class="col-md-3">
																		<div class="form-check form-check-inline mt-2">
																			<label class="form-check-label">
																			<input type="checkbox" class="form-check-input" value="{{ $subAminities->id }}" name="sub_aminites" @isset($subAminitiesId)
																				@if (in_array( $subAminities->id,$subAminitiesId))
																					checked
																				@endif
																			@endisset>{{ $subAminities->name }}</label>
																		</div>
																	</div>
																@endforeach
															</div>
                                       					@endif
                                    				</div>
                                 				</div>
                              				</div>
                              			@endforeach
                             		@endif
                           		</div>
                        	</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary nextBtn2">Next & Save</button>
								</div>
							</div>
                     	</div>
						<div class="row setup-content m-auto" id="step-3">
							<div class="col-md-12">
								<label for="location">Address</label>
								<input type="text" class="form-control" id="location" name="location" placeholder="Search address" value="{{ $property->address??"" }}">
							</div>
							<div class="col-md-12">
								{{-- <div class="form-group"> --}}
								   <div id="map" style="width:100%;height:600px;margin-top:10px;"></div>
								   <div id="infowindow-content">
									<span id="place-name" class="title"></span><br />
									<span id="place-address"></span>
								  </div>
								{{-- </div> --}}
							 </div>
							<div class="col-md-6">
							   <div class="form-group">
								  <label for="iframe_link">Iframe Link (Embed Link)</label>
								  <input type="text" class="form-control" id="iframe_link" name="iframe_link" value="{{ $propertyListing->iframe_link_google??"" }}">
							   </div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="latitude">Latitude</label>
											<input type="text" class="form-control" id="latitude" name="latitude" value="{{ $propertyListing->latitude??"" }}">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="longitude">Longitude</label>
											<input type="text" class="form-control" id="longitude" name="longitude" value="{{ $propertyListing->longitude??"" }}">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="form-group row mt -">
							   <div class="col-md-10 ml-auto mr-2">
								  <button type="button" class="btn btn-danger prevBtn">Back</button>
							   </div>
							</div>
							<div class="form-group row ">
							   <div class="col-md-10 ml-auto">
								  <button type="button" class="btn btn-primary location_info">Next & Save</button>
							   </div>
							</div>
						</div>
                     	<div class="row setup-content m-auto" id="step-4">
							<div class="col-md-2">
								<div class="form-group">
									<label for="session_name">Season Name</label>
									<input type="text" name="session_name" class="form-control">
									<span class="session_name text-danger"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="from_date">Start Date</label>
									<input type="date" name="from_date" class="form-control">
									<span class="from_date text-danger"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="to_date">End Date</label>
									<input type="date" name="to_date" class="form-control">
									<span class="to_date text-danger"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="nightly_rate">Nightly Rate</label>
									<input type="text" name="nightly_rate" class="form-control">
									<span class="nightly_rate text-danger"></span>
								</div>
							</div>
							{{-- <div class="col-md-2">
								<div class="form-group">
									<label for="weekly_rate">Weekly Rate</label>
									<input type="text" name="weekly_rate" class="form-control" id="weekly_rate">
									<span class="weekly_rate text-danger"></span>
								</div>
							</div> --}}
							{{-- <div class="col-md-2">
								<div class="form-group">
									<label for="weekend_rate">Weekend Rate</label>
									<input type="text" name="weekend_rate" class="form-control" id="weekend_rate">
									<span class="weekend_rate text-danger"></span>
								</div>
							</div> --}}
							{{-- <div class="col-md-2">
								<div class="form-group">
									<label for="monthly_rates">Monthly Rate</label>
									<input type="text" name="monthly_rates" class="form-control">
									<span class="monthly_rates text-danger"></span>
								</div>
							</div> --}}
							<div class="col-md-2">
								<div class="form-group">
									<label for="minimum_stay">Minimum Stay</label>
									<input type="text" name="minimum_stay" class="form-control">
									<span class="minimum_stay text-danger"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<button type="button" class="btn btn-primary add_rates" style="margin-top:32px;">Add Rates</button>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="property_rates">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Season Name</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>Nightly Rate</th>
											{{-- <th>Weekly Rate</th>
											<th>Weekend Rate</th>
											<th>Monthly Rate</th> --}}
											<th>Minimum Stay</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
							<div class="col-md-12">
								<h4>Fees - Define your fees, like cleaning, etc.</h4>
							</div>
							{{-- <div class="col-md-2">
								<div class="form-group">
									<label for="admin_fees">Admin Fee</label>
									<input type="text" name="admin_fees" class="form-control" id="admin_fees" value="{{ $propertyListing->admin_fees??"" }}">
									<span class="admin_fees text-danger"></span>
								</div>
							</div> --}}
							<div class="col-md-2">
								<div class="form-group">
									<label for="cleaning_fees">Cleaning Fees</label>
									<input type="text" name="cleaning_fees" class="form-control" id="cleaning_fees" value="{{ $propertyListing->cleaning_fees??"" }}">
									<span class="cleaning_fees text-danger"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="refundable_damage_deposite">Refundable Damage Deposit</label>
									<input type="text" name="refundable_damage_deposite" class="form-control" id="refundable_damage_deposite" value="{{ $propertyListing->refundable_damage_deposite??"" }}">
									<span class="refundable_damage_deposite text-danger"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="danage_waiver">Damage Waiver</label>
									<input type="text" name="danage_waiver" class="form-control" id="danage_waiver" value="{{ $propertyListing->danage_waiver??"" }}">
									<span class="danage_waiver text-danger"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="peet_fee">Pet Fee</label>
									<div class="input-group">
										<input type="text" name="peet_fee" class="form-control" id="peet_fee" value="{{ $propertyListing->peet_fee??"" }}">
										<div class="input-group-append">
											<select name="pet_rate_unit" id="" class="form-control">
												<option value="">Select Day</option>
												<option value="Per Day">Per Day</option>
												<option value="Per Week">Per Week</option>
												<option value="Per Stay">Per Stay</option>
											</select>
										</div>
									</div>
									<span class="peet_fee text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="extra_person_fee">Extra Person Fee</label>
											<input type="text" name="extra_person_fee" class="form-control" id="extra_person_fee" placeholder="Extra Person Fees" value="{{ $propertyListing->extra_person_fee??"" }}">
											<span class="extra_person_fee text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="after">After</label>
											<select name="after_guest" id="after" class="form-control">
												<option value="">Select Guests</option>
												@for ($i=1;$i<=25;$i++)
													@if($i==25)
														<option value="{{ $i }}+" @if (!empty($propertyListing))@selected($i."+"==$propertyListing->after_guest)@endif>{{ $i }} + Guests</option>
													@else
														<option value="{{ $i }}"@if (!empty($propertyListing))@selected($i==$propertyListing->after_guest)@endif>{{ $i }} Guests</option>
													@endif
												@endfor
											</select>
											<span class="after text-danger"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="poolheating_fee">Pool Heating Fee</label>
											<input type="text" name="poolheating_fee" class="form-control" id="poolheating_fee" placeholder="Pool Heating fess" value="{{ $propertyListing->poolheating_fee??"" }}">
											<span class="poolheating_fee text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="pool_heating_fees_perday">Per Day</label>
											<select name="pool_heating_fees_perday" id="pool_heating_fees_perday" class="form-control">
												<option value="">Select Day</option>
												<option value="Per Day" @if (!empty($propertyListing)) @selected("Per Day"==$propertyListing->pool_heating_fees_perday) @endif>Per Day</option>
												<option value="Per Week" @if (!empty($propertyListing)) @selected("Per Week"==$propertyListing->pool_heating_fees_perday) @endif>Per Week</option>
												<option value="Per Stay"@if (!empty($propertyListing)) @selected("Per Stay"==$propertyListing->pool_heating_fees_perday)@endif>Per Stay</option>
											</select>
											<span class="after text-danger"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="check_in">Check In</label>
									<input type="time" name="check_in" class="form-control" id="check_in" placeholder="Pool Heating fess" value="{{ $propertyListing->check_in??"" }}">
									<span class="check_in text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="check_out">Check Out</label>
									<input type="time" name="check_out" class="form-control" id="check_out" placeholder="Pool Heating fess" value="{{ $propertyListing->check_out??"" }}">
									<span class="check_out text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tax_rates">Tax Rates (%)</label>
									<input type="text" name="tax_rates" class="form-control" id="tax_rates" placeholder="Tax Rates(%)" value="{{ $propertyListing->tax_rates??"" }}">
									<span class="rates text-danger"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="change_over">Change-Over</label>
									<select name="change_over" id="change_over" class="form-control">
										<option value="">Flexible</option>
										<option value="monday"@if (!empty($propertyListing))@selected("monday"==$propertyListing->change_over)@endif>Monday</option>
										<option value="Tuesday"@if (!empty($propertyListing))@selected("Tuesday"==$propertyListing->change_over)@endif>Tuesday</option>
										<option value="Wednesday"@if (!empty($propertyListing))@selected("Wednesday"==$propertyListing->change_over)@endif>Wednesday</option>
										<option value="Thursday"@if (!empty($propertyListing))@selected("Thursday"==$propertyListing->change_over)@endif>Thursday</option>
										<option value="Friday"@if (!empty($propertyListing))@selected("Friday"==$propertyListing->change_over)@endif>Friday</option>
										<option value="Saturday" @if (!empty($propertyListing))@selected("Saturday"==$propertyListing->change_over)@endif>Saturday</option>
										<option value="Sunday"@if (!empty($propertyListing))@selected("Sunday"==$propertyListing->change_over)@endif>Sunday</option>
									</select>
									<span class="change_over text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group">
									<label for="all_rates_are_in">All Rates are in</label>
									<select name="all_rates_are_in" id="all_rates_are_in" class="form-control">
										<option value="">Select Currency</option>
										@foreach($currencies as $currency)
											<option value="{{ $currency->id }}" @if (!empty($propertyListing))@selected($currency->id==$propertyListing->currency_id)@endif>{{ $currency->currency_name }}</option>
										@endforeach
									</select>
									<span class="all_rates_are_in text-danger"></span>
								</div>
							</div>
                       		<div class="col-md-6"></div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="rates_notes">Rates Notes</label>
									<textarea class="form-control h-150px" rows="6" id="rates_notes" name="rates_notes">@if (!empty($propertyListing))
										{{ $propertyListing->rates_notes }}
									@endif</textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary rental_rates">Next & Save</button>
								</div>
							</div>
                     	</div>
						<div class="row setup-content m-auto" id="step-5">
							<div class="col-md-12">
								<div class="form-group">
					
									<label for="upload_galery_image">Upload Gallery Image</label>
									<input type="file" class="form-control" id="upload_galery_image" name="upload_galery_image"  multiple="multiple" accept="image/jpeg, image/png, image/jpg" onchange="previewFiles(this);" >
									<output id='preview' ></output>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary upload_gellery_image">Next & Save</button>
								</div>
							</div>
						</div>
					    <div class="row setup-content m-auto" id="step-6">
							<div class="col-md-12">
								<div class="form-group">
									<label for="rental_policies">Rental Policies</label>
									<textarea class="form-control h-150px" rows="6" id="rental_policies" name="rental_policies">@if (!empty($propertyListing)){{ $propertyListing->rental_policies }}@endif</textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="cancel_polices">Cancellation Policies</label><br>
									@foreach ($cancelletionPolicies as $cancelletionPolicy)
										<input type="radio" value="{{$cancelletionPolicy->id}}" name="cancelletion_policies" id="cancelletion_{{$cancelletionPolicy->id}}" @if (!empty($propertyListing)) @checked($cancelletionPolicy->id ==$propertyListing->cancelletion_policies_id) @endif>
										<label for="cancelletion_{{$cancelletionPolicy->id}}"><strong> {{$cancelletionPolicy->name}}</strong> : <span>{{$cancelletionPolicy->description}}</span></label></br>
                                    @endforeach
								</div>
							</div>
							{{-- <div class="col-md-6">
								<div class="form-group">
									<label for="upload_rental_policies">Upload Rental Policies</label>
									<input type="file" class="form-control" id="upload_rental_policies" name="upload_rental_policies">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="upload_cancel_policies">Upload Cancel Policies</label>
									<input type="file" class="form-control" id="upload_cancel_policies" name="upload_cancel_policies">
								</div>
							</div> --}}
							<div class="form-group row">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary rental_policies">Next & Save</button>
								</div>
							</div>
					    </div>
						<div class="row setup-content m-auto" id="step-7">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											{{-- @dd($propertyListing->icalLink[0]->ical_link) --}}
											<label for="import_calender_url">Import Calender Url</label>
											<input type="text" name="import_calender_url" class="form-control" id="import_calender_url" placeholder="Import Calender link" value="{{$propertyListing?->icalLink[0]?->ical_link??""}}">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<button type="button" class="btn btn-primary sync_now" style="margin: 30px;">Sync Now</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div id='calendar'></div>
							</div>
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary calender_syncronization">Next & Save</button>
								</div>
							</div>
						</div>
						<div class="row setup-content m-auto" id="step-8">
							<div class="col-md-6">
								<div class="form-group">
									<label for="reviews_heading">Reviews Heading</label>
									<input type="text" class="form-control" id="reviews_heading" name="reviews_heading">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="guest_name">Guest Name</label>
									<input type="text" class="form-control" id="guest_name" name="guest_name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="place">Place</label>
									<input type="text" class="form-control" id="place" name="place">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="reviews">Reviews</label>
									<textarea class="form-control" id="reviews" name="reviews"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="rating">Rating</label>
									<select name="rating" id="rating" class="form-control">
										<option value="">Select Rating</option>
										@for($i=1;$i<=5;$i++)
											<option value="{{ $i }}">{{ $i }} Star</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<button type="button" class="btn btn-primary add_reviews" style="margin-top:32px;">Add Reviews</button>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="reviews_rating">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Reviews Heading</th>
											<th>Guest Name</th>
											<th>Reviews</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
							{{-- <div class="col-md-6"></div> --}}
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary reviews_rating">Next & Save</button>
								</div>
							</div>
						</div>
						<div class="row setup-content m-auto" id="step-9">
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="first_name">First Name</label>
								   <input type="text" name="first_name" class="form-control" placeholder=" First Name" id="first_name" value="{{ $propertyListing->owner_first_name??"" }}">
								   <span class="first_name text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="last_name">Last Name</label>
								   <input type="text" name="last_name" class="form-control" placeholder="Last Name" id="last_name" value="{{ $propertyListing->owner_last_name??"" }}">
								   <span class="last_name text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="phone">Phone</label>
								   <input type="text" name="phone" class="form-control" placeholder="Phone" id="phone" value="{{ $propertyListing->owner_phone??"" }}">
								   <span class="phone text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="Address">Street  Address</label>
								   <input type="text" name="owner_address" class="form-control" placeholder="Address" id="Address" value="{{ $propertyListing->owner_address??"" }}">
								   <span class="owner_address text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="email">Email</label>
								   <input type="text" name="email" class="form-control" placeholder="Email" id="email" value="{{ $propertyListing->owner_email??"" }}">
								   <span class="email text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="city">City</label>
								   <input type="text" name="city" class="form-control" placeholder="City" id="city" value="{{ $propertyListing->owner_city??"" }}">
								   <span class="city text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="ouwner">Owner/Manager</label>
								   <input type="text" name="ouwner" class="form-control" placeholder="Owner" id="ouwner"  value="{{ $propertyListing->owner_type??"" }}">
								   <span class="ouwner text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="state">State</label>
								   <input type="text" name="state" class="form-control" placeholder="State" id="state" value="{{ $propertyListing->owner_state??"" }}">
								   <span class="state text-danger"></span>
								</div>
							</div>
							<div class="col-md-6 mt-3">
								<div class="form-group ">
								   <label for="zipcode">Zipcode</label>
								   <input type="text" name="zipcode" class="form-control" placeholder="zipcode" id="zipcode" value="{{ $propertyListing->owner_zipcode??"" }}">
								   <span class="zipcode text-danger"></span>
								</div>
							</div>
							<div class="col-md-6  mt-3">
								<div class="form-group ">
								   <label for="owner_fax">Owner Fax</label>
								   <input type="text" name="owner_fax" class="form-control" placeholder="Owner Fax" id="owner_fax" value="{{ $propertyListing->owner_owner_fax??"" }}">
								   <span class="owner_fax text-danger"></span>
								</div>
							</div>
							<div class="col-md-6  mt-3">
								<div class="form-group ">
								   <label for="profile_image">Profile Image</label>
								   <div class="custome-file">
									   @if(!empty($propertyListing))
											<img src="{{ url('public/storage/upload/owner_image/'.$propertyListing->owner_profile_image) }}" alt="" srcset="" height="100" width="100">
											<input type="hidden" name="owner_old_image" value="{{ $propertyListing->owner_profile_image??"" }}">
										@endif
								   </div>
								   <input type="file" name="profile_image" class="form-control" placeholder="Alternate Email" id="profile_image">
								   <span class="profile_image text-danger"></span>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto mr-2">
									<button type="button" class="btn btn-danger prevBtn">Back</button>
								</div>
							</div>
							<div class="form-group row mt-4">
								<div class="col-md-10 ml-auto">
									<button type="button" class="btn btn-primary create_property">@if(!empty($propertyListing)) Update Property @else Create Property @endif </button>
								</div>
							</div>
						</div>
                  	</form>
               	</div>
            </div>
      	</div>

		{{-- Rental Rates Update Model start  --}}
		<div class="modal fade" id="rental_rates_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Update Rental Rates Form</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="update_rental_rates"> 
							@csrf
							<input type="hidden" name="id" value="">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="session_name" class="col-form-label">Season Name:</label>
										<input type="text" class="form-control" id="session_name" value="" name="session_name">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="from_date" class="col-form-label">From Date:</label>
										<input type="date" class="form-control" id="from_date" name="from_date">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="to_date" class="col-form-label">To Date:</label>
										<input type="date" class="form-control" id="to_date" name="to_date" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="nightly_rate" class="col-form-label">Nightly Rate:</label>
										<input type="text" class="form-control" id="nightly_rate" name="nightly_rate" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="weekly_rate" class="col-form-label">Weekly Rate:</label>
										<input type="text" class="form-control" id="weekly_rate" name="weekly_rate" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="weekend_rate" class="col-form-label">Weekend Rate:</label>
										<input type="text" class="form-control" id="weekend_rate" name="weekend_rate" value="weekend_rate">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="monthly_rate" class="col-form-label">Monthly Rate:</label>
										<input type="text" class="form-control" id="monthly_rate" name="monthly_rate" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="minimum_stay" class="col-form-label">Minimum Stay:</label>
										<input type="text" class="form-control" id="minimum_stay" name="minimum_stay" value="">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary update_rental_rates">Update Rental Rates</button>
					</div>
				</div>
			</div>
		</div>
		{{-- Rental Rates Update Model end  --}}
		{{-- Riviews Rating Model Start --}}
		<div class="modal fade" id="revies_rating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Reviews Rating Update Form</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="update_reviews_rating"> 
							@csrf
							<input type="hidden" name="id" value="">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="reviews_heading" class="col-form-label">Reviews Heading:</label>
										<input type="text" class="form-control" id="reviews_heading" value="" name="reviews_heading">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="guest_name" class="col-form-label">Guest Name:</label>
										<input type="text" class="form-control" id="guest_name" name="guest_name">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="place" class="col-form-label">Place:</label>
										<input type="text" class="form-control" id="place" name="place" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="reviews" class="col-form-label">Reviews:</label>
										<textarea type="text" class="form-control" id="reviews" name="reviews"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group rating">
										<label for="rating_update" class="col-form-label">Rating</label><br>
										<select name="rating_update" id="rating_update" class="form-control">
											<option value="">Select Rating</option>
											@for($i=1;$i<=5;$i++)
												<option value="{{ $i }}">{{ $i }} Star</option>
											@endfor
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary update_reviews">Update</button>
					</div>
				</div>
			</div>
		</div>
		{{-- Riviews Rating Model end --}}
	</div>
   	</div>
   <!-- #/ container -->
</div>
<!--**********************************
   Content body end
   ***********************************-->
@endsection
@push('js')
<script src="{{ asset('assets/custom.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('assets/custom/map.js') }}"></script>
<script src="{{ asset('assets/custom/property_information.js') }}"></script>
<script src="{{ asset('assets/custom/aminities_attraction.js') }}"></script>
<script src="{{ asset('assets/custom/location_info.js') }}"></script>
<script src="{{ asset('assets/custom/rental_rates.js') }}"></script>
<script src="{{ asset('assets/custom/gallery_image.js') }}"></script>
<script src="{{ asset('assets/custom/rental-policies.js') }}"></script>
<script src="{{ asset('assets/custom/calender_syncronization.js') }}"></script>
<script src="{{ asset('assets/custom/reviews_rating.js') }}"></script>
<script src="{{ asset('assets/custom/owner_information.js') }}"></script>
{{-- <script src='{{ asset('assets/calender-css/fullcalendar/packages/core/main.js') }}'></script>
<script src='{{ asset('assets/calender-css/fullcalendar/packages/interaction/main.js') }}'></script>
<script src='{{ asset('assets/calender-css/fullcalendar/packages/daygrid/main.js') }}'></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&libraries=places&callback=initMap"></script>

<script>

getEvent();
     function getEvent () {
        var result = false;
        try {
            
            $.ajax({
                url:"{{route('admin.property.listing.get.property.event')}}",
                method:"POST",
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json",
                },
                data:JSON.stringify({id:$("input[name=property_listing_id]").val()}),
                async: false,
                success: function(data) {
                    // result = data.data;
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar:{
                            right:'prev,next today',
                            center:'title',
                            left:'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        initialDate: moment().format('YYYY-MM-DD'),
                        navLinks:true,
                        businessHours:true,
                        editable: true,
                        selectable:true,
                        events:JSON.parse(data.data),
                        select:function(datetime){
                            const startdate =moment(datetime.start).format('YYYY-MM-DD');
                            const today_date = moment().format('YYYY-MM-DD');
                            if(startdate < today_date)
                            {
                                alert("Back date event not allowed ");
                                calendar.unselect();
                                return false;
                            }
                            $("#bookingEvent").modal('show');
                            $(".start_date").val(moment(datetime.start).format('YYYY-MM-DD'));
                            $("#property_id").val($("input[name=property_id]").val());
                            $(".end_date").val(moment(datetime.end).subtract(1, 'days').format('YYYY-MM-DD'));

                        },
                        
                    });
                    calendar.render();
                },

            });
            console.log();
            // return (result);
        } catch (error) {
            console.log(error.message)
            
        }
    }
	$(document).ready(function(){
		// Step Form Variable
		var navListItems = $('div.setup-panel div a'),allWells = $('.setup-content'),allPrevBtn = $('.prevBtn');
		allWells.hide();
		navListItems.click(function (e) {
       		e.preventDefault();
       		var $target = $($(this).attr('href')),
       		$item = $(this);
			if (!$item.hasClass('disabled')) {
				navListItems.removeClass('btn-primary').addClass('btn-default');
				$item.addClass('btn-primary');
				allWells.hide();
				$target.show();
				$target.find('input:eq(0)').focus();
			}
    	});

		allPrevBtn.click(function(){
			var curStep = $(this).closest(".setup-content"),
			curStepBtn = curStep.attr("id"),
			prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
			prevStepWizard.removeAttr('disabled').trigger('click');
     	});

		// first Step Open Form
		$('div.setup-panel div a.btn-primary').trigger('click');
	});

	
</script>
@endpush