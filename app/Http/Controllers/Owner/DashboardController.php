<?php

namespace App\Http\Controllers\Owner;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Cities;
use App\Models\Region;
use App\Models\Country;
use App\Models\Package;
use App\Models\Currency;
use App\Http\Helper\Helper;
use App\Models\MainAminity;
use App\Models\PropertyType;
use App\Models\SubAminities;
use Illuminate\Http\Request;
use App\Models\CancelBooking;
use App\Models\PropertyRates;
use App\Models\PropertyBooking;
use App\Models\PropertyEnquiry;
use App\Models\PropertyGallery;
use App\Models\PropertyListing;
use App\Models\BookingInformation;
use App\Models\PaymentTransaction;
use App\Models\PropertiesAminites;
use App\Models\CancellentionPolicy;
use App\Http\Controllers\Controller;
use App\Models\TravellerInformation;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyReviewsRating;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Tax;


class DashboardController extends Controller
{
    public function index() {
        $totalProperty = PropertyListing::where('user_id',auth()->user()->id)->count();
        $properties = PropertyListing::where('user_id',auth()->user()->id)->get(['id']);
        $propertyIds = [];
        $totalBooking = 0;
        $totalPayments = 0;
        foreach($properties as $property):
            $propertyIds[] = $property->id;
        endforeach;
        $totalBooking = BookingInformation::whereIn('property_id',$propertyIds)->whereHas('bookingTransactionHistory',function($q) {
            $q->where('status','success');
        })->where('status','confirmed')->count();


        BookingInformation::whereIn('property_id',$propertyIds)->where('status','confirmed')->each(function ($p,$k) use (&$totalPayments){
            $totalPayments +=$p->bookingTransactionHistory()->where('status','success')->sum('pay_amount');
        });

        $totalReviews = PropertyReviewsRating::whereIn('property_id',$propertyIds)->count();
        return view('owner.dashboard',compact('totalProperty','totalBooking','totalPayments','totalReviews'));
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return to_route('frontend.index');
    }

