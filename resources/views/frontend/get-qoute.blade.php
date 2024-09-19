@extends('frontend.layouts.master')
@section('content')
<section class="mb-5 pb-5 pt-5">
    <div class="container" style="max-width:80%">
        <div class="propertyp">
            <div class="bookingPageKS">
                <h1 class="pheading text-center m-5">{{$travllerInformation->property->property_name}}</h1>
                <div class="row">
                    <div class="col-md-8">
                        <form id='quoteStore'>
                            @csrf
                            <section class="firstBox">
                                <h1>Traveler Information</h1>
                                <div class="form">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6 half">
                                                <input type="hidden" name="guest_id" value="{{request()->uniqid}}">
                                                <label for="fname">Name <span style="color:red;">*</span></label>
                                                <input id="fname" type="text" name="name" value="">
                                                <span class="text-danger name"></span>
                                            </div>
                                            <div class="col-md-6 half">
                                                <label for="email">Email <span style="color:red;">*</span></label>
                                                <input id="femail" type="text" name="email" value="">
                                                <span class="text-danger email"></span>
                                            </div>
                                            <div class="col-md-6 half">
                                                <label for="phone">Phone No. <span style="color:red;">*</span></label>
                                                <input id="phoneno" type="text" name="phone_number"
                                                    placeholder="Phone Number">
                                                <span class="text-danger phone_number"></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </fieldset>
                                </div>
                            </section>

                            <section class="firstBox">
                                <h1>Special Requests</h1>
                                <div class="form pt-0">
                                    <fieldset>
                                        <textarea id="message" placeholder="Write message..." name="message" class="fsvr_special_requests" maxlength="2048" style="resize:none; height:300px;width:100%;"></textarea>
                                        <span class="text-danger message"></span>
                                    </fieldset>
                                </div>
                            </section>
                            <div class="bottombuttom" align="center">
                                <input name="p_submit" type="submit" value="Pay Now">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 pinfo">
                        <section class="booking-info">
                            <h3>BOOKING</h3>
                            <div class="details-content">
                                <div>
                                    <span class="label">Check In</span>
                                    <span class="value">{{date('dS M Y',strtotime($travllerInformation->check_in))}}</span>
                                </div>
                                <div>
                                    <span class="label">Check Out</span>
                                    <span class="value">{{date('dS M Y',strtotime($travllerInformation->check_out))}}</span>
                                </div>
                                <div>
                                    <span class="label">Min Stay</span>
                                    <span class="value">{{$propertiesRates->minimum_stay}}</span>
                                </div>
                                <div>
                                    <span class="label">Number of Guests</span>
                                    <span class="value">{{($travllerInformation->guest+$travllerInformation->children)}}</span>
                                </div>
                                <div>
                                    <span class="label">Total Nights</span>
                                    <span class="value">{{$total_night}}</span>
                                </div>
                            </div>
                            <div class="column-pricing">
                                <h3> PRICING</h3>
                                <div>
                                    <span class="label">Gross Amount</span>
                                    <span class="value">${{$grossAmount}}</span>
                                </div>
                                @if ($travllerInformation->property->admin_fees !=null)
                                <div>
                                    <span class="label">Admin Fees</span>
                                    <span class="value">${{$travllerInformation->property->admin_fees}}</span>
                                </div>
                                @endif
                                @if ($travllerInformation->property->cleaning_fees !=null)
                                <div>
                                    <span class="label">Cleaning Fees</span>
                                    <span class="value">${{$travllerInformation->property->cleaning_fees}}</span>
                                </div>
                                @endif
                                @if ($travllerInformation->property->refundable_damage_deposite !=null)
                                <div>
                                    <span class="label">Ref. Damage Amount</span>
                                    <span class="value">${{$travllerInformation->property->refundable_damage_deposite}}</span>
                                </div>
                                @endif
                                @if ($travllerInformation->property->danage_waiver !=null)
                                <div>
                                    <span class="label">Damage Waiver Amount</span>
                                    <span class="value">${{$travllerInformation->property->danage_waiver}}</span>
                                </div>
                                @endif
                                @if ($travllerInformation->property->peet_fee !=null && $travllerInformation->pet=='1')
                                <div>
                                    <span class="label">Pet Fees</span>
                                    @php
                                        if($travllerInformation->property->pet_fees_unit =='Per Day'):
                                            $petFees = $travllerInformation->property->peet_fee*$total_night;
                                        elseif($travllerInformation->property->pet_fees_unit =='Per Week'):
                                            $oneday = $travllerInformation->property->peet_fee/7;
                                            $petFees = $oneday*$total_night;
                                        else:
                                            $petFees = $travllerInformation->property->peet_fee;
                                        endif;
                                    @endphp
                                    <span class="value">${{$petFees}}</span>
                                </div>
                                @endif
                                @if(($travllerInformation->guest+$travllerInformation->children)>$travllerInformation->property->after_guest) 
                                    @if ($travllerInformation->property->extra_person_fee !=null)
                                    <div>
                                        <span class="label">Extra Person Fees:(After {{$travllerInformation->property->after_guest}} Guests)</span>
                                        @php
                                            $extraGuest = ($travllerInformation->guest+$travllerInformation->children)-$travllerInformation->property->after_guest;
                                        @endphp
                                        <span class="value">${{$travllerInformation->property->extra_person_fee* $extraGuest}}</span>
                                    </div>
                                    @endif
                                @endif
                                @if ($travllerInformation->property->poolheating_fee !=null)
                                <div>
                                    <span class="label">Pool Heating Fees:</span>
                                    @php
                                    if($travllerInformation->property->pool_heating_fees_perday =='Per Day'):
                                        $poolheating = $travllerInformation->property->poolheating_fee*$total_night;
                                    elseif($travllerInformation->property->pool_heating_fees_perday =='Per Week'):
                                        $oneday = $travllerInformation->property->poolheating_fee/7;
                                        $poolheating = $oneday*$total_night;
                                    else:
                                        $poolheating = $travllerInformation->property->poolheating_fee;
                                    endif;
                                @endphp
                                    <span class="value">${{$poolheating}}</span>
                                </div>
                                @endif
                                @if ($travllerInformation->property->tax_rates !=null)
                                <div>
                                    <span class="label">Tax</span>
                                    <span class="value">{{$travllerInformation->property->tax_rates}}%</span>
                                </div>
                                @endif
                            </div>
                        </section>
                        <section class="booking-info-Payble">
                            <span class="label">Total Amount </span>
                            <span class="value">${{number_format($totalAmount,2)}}</span>
                        </section>
                        <section class="booking-info-total">
                            <span class="label">Payble Amount</span>
                            <span class="value">${{number_format($totalAmount,2)}}</span>
                        </section>
                        @php
                            $todays = date('Y-m-d');
                            $today_date =\Carbon\Carbon::parse($todays);
                            $checkInDate =\Carbon\Carbon::parse($travllerInformation->check_in);
                            $diffrence_days =$today_date->diffInDays($checkInDate);
                        @endphp
                        @if ($diffrence_days >='30')
                        <section class="booking-info-total">
                            <span class="label">Partial Amount</span>
                            @php
                                $partialAmount = $totalAmount - ($totalAmount*env('PARTIAL_PAYMENT')/100);
                            @endphp
                            <span class="value">${{number_format($partialAmount,2)}}</span>
                        </section>
                        @endif
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script>
    quoteStore.onsubmit = async (e) => {
        showLoader();
        e.preventDefault();
        const response = await fetch('{{route("frontend.quote.store")}}',{
            method:"POST",
            body:new FormData(quoteStore),
        });
        const result= await response.json(); 
        if(result.status==500){
            hideLoader();
            toastr.error(result.msg);
            return false;
        }
        if(response.status==500) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if(response.status==422){
            hideLoader();
            $("#getQuote").find("span").text('');
            for(let index in result.errors){
                $("."+index).text(result.errors[index]);
            }
        }
        if(response.status ==200){
            hideLoader();
            window.setTimeout(() => {
                window.location.href = result.url; 
            }, 2000);
        }
    }
</script>
    
@endpush