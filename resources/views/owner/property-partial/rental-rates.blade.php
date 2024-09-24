<div class="tab-pane tab-pane-parent fade px-0" id="rental-rates" role="tabpanel" aria-labelledby="media-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0" id="heading-media">
            <h5 class="mb-0">
                <button class="btn btn-lg collapse-parent btn-block border shadow-none" data-toggle="collapse" data-number="4." data-target="#rental-rates-collapse" aria-expanded="true" aria-controls="rental-rates-collapse">
                    <span class="number">4.</span>
                    Rental Rates
                </button>
            </h5>
        </div>
        <div id="rental-rates-collapse" class="collapse collapsible" aria-labelledby="heading-rental-rates" data-parent="#collapse-tabs-accordion">
           <div class="card-body py-4 py-md-0 px-0">
                <div class="row">
                    <div class="col-lg-12">
                       <div class="card mb-6">
                            <div class="col-md-12">
                                <h2>Fees - Define your fees, like cleaning, etc.</h2>
                            </div>
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cleaning_fees">Cleaning Fees</label>
                                            <input type="text" name="cleaning_fees" class="form-control" id="cleaning_fees" value="{{ $propertyListing->cleaning_fees ?? '' }}">
                                            <span class="cleaning_fees text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="refundable_damage_deposite">Refundable Damage Deposit</label>
                                            <input type="text" name="refundable_damage_deposite" class="form-control"  id="refundable_damage_deposite" value="{{ $propertyListing->refundable_damage_deposite ?? '' }}">
                                            <span  class="refundable_damage_deposite text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="peet_fee">Pet Fee</label>
                                            <div class="input-group">
                                                <input type="text" name="peet_fee" class="form-control" id="peet_fee"  value="{{ $propertyListing->peet_fee ?? '' }}">
                                                <div class="input-group-append">
                                                    <select name="pet_rate_unit" id="" class="form-control">
                                                        <option value="">Select Day </option>
                                                        <option value="Per Day">Per Day </option>
                                                        <option value="Per Week">Per Week </option>
                                                        <option value="Per Stay">Per Stay </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="peet_fee text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="extra_person_fee">Extra Person Fee</label>
                                            <input type="text" name="extra_person_fee" class="form-control" id="extra_person_fee" placeholder="Extra Person Fees" value="{{ $propertyListing->extra_person_fee ?? '' }}">
                                            <span class="extra_person_fee text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="after">After</label>
                                            <select name="after_guest" id="after" class="form-control" style="width: 100%">
                                                <option value="">Select Guests</option>
                                                @for ($i = 1; $i <= 25; $i++)
                                                    @if ($i == 25)
                                                        <option value="{{ $i }}+" @if (!empty($propertyListing)) @selected($i . '+' == $propertyListing->after_guest) @endif> {{ $i }} + Guests</option>
                                                    @else
                                                        <option value="{{ $i }}"@if (!empty($propertyListing)) @selected($i == $propertyListing->after_guest) @endif>{{ $i }} Guests</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <span class="after text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="poolheating_fee">Pool Heating Fee</label>
                                            <input type="text" name="poolheating_fee" class="form-control" id="poolheating_fee" placeholder="Pool Heating fess" value="{{ $propertyListing->poolheating_fee ?? '' }}">
                                            <span class="poolheating_fee text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pool_heating_fees_perday">Per  Day</label><br>
                                            <select name="pool_heating_fees_perday" id="pool_heating_fees_perday" class="form-control" style="width: 100%">
                                                <option value="">Select Day</option>
                                                <option value="Per Day" @if (!empty($propertyListing)) @selected('Per Day' == $propertyListing->pool_heating_fees_perday) @endif>Per Day</option>
                                                <option value="Per Week" @if (!empty($propertyListing)) @selected('Per Week' == $propertyListing->pool_heating_fees_perday) @endif>Per Week</option>
                                                <option value="Per Stay"@if (!empty($propertyListing)) @selected('Per Stay' == $propertyListing->pool_heating_fees_perday) @endif>Per Stay</option>
                                            </select>
                                            <span class="after text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="check_in">Check In</label>
                                            <input type="time" name="check_in" class="form-control" id="check_in" placeholder="Pool Heating fess" value="{{ $propertyListing->check_in ?? '' }}">
                                            <span class="check_in text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="check_out">Check Out</label>
                                            <input type="time" name="check_out" class="form-control" id="check_out" placeholder="Pool Heating fess" value="{{ $propertyListing->check_out ?? '' }}">
                                            <span class="check_out text-danger"></span>
                                        </div>
                                    </div>
                                 @if(!empty($tax->tax))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tax_rates">Tax Rates (%)</label>
                                            <input  type="text" name="tax_rates" class="form-control" id="tax_rates" value="{{$tax->tax  ?? '' }}" disabled>  
                                            <span class="tax_rates text-danger"></span>
                                        </div>
                                    </div>
                                  @endif 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="change_over">Change-Over</label><br>
                                            <select name="change_over" id="change_over" class="form-control" style="width: 100%">
                                                <option value="">Flexible</option>
                                                <option value="monday"  @if (!empty($propertyListing)) @selected('monday' == $propertyListing->change_over) @endif> Monday</option>
                                                <option value="Tuesday"  @if (!empty($propertyListing)) @selected('Tuesday' == $propertyListing->change_over) @endif> Tuesday</option>
                                                <option value="Wednesday"@if (!empty($propertyListing)) @selected('Wednesday' == $propertyListing->change_over) @endif> Wednesday</option>
                                                <option value="Thursday"@if (!empty($propertyListing)) @selected('Thursday' == $propertyListing->change_over) @endif> Thursday</option>
                                                <option value="Friday"@if (!empty($propertyListing)) @selected('Friday' == $propertyListing->change_over) @endif> Friday</option>
                                                <option value="Saturday"@if (!empty($propertyListing)) @selected('Saturday' == $propertyListing->change_over) @endif>Saturday</option>
                                                <option value="Sunday"@if (!empty($propertyListing)) @selected('Sunday' == $propertyListing->change_over) @endif> Sunday</option>
                                            </select>
                                            <span class="change_over text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="all_rates_are_in">All Rates are in</label><br>
                                            <select name="all_rates_are_in" id="all_rates_are_in" class="form-control" style="width: 100%">
                                                <option value="">Select Currency</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}" @if (!empty($propertyListing)) @selected($currency->id == $propertyListing->currency_id) @endif>{{ $currency->currency_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="all_rates_are_in text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="rates_notes">Rates Notes</label>
                                            <textarea class="form-control h-150px" rows="6" id="rates_notes" name="rates_notes">@if (!empty($propertyListing)){{ $propertyListing->rates_notes }} @endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16">
                            <i class="fal fa-long-arrow-left"></i>
                        </span>
                        Prev step
                    </a>
                    <button class="btn btn-lg btn-primary next-button mb-3 rental_rates">@if(!empty($propertyListing)) Update Next @else Next step @endif
                        <span class="d-inline-block ml-2 fs-16">
                            <i class="fal fa-long-arrow-right"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