    public function createProperty($propert_id=null) {
        $propertyTypes = PropertyType::get();
        $countries = Country::get();
        $mainAminity = MainAminity::with('subAminities')->get();
        $currencies = Currency::get();
        $cancelletionPolicies = CancellentionPolicy::get();
        $propertyListing = "";
        $states="";
        $regions="";
        $cities="";
        $sub_cities="";
        $tax= "";
        if(!is_null($propert_id)){
            $propertyListing = PropertyListing::where("id",base64_decode($propert_id))->first();
            $states = State::where('country_id',$propertyListing->country_id)->get();
            $regions = Region::where('state_id',$propertyListing->state_id)->get();
            $cities = City::where('region_id',$propertyListing->region_id)->get();
            $sub_cities = Cities::where('city_id',$propertyListing->city_id)->get();
            $tax=Tax::where('country_id',$propertyListing->country_id)->where('state_id',$propertyListing->state_id)->first();

        }
       return view('owner.create-property',compact('propertyTypes','countries','mainAminity','currencies','propertyListing','states','regions','cities','sub_cities','cancelletionPolicies','tax'));
    }
    public function myPropertyListing(Request $request){
        if($request->ajax()):
            $propertyListing = PropertyListing::where('user_id',Auth::user()->id)->latest()->with('region','city','sub_city');
            return Datatables::of($propertyListing)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if($request->get('property_id') != ''):
                        $instance->where('id', $request->get('property_id'));
                    elseif($request->get('email') != ''):
                        $user = User::where('email',$request->get('email'))->first();
                        $instance->where('user_id', $user->id);
                    elseif($request->get('name') != ''):
                        $user = User::where('name',$request->get('name'))->first();
                        $instance->where('user_id', $user->id);
                    endif;
                })
                ->editColumn('property_name',function($row){
                    return Helper::limit_text($row->property_name,2);
                })
                ->editColumn('property_main_photos',function($row) {
                    return '<img src="'.url('public/storage/upload/property_image/main_image/'.$row->property_main_photos).'" class=" rounded-circle mr-3" height="50" width="50">';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('owner.create.property',['id'=>base64_encode($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="propertyDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('status',function($row) {
                    if($row->approval =='0'):
                        return '<span class="badge badge-pill badge-secondary">Pending Approval</span>';
                    else:
                        return '<span class="badge badge-pill badge-success">Active</span>';
                    endif;
                })
                ->editColumn('subscription_date',function($row){
                    return $row->subscription_date !=null ?date('M, d, Y',strtotime($row->subscription_date)):"NA";
                })
                ->rawColumns(['action','property_main_photos','property_approved','subscription_date','renval_date','featured_approved','status'])
                ->make(true);
        endif;
        return view('owner.my-property-listing');
    }

    public function bookingRequest(Request $request){
        if($request->ajax()):
            $propertyEnquiry= PropertyEnquiry::where('owner_id',Auth::user()->id)->latest()->with(['property','user']);
            return Datatables::of($propertyEnquiry)
            ->addIndexColumn()
            ->editColumn('check_in',function($row){
                return $row->check_in !=null ?date('M dS Y',strtotime($row->check_in)):"NA";
            })
            ->editColumn('check_out',function($row){
                return $row->check_out !=null ?date('M dS Y',strtotime($row->check_out)):"NA";
            })
            ->editColumn('enquiry_date',function($row){
                return $row->created_at !=null ?date('M dS  Y',strtotime($row->created_at)):"NA";
            })
            ->rawColumns(['check_in','check_out','enquiry_date'])
            ->make(true);
        endif;
        return view('owner.booking-request');
    }

    public function propertyBooking(Request $request) {
       if($request->ajax()):
            // dd($request->all());
            $paymentTransaction = BookingInformation::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
                $traveller->where('user_id',auth()->user()->id);
            })->when(auth()->user()->roles()->first()->name=='Owner',function($owner){
                $owner->whereHas('property',function($property){
                    $property->where('user_id',auth()->user()->id);
                });
            })->where('status','confirmed')->orderBy('id','desc')->get();

            if($request->input('bookingType') == 'upcomming-booking'):
                $paymentTransaction =$paymentTransaction->where('check_out','>',now()->format('Y-m-d'));
            endif;
            if($request->input('bookingType') == 'payment-due'):
                $paymentTransaction=$paymentTransaction->whereNot('dues_amount', 0);
            endif;
            if($request->input('bookingType') == 'payment-due'):
                $paymentTransaction=$paymentTransaction->whereNot('dues_amount','0');
            endif;
            if($request->input('bookingType') == 'allData'):
                $paymentTransaction;
            endif;
            if($request->input('bookingType') == ''):
                $paymentTransaction;
            endif;

            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->editColumn('paid_amount',function($row){
                return $row->total_amount - $row->dues_amount;
            })
            ->addColumn('action', function($row){
                $url = "";
                if(auth()->user()->roles()->first()->name=='Owner'):
                    $url = route('owner.property.booking.details',base64_encode($row->id));
                else:
                    $url=route('traveller.booking.details',base64_encode($row->id));
                endif;
                $actionBtn = '<a href="'.$url.'" class="edit btn btn-success btn-sm" onclick="viewDetails('.$row->id.')">View Details</a> ';
                return $actionBtn;
            })
            ->rawColumns(['paid_amount','action'])
            ->make(true);
        endif;
        return view('owner.property-booking-details');
    }

    public function propertyBookingDetails ($id) {
        $bookingDetails = BookingInformation::where('id',base64_decode($id))->first();
        return view('owner.property-booking-details-info',compact('bookingDetails'));
    }

    public function chat(){
        return view('owner.chat');
    }

    public function cancelBooking(Request $request) {
        if($request->ajax()):
            $paymentTransaction = CancelBooking::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
                $traveller->whereHas('bookingInformation',function ($u){
                    $u->whereHas('property',function($q){
                        $q->where('user_id',auth()->user()->id);
                    })->where('status','cancelled');
                });
            })->with('bookingInformation')->orderBy('id','desc')->get();
            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->editColumn('paid_amount',function($row){
                return $row->bookingInformation->total_amount - $row->bookingInformation->dues_amount;
            })
            ->editColumn('traveller_name',function($row){
                return $row->bookingInformation->user->name;
            })
            ->addColumn('action', function($row){
                $url=route('owner.property.booking.details',base64_encode($row->bookingInformation->id));
                $actionBtn = '<a href="'.$url.'" class="edit btn btn-success btn-sm" onclick="viewDetails('.$row->bookingInformation->id.')">View Details</a> ';
                return $actionBtn;
            })
            ->rawColumns(['paid_amount','action','traveller_name'])
            ->make(true);
        endif;
        return view('owner.cancel-booking-list');
    }

    public function switchToTraveller() {
        auth()->user()->roles()->sync(['3']);
        return redirect()->route('traveller.dashboard');
    }
}
