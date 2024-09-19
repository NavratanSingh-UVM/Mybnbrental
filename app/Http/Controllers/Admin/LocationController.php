<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Models\Country;
use App\Models\State;
use App\Models\Region;
use App\Http\Requests\Region\RegionRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use  App\Http\Requests\City\CityCreateRequest;
use  App\Http\Requests\City\CityUpadteRequest;
use  App\Http\Requests\Cities\CitiesRequestCreate;
use  App\Http\Requests\Cities\CitiesUpdateRequest;
use App\Models\City;
use App\Models\Cities;


class LocationController extends Controller
{
    /* 
    Country Manage Method Start
    */
    public function country(Request $request) {
        if($request->ajax()):
            $country = Country::latest();
            return Datatables::of($country)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.location.country.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="countryDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
       return view('admin.location.country.index');
    }
    /* 
    Country Manage Method End
    */

    /* 
    Country Create Method Start
    */
    public function countryCreate() {
        return view('admin.location.country.create');
    }
    /* 
    Country Create Method End
    */

    /* 
    Country Store Method Start
    */
    public function countryStore(Request $request) {
        $rule = [
            'name'=>'required|unique:countries'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $country = Country::create([
                'name'=>$request->input('name')
            ]);
            if($country):
                return to_route('admin.location.country')->with('success','Country Created Successfully !');
            else:
                return redirect()->back()->with('error','Country Not created successfully');
            endif;
        endif;
    }
    /* 
    Country Store Method End
    */

    /* 
    Country Edit Method Start
    */
    public function countryEdit ($id) {
        $country = Country::findOrFail(decrypt($id));
        return view('admin.location.country.edit',compact('country'));

    }
    /* 
    Country Edit Method End
    */
    /* 
        Country Update method Start
    */
    public function countryUpdate(Request $request) {
        $rule = [
            'name'=>'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $country = Country::where('id',decrypt($request->input('id')))->update([
                'name'=>$request->input('name')
            ]);
            if($country):
                return to_route('admin.location.country')->with('success','Country Update Successfully !');
            else:
                return redirect()->back()->with('error','Country Not Update successfully');
            endif;
        endif;
    }
    /* 
        Country Update method End
    */

    public function countryDelete(Request $request) {
        $country = Country::findOrFail($request->input('id'))->delete();
        if($country):
            return response()->json([
                'status'=>'1',
                'msg'=>"Country Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=>"Country Not Delete !"
            ]);
        endif;
    }
    /* 
        Manage state method start 
    */
    public function state(Request $request) {
        if($request->ajax()):
            $state = State::with('country')->latest();
            return Datatables::of($state)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.location.state.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="stateDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
        return view ('admin.location.state.index');
    }
    /* 
        Manage state method end
    */
    /* 
        Create state method Start
    */
    public function stateCreate() {
        $countries = Country::get();
        return view ('admin.location.state.create',compact('countries'));
    }
    /* 
        Create state method end
    */

