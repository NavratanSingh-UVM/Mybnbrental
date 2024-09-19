<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Cities;
use App\Models\Region;
use App\Models\Country;
use App\Models\PropertyType;
use App\Models\SubAminities;
use Illuminate\Http\Request;
use App\Models\PartnerListing;
use App\Models\PropertyBooking;
use App\Models\PropertyListing;
use App\Models\BusinessCategory;
use App\Models\PropertyExportIcal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function index() {
        $featuredProperties = PropertyListing::where(['feature'=>'1','approval'=>'1'])->get();
        return view('frontend.index',compact('featuredProperties'));
    }

    public function aboutUs() {
        return view('frontend.pages.about-us');
    }

    public function propertyListing (Request $request) {
        $cities = "";
        $amenities = SubAminities::orderBy('name','asc')->groupBy('name')->get();
        $propertyTypes = PropertyType::get();
        $state_name = State::where('id',$request->input('state_id'))->first(['id','name']);
        $propertiesTypes = PropertyType::get();
        $regions = Region::where('state_id',$request->input('state_id'))->get();
        $properties = PropertyListing::where('approval','1');
        if($request->input('state_id') !='' && $request->input('destination_or_listing_id') ==  null):
            $properties = $properties->where('state_id',$request->input('state_id'));
        endif;

        if($request->input('region') !=''):
            $properties = $properties->where('region_id',$request->input('region'));
            $cities = City::where('region_id',$request->input('region'))->get();
        endif;
        if($request->input('city') !=''):
            $properties = $properties->where('state_id',$request->input('city'));
        endif;
        if($request->input('property_types') !=''):
            $properties = $properties->where('property_type_id',$request->input('property_types'));
        endif;
        if($request->input('property_sort_by') =='bedsDesc'):
            $properties = $properties->orderBy("bedrooms","DESC");
        endif;
        if($request->input('property_sort_by') =='bedsAsc'):
            $properties = $properties->orderBy("bedrooms","ASC");
        endif;
        if($request->input('property_sort_by') =='priceAsc'):
            $properties = $properties->orderBy("avg_night_rates","ASC");
        endif;
        if($request->input('property_sort_by') =='priceDesc'):
            $properties = $properties->orderBy("avg_night_rates","DESC");
        endif;
        if($request->input('bedroom') !=''):
            $properties = $properties->where('bedrooms','<=', $request->input('bedroom')."_bedrooms");
        endif;
        if($request->input('sleeps') !=''):
            $properties = $properties->where('sleeps','<=', $request->input('sleeps'));
        endif;
        if ($request->input('amenities') != null) :
            $properties = $properties->whereHas('property_amenites' ,function($q) use ($request){
                $q->whereIn('sub_aminities_id',$request->input('amenities'));
            });
        endif;
        if ($request->input('destination_or_listing_id') != null && gettype($request->input('destination_or_listing_id')) == "string" && is_numeric($request->destination_or_listing_id) ==false) :
            $destination = explode(',', $request->input('destination_or_listing_id'));
            if (count($destination) == 5) :
                $state = State::where('name',$destination['3'])->first()->id;
                $regions = Region::where('state_id',$state)->get();
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
                if ($region_name != null) :
                    $country_name = Country::where('id', $region_name->country_id)->first();
                    $state_name = State::where('id', $region_name->state_id)->first();
                    $cites = City::where('region_id', $region_name->id)->orderBy('name',"ASC")->get();
                    $type = "city";
                    $types = 'Region';
                    $properties = $properties->where('region_id', $region_name->id);
                endif;
            elseif (count($destination) == 2) :
                $state_name = State::where('name', $destination['0'])->first();
                if ($state_name != null) :
                    $country_name = Country::where('id', $state_name->country_id)->first();
                    $regions = Region::where('state_id', $state_name->id)->orderBy('name','ASC')->get();
                    $type = "region";
                    $types = 'State';
                    $properties = $properties->where('state_id', $state_name->id);
                endif;
            elseif (count($destination) == 1) :
                $country = Country::where('name', $destination['0'])->first();
                if ($country != null) :
                    $country_name = Country::where('id', $country->id)->first();
                    $types = "country";
                    $type = 'State';
                    $state = State::where('country_id', $country->id)->orderBy('name','ASC')->get();
                    $properties = $properties->where('country_id', $country->id);
                else :
                    $state_name = State::where('name', $destination['0'])->first();
                    if ($state_name != null) :
                        $country_name = Country::where('id', $state_name->country_id)->first();
                        $regions = Region::where('state_id', $state_name->id)->orderBy('name','ASC')->get();
                        $type = "Region";
                        $types = 'State';
                        $properties = $properties->where('state_id', $state_name->id);
                    else :
                        $region = Region::where('name', $destination['0'])->first();
                        if ($region != null) :
                            $country_name = Country::where('id', $region->country_id)->first();
                            $regions =City::where('region_id', $region->id)->orderBy('name','ASC')->get();
                            $type = "City";
                            $types = 'Regin';
                            $properties = $properties->where('region_id', $region->id);
                        else:
                            $city_name = City::where('name', $destination['0'])->first();
                            // dd($city_name);
                            if ($city_name != null) :
                                $country_name = Country::where('id', $city_name->country_id)->first();
                                $subCities = Cities::where('city_id', $city_name->id)->orderBy('name','ASC') ->get();
                                $state_name = State::where('id', $city_name->state_id)->first();
                                $type = "Subcity";
                                $types = 'City';
                                $properties = $properties->where('city_id', $city_name->id);
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        elseif(is_numeric($request->destination_or_listing_id)):
            return to_route('property.listing.details',encrypt($request->input('destination_or_listing_id')));
        endif;
        if($request->input('check_in') !=null && $request->input('check_out') !=null):
            $propertiesId = PropertyBooking::whereDate('start_date','>=',Carbon::parse($request->input('check_in'))->format('Y-m-d'))->whereDate('end_date','<=',Carbon::parse($request->input('check_out'))->format('Y-m-d'))->get('property_id');
            $propertiesIds = array_map(fn($properties) => $properties->property_id,iterator_to_array($propertiesId));
            $properties = $properties->whereNotIn('id',$propertiesIds);
        endif;
        $properties = $properties->paginate(15);
        // dd($properties);
        return view('frontend.property-listing',compact('propertiesTypes','properties','regions','amenities','propertyTypes','cities'));
    }

    public function contactUs () {
        return view('frontend.pages.contact-us');
    }

    public function listOurProperty() {
       
        return view("frontend.list-our-property");
    }

    public function destintaionSuggestion(Request $request)
    {
        $wordSuggestion = [];
        $countries =Country::where('name', 'LIKE', strtolower($request->input('value')) . '%')->distinct()->get();
        $states =State::where('name', 'LIKE', strtolower($request->input('value')) . '%')->distinct()->get();
        $regions =Region::where('name', 'LIKE', strtolower($request->input('value')) . '%')->distinct() ->get();
        $cities =City::where('name', 'LIKE', strtolower($request->input('value')) . '%')->distinct()->get();
        $subCities = Cities::where('name', 'LIKE', strtolower($request->input('value')) . '%')->distinct()->get();
        if($countries->count() >0):
            foreach($countries as $country):
                $wordSuggestion []= strlen($country?->name)<=3?strtoupper($country?->name):ucfirst($country?->name);
            endforeach;
        endif;
        if($states->count() >0):
            foreach($states as $state):
                $country = strlen($state->country->name) <=3?strtoupper($state->country->name):ucfirst($state->country->name);
                $wordSuggestion []= ucfirst($state->name).','.$country;
            endforeach;
        endif;
        if($regions->count() >0):
            foreach($regions as $region):
                $country = strlen($region->country->name) <=3?strtoupper($region->country->name):ucfirst($region->country->name);
                $state = ucfirst($region->state->name);
                $wordSuggestion []= ucfirst($region->name).','.$state.','.$country;
            endforeach;
        endif;
        if($cities->count() >0):
            foreach($cities as $city):
                $country = strlen($city->country->name) <=3?strtoupper($city->country->name):ucfirst($city->country->name);
                $state = ucfirst($city->state->name);
                $region = ucfirst($city->region->name);
                $wordSuggestion []= ucfirst($city->name).','.$region.','.$state.','.$country;
            endforeach;
        endif;
        if($subCities->count()>0):
            foreach($subCities as $subCity):
                $country = strlen($subCity->country->name) <=3?strtoupper($subCity->country->name):ucfirst($subCity->country->name);
                $state = ucfirst($subCity->state->name);
                $region = ucfirst($subCity->region->name);
                $city= ucfirst($subCity->city->name);
                $wordSuggestion []= ucfirst($subCity->name).','.$city.','.$region.','.$state.','.$country;
            endforeach;
        endif;
        return response()->json([
            'data' => $wordSuggestion
        ]);
    }


    public function partnerListing(Request $request) {
        $states = State::orderBy('name','ASC')->get();
        $businessCategories = BusinessCategory::get();
        $partnerListings = New PartnerListing();
        /* if($request->input('state')):
            $partnerListings = $partnerListings->where('')
        endif; */
        $partnerListings = $partnerListings->paginate(10);
        return view('frontend.pages.partner-listing',compact('partnerListings','states','businessCategories'));
    }

    public function calender(Request $request) {
     
        $propertyDetail = PropertyListing::where('id',$request->input('property_id'))->first();
        $data = ['cdate'=>$request->input('date'),'propertyDetail'=>$propertyDetail];
        $view =view('frontend.calender',$data)->render();
          
        return response()->json([
            'data'=>$view
        ]);
    }

    public function genratePropertIcalLink($property_id){
        $propertyBookings = PropertyBooking::where(['property_id' => $property_id, "type" => "1"])->get();
        define('ICAL_FORMAT', 'Ymd\THis\Z');
        $icalObject = "BEGIN:VCALENDAR".PHP_EOL."VERSION:2.0".PHP_EOL."CALSCALE:GREGORIAN".PHP_EOL."PRODID:-//HomeAway.com, Inc.//EN".PHP_EOL;
        foreach ($propertyBookings as $event) {
            $icalObject .=
            "BEGIN:VEVENT".PHP_EOL."DTSTART:".date(ICAL_FORMAT, strtotime($event->start_date)) .PHP_EOL."DTEND:".date(ICAL_FORMAT, strtotime($event->end_date)).PHP_EOL."DTSTAMP:".date(ICAL_FORMAT, strtotime($event->created_at)).PHP_EOL."SUMMARY:".$event->events.PHP_EOL."UID:".uniqid().PHP_EOL ."LAST-MODIFIED:".PHP_EOL .date(ICAL_FORMAT, strtotime($event->updated_at)).PHP_EOL."END:VEVENT\n";
        }
        // close calendar
        $icalObject .= "END:VCALENDAR";
        $filename = $property_id . time() . '.ics';
        Storage::put('public/ical_link/' . $filename, $icalObject);
        PropertyExportIcal::create([
            'property_id' => $property_id,
            'ical_file_name' => $filename
        ]);
        return response()->json([
            'status' => 200,
            'msg' => "Ical Genrate Successfully",
            'url' => url('public/storage/ical_link/' . $filename)
        ], 200);
    }
}
