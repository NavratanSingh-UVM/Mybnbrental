<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\State;
use App\Models\Cities;
use App\Models\Region;
use App\Models\Country;
use App\Models\MainAminity;
use App\Models\PropertyType;
use App\Models\SubAminities;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\CancellentionPolicy;
use App\Models\Currency;

class CommonController extends Controller
{
    public function getRole() {
        $roles = Role::whereNot('id','1')->get(['id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>"Role Fetched Successfully",
            'data'=>$roles
        ],200);
    }

    public function propertyTypes () {
        $propertyType= [];
        $propertyTypes = PropertyType::get(['id','property_type_name','images']);
        foreach($propertyTypes as $propertytype):
            $propertyType [] = [
                'id'=>$propertytype->id,
                'property_type_name'=>$propertytype->property_type_name,
                'image'=>$propertytype->images !=null?asset('android/icon-images/'.$propertytype->images):""
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Property types fetch successfully",
            'data'=>$propertyType
        ],200);
    }

    public function country () {
        $countries = Country::orderBy('name','ASC')->get(['id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>'Country Fetched Successfully',
            'data'=>$countries
        ]);
    }

    public function state(Request $request) {
        $states = State::where('country_id',$request->input('country_id'))->orderBy('name','ASC')->get(['id','country_id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>'State Fetched Successfully',
            'data'=>$states
        ]);
    }

    public function region(Request $request) {
        $regions = Region::where('state_id',$request->input('state_id'))->orderBy('name','ASC')->get(['id','country_id','state_id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>'Region Fetched Successfully',
            'data'=>$regions
        ]);
    }

    public function city(Request $request) {
        $cities = City::where('region_id',$request->input('region_id'))->orderBy('name','ASC')->get(['id','country_id','state_id','region_id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>'City Fetched Successfully',
            'data'=>$cities
        ]);
    }

    public function subCity(Request $request) {
        $subCity = Cities::where('city_id',$request->input('city_id'))->orderBy('name','ASC')->get(['id','country_id','state_id','region_id','city_id','name'])->toArray();
        return response()->json([
            'status'=>true,
            'msg'=>'Sub City Fetched Successfully',
            'data'=>$subCity
        ]);
    }

    public function dashboardPropertyTypes() {
        $propertyType= [];
        $propertyTypes = PropertyType::whereIn('id',['1','2','3','4','6','15'])->get(['id','property_type_name','images']);
        foreach($propertyTypes as $propertytype):
            $propertyType [] = [
                'id'=>$propertytype->id,
                'property_type_name'=>$propertytype->property_type_name,
                'image'=>$propertytype->images !=null?asset('android/icon-images/'.$propertytype->images):""
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Dashboard Property types fetch successfully",
            'data'=>$propertyType
        ],200);
    }

    public function amenities() {
        $amenity = [];
        $amenities = MainAminity::get(['id','aminity_name']);
        foreach($amenities as $amy):
            $amenity[] =[
                'id'=>$amy->id,
                'aminity_name'=>$amy->aminity_name,
                'child_amenities'=>$this->childAmenities($amy->id)
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Amenites Fetch Successfully",
            'data'=>$amenity
        ],200);

    }

    public function childAmenities($amenitiesId) {
        return  SubAminities::where('main_aminities_id',$amenitiesId)->get(['id','name'])->toArray();
    }

    public function currency() {
        $currencies = Currency::get(['id','currency_name'])->toArray();
        return response()->json([
            'status'=>true,
            "msg"=>"Currency Fetch successfully",
            'data'=>$currencies
        ]);
    }

    public function cancellentionPolicies() {
        $policies = [];
        $cancelletionPolicies = CancellentionPolicy::get(['id','name','description','note']);
        foreach($cancelletionPolicies as $policy):
            $policies[] = [
                'id'=>$policy->id,
                'name'=>$policy->description,
                'description'=>$policy->note
            ];
        endforeach;
        return response()->json([
            'status'=>true,
            'msg'=>"Cancellention Policy fetch successfully",
            'data'=>$policies,
            'note'=>$cancelletionPolicies[0]->note
        ]);

    }

    public function destinationList(Request $request) {
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


}
