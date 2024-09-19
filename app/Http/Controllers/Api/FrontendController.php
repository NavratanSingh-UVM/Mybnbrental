<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Cities;
use App\Models\Region;
use App\Models\Country;
use App\Models\WishList;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\PropertyRates;
use App\Models\PartnerListing;
use App\Models\PropertyBooking;
use App\Models\PropertyGallery;
use App\Models\PropertyListing;
use App\Models\PropertiesAminites;
use App\Http\Controllers\Controller;
use App\Models\PropertyReviewsRating;
use App\Models\PartnerListingGalleryImage;

class FrontendController extends Controller
{
    //

    public function propertyListing(Request $request) {
        $propertyArr = [];
        // dd($request->all());
        $pageNo = (!empty($request->input('page_no'))) ? $request->input('page_no') : 1;
        $perPage = (!empty($request->input('per_page'))) ? $request->input('per_page') : 10;
        $properties = PropertyListing::where('approval','1');
        if($request->input('property_types') !=null):
            $properties = $properties->where('property_type_id',$request->input('property_types'));
        endif;
        if($request->input('destination_or_listing_id') !=null):
            $destination = explode(',', $request->input('destination_or_listing_id'));
            if (count($destination) == 5) :
                $state = State::where('name',$destination['3'])->first()->id;
                $subCity = Cities::where('name',$destination['0'])->first()->id;
                $properties = $properties->where('sub_city_id','=', $subCity);
            elseif (count($destination) == 4) :
                $state = State::where('name',$destination['2'])->first()->id;
                $regions = Region::where('state_id',$state)->get();
                $city = city::where('name',$destination['0'])->first()->id;
                $properties = $properties->where('city_id','=', $city);
            elseif (count($destination) == 3) :
                $state = State::where('name', $destination['1'])->first()->id;
                $region_name = Region::where(['name'=> $destination['0'],'state_id'=>$state])->first();
                $properties = $properties->where('region_id', $region_name->id);
            elseif (count($destination) == 2) :
                $state_name = State::where('name', $destination['0'])->first();
                $properties = $properties->where('state_id', $state_name->id);
            elseif (count($destination) == 1) :
                $country = Country::where('name', $destination['0'])->first();
                $properties = $properties->where('country_id', $country->id);
            endif;
        endif;
        if($request->input('feature_listing') =='yes'):
            $properties = $properties->where('feature','1');
        endif;
        $properties = $properties->paginate($perPage, ['*'], 'page', $pageNo);
        // dd($properties);
        $paginationMeta = [
            'total' => $properties->total(),
            'lastPage' => $properties->lastPage(),
            'perPage' => $properties->perPage(),
            'currentPage' => $properties->currentPage()
        ];
        foreach($properties as $property):
            $propertyArr [] = [
                'id'=>$property->id,
                'name'=>$property->property_name,
                'image'=>url('public/storage/upload/property_image/main_image/'.$property->property_main_photos),
                'state'=>$property->state->name,
                'city'=>$property?->city?->name,
                'nightly_rate'=>$property->avg_night_rates
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>'Property Listing Fetched Successfully',
            'data'=>[
                'property'=>$propertyArr,
                'pagination'=>$paginationMeta
            ],
        ]);
    }


    public function propertyDetails(Request $request,$id) {
        $propertiesDetail = [];
        $propertyDeatails = PropertyListing::where('id',$id)->first();
        // dd($propertyDeatails);
        $propertiesDetail = [
            'id'=>$propertyDeatails->id,
            'name'=>$propertyDeatails->property_name,
            'image'=>url('public/storage/upload/property_image/main_image/'.$propertyDeatails->property_main_photos),
            'country'=>$propertyDeatails?->country?->name,
            'state'=>$propertyDeatails?->state?->name,
            'region'=>$propertyDeatails?->region?->name,
            'city'=>$propertyDeatails?->city?->name,
            'sub_city'=>$propertyDeatails?->sub_city?->name,
            'description'=>$propertyDeatails->description,
            'square_feet'=>$propertyDeatails->square_feet,
            'property_type_name'=>$propertyDeatails->property_types->property_type_name,
            'bedrooms'=>str_replace('_',' ',$propertyDeatails->bedrooms),
            'sleeps'=>$propertyDeatails->sleeps,
            'avg_night_rates'=>$propertyDeatails->avg_night_rates,
            'avg_rate_unit'=>$propertyDeatails->avg_rate_unit,
            'baths'=>$propertyDeatails->baths,
            'address'=>$propertyDeatails->address,
            'youtube_video_link'=>$propertyDeatails->youtube_video_link,
            'currency'=>$propertyDeatails->currency->currency_name,
            'house_note'=>$propertyDeatails->rates_notes,
            'admin_fees'=>$propertyDeatails->admin_fees,
            'cleaning_fees'=>$propertyDeatails->cleaning_fees,
            'refundable_damage_deposite'=>$propertyDeatails->refundable_damage_deposite,
            'danage_waiver'=>$propertyDeatails->danage_waiver,
            'peet_fee'=>$propertyDeatails->peet_fee,
            'pet_fees_unit'=>$propertyDeatails->pet_fees_unit,
            'extra_person_fee'=>$propertyDeatails->extra_person_fee,
            'after_guest'=>$propertyDeatails->after_guest,
            'poolheating_fee'=>$propertyDeatails->poolheating_fee,
            'check_in'=>$propertyDeatails->check_in,
            'check_out'=>$propertyDeatails->check_out,
            'tax_rates'=>$propertyDeatails->tax_rates,
            'change_over'=>$propertyDeatails->change_over,
            'rental_policies'=>$propertyDeatails->rental_policies,
            'cancelletion_policies'=>[
                'name'=>$propertyDeatails->cancelletionPolicies->name,
                'description'=>$propertyDeatails->cancelletionPolicies->description,
                'note'=>$propertyDeatails->cancelletionPolicies->note
            ],
            'location'=>$propertyDeatails->location,
            'iframe_link_google'=>$propertyDeatails->iframe_link_google,
            'latitude'=>$propertyDeatails->latitude,
            'longitude'=>$propertyDeatails->longitude,
        ];  
        return response()->json([
            'status'=>true,
            'msg'=>"Property Details Fetched Successfully",
            'data'=>[
                'property-details'=>$propertiesDetail,
                'gallery_images'=>$this->galleryImage($id),
                'rental_rates'=>$this->rentalRates($id),
                'amenities'=>$this->amenities($id),
                'reviews'=>$this->reviews($id),
                'booking'=>$this->calenderAvailiblity($id),
                'ownerDetails' =>$this->getOwnerDetails($id),
                'wishList'=>$this->checkWishList($request->input('user_id'),$id)
            ],
        ]);
       
    }

    public function galleryImage($id) {
        $galleryImages = [];
        $propertyGalleries = PropertyGallery::where('property_id',$id)->get();
        foreach($propertyGalleries as $images):
            $galleryImages [] = [
                'image'=>url('public/storage/upload/property_image/gallery_image/'.$images->image_name)
            ];
        endforeach;
        return $galleryImages;
    }

    public function rentalRates($id) {
        return PropertyRates::where('property_id',$id)->get()->toArray();
    } 
    
    public function amenities($id) {
        $amenityArr = [];
        $amenities = PropertiesAminites::where('property_id',$id)->groupBy('aminities_id')->get();
        foreach($amenities as $amenity):
            $amenityArr[$amenity->mainAmenities->aminity_name] =$this->sub_amenities($amenity->mainAmenities->id);
        endforeach;
        return $amenityArr;
    }

    public function sub_amenities($id) {
        $subaminiteArr = [];
        $subAmenities = PropertiesAminites::where('aminities_id',$id)->get();
        foreach($subAmenities as $subAmenity):
           $subaminiteArr[]=$subAmenity->subAminites->name;
        endforeach;
        return $subaminiteArr;
    }

    public function reviews($id) {
        $reviewsArr = [];
        $reviews = PropertyReviewsRating::where('property_id',$id)->get();
        foreach($reviews as $review):
            $reviewsArr [] = [
                'guest_name'=>$review->guest_name,
                'reviews'=>$review->reviews,
                'rating'=>$review->rating,
            ];
        endforeach;
        return $reviewsArr;
    }

    public function calenderAvailiblity($id){
        $bookingDatesArr = [];
        $bookings = PropertyBooking::where('property_id',$id)->get();
       foreach($bookings as $booking):
            $bookingDatesArr []  =[
                'start_date'=>$booking->start_date,
                'end_date'=>$booking->end_date,
                'events'=>$booking->events,
            ];
       endforeach;
       return $bookingDatesArr;
    }

    public function getOwnerDetails($id){
        $properties = PropertyListing::where('id',$id)->first();
        return  [
            'name'=>$properties->user->name,
            'image'=>$properties->user->image !=null?url('public/storage/profile_image/'.$properties->user->image):NULL,
        ];
        // dd($properties->user->name);
    }


    public function bookingGetQoute(Request $request) {
        $checkInDate = Carbon::parse($request->input('check_in'));
        $checkOutDate = Carbon::parse($request->input('check_out'));
        $totalNight = $checkOutDate->diffInDays($checkInDate);
        $checkAvailablity = PropertyBooking::where('property_id',$request->input('property_id'))->where('end_date','<=',$checkOutDate->format('Y-m-d'))->where('start_date','>=',$checkInDate->format('Y-m-d'))->get();
        if($checkAvailablity->count() > 0):
            return response()->json([
                'status'=>false,
                'msg'=>'Some dates are already booked,Choose available dates only.'
            ],500);
        endif;
        $minmumStay =PropertyRates::where(['property_id'=>$request->input('property_id')])->where('from_date', '<=',$checkInDate->format('Y-m-d'))->first();
        $minmumStayNight = $minmumStay !=null?$minmumStay->minimum_stay:1;
        if($minmumStayNight >$totalNight):
            return response()->json([
                'status'=>500,
                'msg'=>'Please select minimum '.$minmumStayNight.' nights for booking.'
            ],500);
        endif;
        $dateRange = CarbonPeriod::create($checkInDate,$checkOutDate->subDays(1) );
        $grossAmount = 0;
        $dates = array_map(fn($date)=>$date->format('Y-m-d'),iterator_to_array($dateRange));
        for($i =0 ;$i<count($dates);$i++):
            $property_rates = PropertyRates::where(['property_id'=>$request->input('property_id')])->where('from_date', '<=',$dates[$i])->where('to_date','>=',$dates[$i])->first();
           if($property_rates !=null):
                if($property_rates->nightly_rate !=null):
                    $grossAmount +=$property_rates->nightly_rate;
                elseif($property_rates->weekly_rate !=null && $property_rates->nightly_rate ==null):
                    $oneNight = $property_rates->weekly_rate/7;
                    $grossAmount +=$oneNight;
                elseif($property_rates->monthly_rate !=null && $property_rates->weekly_rate ==null && $property_rates->nightly_rate ==null):
                    $oneNight = $property_rates->monthly_rate/30;
                    $grossAmount +=$oneNight;
                endif;
            else:
                $property = PropertyListing::where('id',$request->input('property_id'))->first()->avg_night_rates;
                $grossAmount +=$property;
           endif;
        endfor;
        $details = [];
        $details['total_night']= $totalNight;
        $details['amount']=$grossAmount;
        $details['check_in']=$request->input('check_in');
        $details['check_out']=$request->input('check_out');
        $property = PropertyListing::where('id',$request->input('property_id'))->first();
        $tatalAmount = ($grossAmount);
        if($property->admin_fees !=null):
            $tatalAmount +=$property->admin_fees;
            $details['admin_fees']=$property->admin_fees;
        endif;
        if($property->cleaning_fees !=null):
            $tatalAmount  +=$property->cleaning_fees;
            $details['cleaning_fees']=$property->cleaning_fees;
        endif;
        if($property->refundable_damage_deposite !=null):
            $tatalAmount  +=$property->refundable_damage_deposite;
            $details['refundable_damage_deposite']=$property->refundable_damage_deposite;
        endif;
        if($property->danage_waiver !=null):
            $tatalAmount  +=$property->danage_waiver;
            $details['damage_waiver']=$property->danage_waiver;
        endif;
        if($property->peet_fee !=null && $request->input('pets') =='1'):
            if($property->pet_fees_unit =='Per Day'):
                $petFees = $property->peet_fee;
                $tatalAmount = ($tatalAmount+($petFees*$totalNight));
                $totalPetFees = $petFees*$totalNight;
            elseif($property->pet_fees_unit =='Per Week'):
                $oneday = $property->peet_fee/7;
                $tatalAmount = ($tatalAmount+($oneday*$totalNight));
                $totalPetFees = $oneday*$totalNight;
            else:
                $petFees = $property->peet_fee;
                $tatalAmount = ($tatalAmount+$petFees);
                $totalPetFees = $petFees;
            endif;
            $details['pet_fees']=$totalPetFees;
        endif;
        if($property->extra_person_fee !=null && $property->after_guest < ($request->input('no_of_guest')+$request->input('no_children'))):
            $extraPerson = ((float)$request->input('no_of_guest') + $request->input('no_children')) - $property->after_guest;
            $tatalAmount  +=$property->extra_person_fee*$extraPerson*$totalNight;
            $details['extra_person_fees'] = $property->extra_person_fee*$extraPerson*$totalNight;
        endif;
        if($property->poolheating_fee !=null && $request->input('pool_heating_fees') =='1'):
            if($property->pool_heating_fees_perday =='Per Day'):
                $poolHeatingFees = $property->poolheating_fee;
                $tatalAmount = ($tatalAmount+($poolHeatingFees*$totalNight));
                $totalPetFees = $poolHeatingFees*$totalNight;
            elseif($property->pool_heating_fees_perday =='Per Week'):
                $oneday = $property->poolheating_fee/7;
                $tatalAmount = ($tatalAmount+($oneday*$totalNight));
                $totalPetFees = $oneday*$totalNight;
            else:
                $poolHeatingFees = $property->poolheating_fee;
                $tatalAmount = ($tatalAmount+$poolHeatingFees);
                $totalPetFees = $poolHeatingFees;
            endif;
            $details['pool_heating_fees']=$poolHeatingFees;
        endif;
        if($property->tax_rates !=null):
            if($property->refundable_damage_deposite !=null):
                $taxableAmount = $tatalAmount - $property->refundable_damage_deposite;
            endif;
            $tatalAmount += number_format($taxableAmount*$property->tax_rates/100,2);
            $details['tax']=number_format($taxableAmount*$property->tax_rates/100,2);
        endif;
        $details['total_amount']=number_format($tatalAmount,2);
        return response()->json([
            'status'=>true,
            'data'=>$details,
        ],200);
    }


    private function checkWishList($userId,$propertyId){
        $wishLists = WishList::where(['user_id'=>$userId,'property_id'=>$propertyId])->first();
        if($wishLists !=null):
            return true;
        else:
            return false;
        endif;
    }

    public function partnerListing() {
        $partnerListings = PartnerListing::get();
        $partnerList = [];
        foreach($partnerListings as $partnerListing):
            $partnerList[]=[
                'id'=>$partnerListing->id,
                'title'=>$partnerListing->title,
                'address'=>$partnerListing->address,
                'description'=>$partnerListing->description,
                'email'=>$partnerListing->email,
                'phone_no'=>$partnerListing->phone,
                'images' =>$this->getPartnerListingImage($partnerListing->id)

            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Partner listing fetched successfully",
            'data'=>$partnerList,
        ]);
    }

    private function getPartnerListingImage($partnerListingId) {
        $partnerListingImage = PartnerListingGalleryImage::where('partner_listing_id',$partnerListingId)->get();
        $images = [];
        foreach($partnerListingImage as $partnerImage):
            $images[]= [
                'image'=>url("public/storage/upload/partner_listing/gallery_image/".$partnerImage->image)
            ];      
        endforeach;
        return $images;

    }
}