    /* 
        Store state method start
    */
    public function stateStore(Request $request) {
        $rule = [
            'country_name'=>'required',
            'name' => 'required|unique:states'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $state = State::create([
                'country_id' =>$request->input('country_name'),
                'name'=>$request->input('name')
            ]);
            if($state):
                return to_route('admin.location.state')->with('success','State Created Successfully !');
            else:
                return redirect()->back()->with('error','State Not created successfully');
            endif;
        endif;
    }
    /* 
        Store state method end
    */
    /* 
        Edit state method Start
    */
    public function stateEdit($id) {
        $countries = Country::get();
        $state = State::findOrFail(decrypt($id));

        return view ('admin.location.state.edit',compact('countries','state'));
    }
    /* 
        Update state method Start
    */
    public function stateUpdate(Request $request) {
        $rule = [
            'country_name'=>'required',
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $state = State::where('id',decrypt($request->input('id')))->update([
                'country_id' =>$request->input('country_name'),
                'name'=>$request->input('name')
            ]);
            if($state):
                return to_route('admin.location.state')->with('success','State Updated Successfully !');
            else:
                return redirect()->back()->with('error','State Not Updated successfully');
            endif;
        endif;
    }
     /* 
        Update state method End
    */

    /* 
        Delete state method End
    */
    public function stateDelete(Request $request) {
        $state = State::findOrFail($request->input('id'))->delete();
        if($state):
            return response()->json([
                'status'=>'1',
                'msg'=>"State Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=>"State Not Delete !"
            ]);
        endif;
    }
    /* 
        Delete state method End
    */
    /* 
        get State By country id Method Start
    */
    public function getStateByCountryId(Request $request){
        $states = State::where('country_id',$request->input('id'))->get();
        if($states->count() > 0):
            return response()->json([
                'status'=>'1',
                'msg'=>'State Fetched Successfully !',
                'data'=>$states
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>'State Not Found !',
            ]);
        endif;
    }
    /* 
        get State By country id Method End
    */
    /* 
        Region Manage  method start
    */
    public function region(Request $request) {
        if($request->ajax()):
            $region = Region::with('country','state')->latest();
            return Datatables::of($region)
                ->addIndexColumn()
                ->editColumn('name',function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.location.region.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="regionDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','name'])
                ->make(true);
        endif;
        return view ('admin.location.region.index');
    }
    /* 
        Region Manage method end
    */
    /* 
        Region create method Start
    */
    public function regionCreate() {
        $countries = Country::get();
        return view('admin.location.region.create',compact('countries'));
    }
    /* 
        Region Create method end
    */ 

    /* 
        Region Store method start
    */
    public function regionStore(RegionRequest $request) {
        $state = Region::create([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'name'=>$request->input('name')
        ]);
        if($state):
            return to_route('admin.location.region')->with('success','Region Created Successfully !');
        else:
            return redirect()->back()->with('error','State Not created successfully');
        endif;
    }
    /* 
        Region Store method End
    */
    /* 
        Region Edit Method Start
    */
    public function regionEdit($id) {
        $countries = Country::get();
        $region = Region::findOrFail(decrypt($id));
        $states = State::where('country_id',$region->country_id)->get();
        return view('admin.location.region.edit',compact('countries','region','states'));
    }
    /* 
        Region Edit Method end
    */
    /* 
        Region Update Method Strat 
    */
    public function regionUpdate(RegionUpdateRequest $request) {
        $state = Region::where('id',decrypt($request->input('id')))->update([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'name'=>$request->input('name')
        ]);
        if($state):
            return to_route('admin.location.region')->with('success','Region Updated Successfully !');
        else:
            return redirect()->back()->with('error','State Not Updated successfully');
        endif;
    }
    /* 
        Region Update Method End 
    */
    /*  
    Region Delete Method Start
    */
    public function regionDelete(Request $request) {
        $region = Region::findOrFail($request->input('id'))->delete();
        if($region):
            return response()->json([
                'status'=>'1',
                'msg'=>"Region Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=>"Region Not Delete !"
            ]);
        endif;
    }

    /* 
    Region Delete Method end
    */

    /*  
    Get Region By state id 
    */
    public function getRegionByStateId(Request $request) {
        $region = Region::where('state_id',$request->input('id'))->get();
        if($region->count() > 0):
            return response()->json([
                'status'=>'1',
                'msg'=>'Region Fetched Successfully !',
                'data'=>$region
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>'Region Not Found !',
            ]);
        endif;
    }
    /*  
    Get Region By state id 
    */
    /* 
        City Manage Method Start
    */
    public function city(Request $request) {
        if($request->ajax()):
            $region = City::with('country','state','region')->latest();
            return Datatables::of($region)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.location.city.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="cityDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
        return view('admin.location.city.index');
    }
    /* 
        City Manage Method End
    */
    /* 
        City Create Method Start
    */
    public function cityCreate () {
        $countries = Country::get();
        return view('admin.location.city.create',compact('countries'));
    }
    /* 
        City Create Method end
    */

    /* 
    city store method start 
    */
    public function cityStore(CityCreateRequest $request) {
        $cities = City::create([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'region_id' =>$request->input('region_name')??0,
            'name' =>$request->input('name')
        ]);
        if($cities):
            return to_route('admin.location.city')->with('success','City Created Successfully !');
        else:
            return redirect()->back()->with('error','City Not Created !,Please Try Again');
        endif;
    }
    /* 
    city store method end 
    */
    /* 
        City Edit Method Start
    */
    public function cityEdit($id) {
        $city = City::findOrFail(decrypt($id));
        $countries = Country::get();
        $states = State::where('country_id',$city->country_id)->get();
        $regions = Region::where('state_id',$city->state_id)->get();
        return view('admin.location.city.edit',compact('city','countries','states','regions'));
    }
    /* 
        City Edit Method end
    */
    /* 
        city Update Method  Start
    */
    public function cityUpdate(CityUpadteRequest $request){
        $cities = City::where('id',decrypt($request->input('id')))->update([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'region_id' =>$request->input('region_name'),
            'name' =>$request->input('name')
        ]);
        if($cities):
            return to_route('admin.location.city')->with('success','City Upadted Successfully !');
        else:
            return redirect()->back()->with('error','City Not Upadted !,Please Try Again');
        endif;
    }
    /* 
        city Update Method  End
    */

    public function cityDelete(Request $request) {
        $city = City::findOrFail($request->input('id'))->delete();
        if($city):
            return response()->json([
                'status'=>'1',
                'msg'=>"City Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=>"City Not Delete !"
            ]);
        endif;
    }
    /* 
    Get City By region id
     */
    public function getCityByRegionId (Request $request) {
        $cities = City::where('region_id',$request->input('id'))->get();
        if($cities->count() > 0):
            return response()->json([
                'status'=>'1',
                'msg'=>'City Fetched Successfully !',
                'data'=>$cities
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>'City Not Found !',
            ]);
        endif;
    }
    /* 
    Get City By region id
     */
    /* 
        Cities Manage Route Start
        
    */
    public function cities(Request $request) {
        if($request->ajax()):
            $cities = Cities::with('country','state','region','city')->latest();
            return Datatables::of($cities)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.location.cities.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="citiesDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
        return view('admin.location.cities.index');
    }
    /* 
        Cities Manage Route End
    */
    public function citiesCreate() {
        $countries = Country::get();
        return view('admin.location.cities.create',compact('countries'));
    }

    public function citiesStore(CitiesRequestCreate $request){
        $sub_cities = Cities::create([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'region_id' =>$request->input('region_name')??0,
            'city_id' =>$request->input('city_name'),
            'name' =>$request->input('name')
        ]);
        if($sub_cities):
            return to_route('admin.location.cities')->with('success','Sub City Created Successfully !');
        else:
            return redirect()->back()->with('error','Sub City Not Created !,Please Try Again');
        endif;
    }

    public function citiesEdit($id) {
        $sub_cities = Cities::findOrFail(decrypt($id));
        $countries = Country::get();
        $states = State::where('country_id',$sub_cities->country_id)->get();
        $regions = Region::where('state_id',$sub_cities->state_id)->get();
        $city = City::where('region_id',$sub_cities->region_id)->get();
        return view('admin.location.cities.edit',compact('sub_cities','countries','states','regions','city'));
    }

    public function citiesUpdate(CitiesUpdateRequest$request) {
        $sub_cities = Cities::where('id',decrypt($request->id))->update([
            'country_id' =>$request->input('country_name'),
            'state_id' =>$request->input('state_name'),
            'region_id' =>$request->input('region_name'),
            'city_id' =>$request->input('city_name'),
            'name' =>$request->input('name')
        ]);
        if($sub_cities):
            return to_route('admin.location.cities')->with('success','Sub City Updated Successfully !');
        else:
            return redirect()->back()->with('error','Sub City Not Updated !,Please Try Again');
        endif;
    }

    public function citiesDelete(Request $request) {
        $cities = Cities::findOrFail($request->input('id'))->delete();
        if($cities):
            return response()->json([
                'status'=>'1',
                'msg'=>"Sub City Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=>"Sub City Not Delete !"
            ]);
        endif;
    }

    public function getSubCityByCityId(Request $request) {
        $sub_cities = Cities::where('city_id',$request->input('id'))->get();
        if($sub_cities->count() > 0):
            return response()->json([
                'status'=>'1',
                'msg'=>'City Fetched Successfully !',
                'data'=>$sub_cities
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>'City Not Found !',
            ]);
        endif;
    }
}
