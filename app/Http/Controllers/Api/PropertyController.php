<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\ImportIcal;
use App\Models\SubAminities;
use Illuminate\Http\Request;
use App\Models\PropertyRates;
use App\Models\PropertyBooking;
use App\Models\PropertyGallery;
use App\Models\PropertyListing;
use App\Models\PropertiesAminites;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\RentalRatesRequest;
use App\Http\Requests\Api\Property\RentalPolicies;
use App\Http\Requests\Api\Property\InfromationRequest;
use App\Http\Requests\Api\Property\GalleryImageRequest;
use App\Http\Requests\Api\Property\AdditionalRentalRatesRequest;
use App\Models\PropertyReviewsRating;
use App\Models\WishList;

class PropertyController extends Controller
{
    public function propertyInformation(InfromationRequest $request) {
        if($request->hasfile('property_main_image')):
            $image = $request->file('property_main_image');
            $ext = "webp";
            $convertImage = Image::make($image->getRealPath())->resize(650, 960, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($ext,100);
            $originalImageName = uniqid().'.'.$ext;
            Storage::put('public/upload/property_image/main_image/'.$originalImageName, $convertImage);
        endif;
        $property = PropertyListing::create([
            'user_id' =>auth()->user()->id,
            'property_name' =>$request->input('property_name'),
            'property_main_photos'=>  $originalImageName,
            'square_feet'=>$request->input('square_feet'),
            'property_type_id'=>$request->input('property_type'),
            'bedrooms'=>$request->input('bedrooms'),
            'sleeps'=>$request->input('sleeps'),
            'avg_night_rates'=>$request->input('avg_night'),
            'avg_rate_unit'=>$request->input('avg_night_unit'),
            'baths'=>$request->input('baths'),
            'description'=>$request->input('description'),
            'country_id'=>$request->input('country'),
            'state_id'=>$request->input('state'),
            'region_id'=>$request->input('region'),
            'city_id'=>$request->input('city'),
            'sub_city_id' => $request->input('sub_city') !=null?$request->input('sub_city'):NULL,
            'address' => $request->input('address'),
            'town' => $request->input('town'),
            'zip_code' => $request->input('zipcode'),
            'youtube_video_link'=>$request->input('youtube_video_link')
        ]);
        if($property):
            return response()->json([
                'status'=>true,
                'msg'=>'Property Information Store Successfully',
                'property_id'=>$property->id
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>'Property Information Not Store, Please try again',
            ],200);
        endif;
    }


    public function storeAmenities(Request $request) {
        $properties_aminities = PropertiesAminites::where("property_id",$request->input('property_id'))->get();
        if( $properties_aminities->count() >0):
            $properties_aminities->each->delete();
        endif;
        foreach($request->input('amenities') as $subAminities):
            $mainAminity =SubAminities::where('id',$subAminities)->first();
            $subAminity = PropertiesAminites::create([
                'property_id' => $request->input('property_id'),
                'aminities_id' =>$mainAminity->main_aminities_id,
                'sub_aminities_id'=>$subAminities
            ]);
        endforeach;
        if($subAminity):
            return response()->json([
                'status'=>true,
                'msg'=>"Amenities Store Successfully",
                'property_id' =>$request->input('property_id')
            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Amenities not store, Please try again"
            ]);
        endif;
    }

    public function locationStore(Request $request) {
        $propertyListing = PropertyListing::where('id',$request->input('property_id'))->update([
            'location'=>$request->input("location"),
            'iframe_link_google'=>$request->input("iframe_link_google"),
            'latitude'=>$request->input("latitude"),
            'longitude'=>$request->input("longitude"),
       ]);
       if($propertyListing):
            return response()->json([
                'status'=>true,
                'msg'=>'Location Information store successfully',
                'property_id'=>$request->input('property_id'),

            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Location Information Not store,Please try again"
            ]);
        endif;


    }
    public function rentalRatesStore(RentalRatesRequest $request) {
        // dd($request->all());
        foreach($request->input('rental_rates') as $rentalRates):
            $propertyRates = PropertyRates::create([
                "property_id"=>$request->input('property_id'),
                "session_name"=> $rentalRates['session_name'],
                "from_date"=> $rentalRates['from_date'],
                "to_date"=> $rentalRates['to_date'],
                "nightly_rate"=> $rentalRates['nightly_rate'],
                "weekly_rate"=> $rentalRates['weekly_rate'],
                "weekend_rates"=> $rentalRates['weekend_rate'],
                "monthly_rate"=> $rentalRates['monthly_rates'],
                "minimum_stay"=> $rentalRates['minimum_stay'],
            ]);
        endforeach;
        if($propertyRates):
            return response()->json([
                'status'=>true,
                'msg'=>'Rental Rate store successfully',
                'property_id'=>$request->input('property_id'),
            ]);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>"Rental Rate Not store,Please try again"
            ]);
        endif;
    }

    public function additionalRatesStore(AdditionalRentalRatesRequest $request) {
        foreach($request->input('rental_rates') as $rentalRates):
            $propertyRates = PropertyRates::create([
                "property_id"=>$request->input('property_id'),
                "session_name"=> $rentalRates['session_name'],
                "from_date"=> $rentalRates['from_date'],
                "to_date"=> $rentalRates['to_date'],
                "nightly_rate"=> $rentalRates['nightly_rate'],
                "weekly_rate"=> $rentalRates['weekly_rate'],
                "weekend_rates"=> $rentalRates['weekend_rate'],
                "monthly_rate"=> $rentalRates['monthly_rate'],
                "minimum_stay"=> $rentalRates['minimum_stay'],
            ]);
        endforeach;
        $propertyListing = PropertyListing::where('id',$request->input('property_id'))->update([
            'admin_fees' =>$request->input("admin_fees"),
            'cleaning_fees' =>$request->input("cleaning_fees"),
            'refundable_damage_deposite' =>$request->input("refundable_damage_deposite"),
            'danage_waiver' =>$request->input("danage_waiver"),
            'peet_fee' =>$request->input("peet_fee"),
            'pet_fees_unit' =>$request->input("pet_rate_unit"),
            'extra_person_fee' =>$request->input("extra_person_fee"),
            'after_guest' =>$request->input("after_guest"),
            'poolheating_fee' =>$request->input("poolheating_fee"),
            'pool_heating_fees_perday' =>$request->input("pool_heating_fees_unit"),
            'check_in' =>$request->input("check_in"),
            'check_out' =>$request->input("check_out"),
            'tax_rates' =>$request->input("tax_rates"),
            'change_over' =>$request->input("change_over"),
            'currency_id'=>$request->input("currency"),
            'rates_notes'=>$request->input("rates_notes"),
       ]);
       if($propertyListing):
            return response()->json([
                'status'=>true,
                'msg'=>"Additional Rates Store Successfully",
                'property_id'=>$request->input('property_id')
            ]);
       else:
            return response()->json([
                'status'=>false,
                'msg'=>"Additional Rates not store, Please Try again"
            ]);
       endif;
    }

    public function galleryImages(GalleryImageRequest $request) {
        // dd($request->image);
        if(count($request->image) >0):
            for($x = 0; $x < count($request->image); $x++):
                // if ($request->hasFile($request->image[$x])):
                    $image = $request->image[$x];
                    $ext = "webp";
                    $convertImage = Image::make($image->getRealPath())->resize(1000, 720, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode($ext,100);
                    $originalImageName = uniqid().'.'.$ext;
                    Storage::put('public/upload/property_image/gallery_image/'.$originalImageName, $convertImage);
                    $propertyListing = PropertyGallery::create([
                        "property_id"=>$request->input("property_id"),
                        "image_name"=>$originalImageName
                    ]);
                // endif;
            endfor;
        endif;
        return response()->json([
            'status'=>true,
            'msg'=>"Property Gallery Images store successfully",
            "property_id"=>$request->input("property_id")
        ]);
    }

    public function rentalPolicies(RentalPolicies $request) {
        $propertyListing = PropertyListing::where('id',$request->input('property_id'))->update([
            'rental_policies'=>$request->input("rental_policies"),
            'cancelletion_policies_id'=>$request->input("canelletion_policies")
        ]);
        if($propertyListing):
            return response()->json([
                'status'=>true,
                'msg'=>"Rental Policies Store Successfully",
                'property_id'=>$request->input('property_id')
            ]);
            else:
            return response()->json([
                'status'=>false,
                'msg'=>"Rental Policies not store, Please Try again"
            ]);
        endif;
    }

    public function calenderSynchronization(Request $request) {
        try{
            if(is_null($request->input('import_calender_url')) ){
                return response()->json([
                    'status'=>true
                ],200);
            };
            $ical_response = file_get_contents($request->input('import_calender_url'));
            $icsDates = array ();
            $icsData = explode ( "BEGIN:", $ical_response );
            foreach ( $icsData as $key => $value ) {
                $icsDatesMeta [$key] = explode ( "\n", $value );
            }
            foreach ( $icsDatesMeta as $key => $value ) {
                foreach ( $value as $subKey => $subValue ) {
                    $icsDates = $this->getICSDates ( $key, $subKey, $subValue, $icsDates );
                }
            }
            unset($icsDates[1]);
            $property_booking ="";
            foreach ($icsDates as $key => $icsDate) :
                $dateTimeStamp =  date("Y-m-d h:i:s",strtotime($icsDate['DTSTAMP']));
                $startDate = date("Y-m-d h:i:s",strtotime($icsDate['DTSTART;VALUE=DATE']));
                $endDate = date("Y-m-d h:i:s",strtotime($icsDate['DTEND;VALUE=DATE']));
                $events = $icsDate['SUMMARY'];
                $check_booking_date = PropertyBooking::where(['property_id'=>$request->input('property_id'),'start_date'=>Carbon::parse($startDate),'end_date'=>Carbon::parse($endDate)])->first();
               if(is_null($check_booking_date)):
                $property_booking =  PropertyBooking::create([
                    "property_id" =>$request->input('property_id'),
                    "start_date" =>$startDate,
                    "end_date" =>$endDate,
                    "events" =>$events,
                    "booking_time_stamps" =>$dateTimeStamp
                ]);
               endif;

            endforeach;
            if($property_booking):
                ImportIcal::create([
                    "property_id" =>$request->input('property_id'),
                    'ical_link'=>$request->input('import_calender_url')
                ]);
                return response()->json([
                    'status'=>true,
                    'msg'=>"Calender Synchronized Successfully !",
                    'property_id'=>$request->input('property_id')
                ]);
            else:
                return response()->json([
                    'status'=>false,
                    'msg'=>"Calender Not Synchronized, Please Try Aagin"
                ]);
            endif;
        }catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'msg'=>$e->getMessage()
            ]);
        }
    }

    // Calender Syncroniztion Method Start End

    function getICSDates($key, $subKey, $subValue, $icsDates) {
        if ($key != 0 && $subKey == 0) {
            $icsDates [$key] ["BEGIN"] = $subValue;
        } else {
            $subValueArr = explode ( ":", $subValue, 2 );
            if (isset ( $subValueArr [1] )) {
                $icsDates [$key] [$subValueArr [0]] = $subValueArr [1];
            }
        }
        return $icsDates;
    }

    public function reviews(Request $request) {
        foreach($request->input('reviews') as $key =>$reviews) :
            PropertyReviewsRating::create([
                'property_id'=>$request->input('property_id'),
                'reviews_heading'=>$reviews['reviews_heading'],
                'guest_name'=>$reviews['guest_name'],
                'place'=>$reviews['place'],
                'reviews'=>$reviews['reviews'],
                'rating'=>$reviews['rating'],
            ]);
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Property Created Successfully"
        ]);
    }

    public function addWishList(Request $request) {
        $wishList = WishList::create([
            'user_id'=>auth()->user()->id,
            'property_id'=>$request->input('property_id')
        ]);
        if($wishList):
            return response()->json([
                'status'=>true,
                'msg'=>'Wishlist added successfully'
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>'Wishlist Not added, please try again'
            ],500);
        endif;
    }

    public function removeWishList(Request $request) {
        $removeWishList = WishList::where(['user_id'=>auth()->user()->id,'property_id'=>$request->input('property_id')])->delete();
        if($removeWishList):
            return response()->json([
                'status'=>true,
                'msg'=>'Wishlist removed successfully'
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>'Wishlist Not removed, please try again'
            ],500);
        endif;
    }

    public function wishList() {
        $wishList = WishList::where('user_id',auth()->user()->id)->get();
        $wishlists = [];
        foreach($wishList as $wishL):
            $wishlists[]=[
                'id'=>$wishL->property_id,
                'property_name'=>$wishL->property->property_name,
                'image'=>url('public/storage/upload/property_image/main_image/'.$wishL->property->property_main_photos),
                'avg_night_rates'=>$wishL->property->avg_night_rates,
                'avg_rate_unit'=>$wishL->property->avg_rate_unit,
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Wishlist fetched successfully",
            'data'=>$wishlists
        ]);
    }

    public function getPropertyInformation($id) {
        $keysArray =[
            'id',
            'property_name',
            'property_main_photos',
            'square_feet',
            'property_type_id',
            'bedrooms',
            'sleeps',
            'avg_night_rates',
            'avg_rate_unit',
            'baths',
            'description',
            'country_id',
            'state_id',
            'region_id',
            'city_id',
            'sub_city_id',
            'address',
            'town',
            'zip_code',
            'youtube_video_link',
        ];
        $propertyInformation = PropertyListing::where(['id'=>$id,'user_id'=>auth()->user()->id])->first($keysArray)?->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>"Property information fetched successfully",
            'data'=>$propertyInformation
        ]);
    }

    public function updatePropertyInformation(InfromationRequest $request) {
        $originalImageName = $request->input('old_image');
        if($request->hasfile('property_main_image')):
            $path = storage_path('public/upload/property_image/main_image/');
            if(file_exists($path.$request->input('old_image'))):
                unlink($path.$request->input('old_image'));
            endif;
            $image = $request->file('property_main_image');
            $ext = "webp";
            $convertImage = Image::make($image->getRealPath())->resize(650, 960, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode($ext,100);
            $originalImageName = uniqid().'.'.$ext;
            Storage::put('public/upload/property_image/main_image/'.$originalImageName, $convertImage);
        endif;
        $property = PropertyListing::where('id',$request->input('id'))->update([
            'user_id' =>auth()->user()->id,
            'property_name' =>$request->input('property_name'),
            'property_main_photos'=>  $originalImageName,
            'square_feet'=>$request->input('square_feet'),
            'property_type_id'=>$request->input('property_type'),
            'bedrooms'=>$request->input('bedrooms'),
            'sleeps'=>$request->input('sleeps'),
            'avg_night_rates'=>$request->input('avg_night'),
            'avg_rate_unit'=>$request->input('avg_night_unit'),
            'baths'=>$request->input('baths'),
            'description'=>$request->input('description'),
            'country_id'=>$request->input('country'),
            'state_id'=>$request->input('state'),
            'region_id'=>$request->input('region'),
            'city_id'=>$request->input('city'),
            'sub_city_id' => $request->input('sub_city') !=null?$request->input('sub_city'):NULL,
            'address' => $request->input('address'),
            'town' => $request->input('town'),
            'zip_code' => $request->input('zipcode'),
            'youtube_video_link'=>$request->input('youtube_video_link')
        ]);
        if($property):
            return response()->json([
                'status'=>true,
                'msg'=>'Property Information Update Successfully',
                'property_id'=>$request->input('id')
            ],200);
        else:
            return response()->json([
                'status'=>false,
                'msg'=>'Property Information Not Store, Please try again',
            ],200);
        endif;
    }
}
