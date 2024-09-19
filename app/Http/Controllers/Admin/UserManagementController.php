<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BookingInformation;
use App\Models\PaymentTransaction;
use App\Models\OwnerBillingDetails;
use App\Http\Controllers\Controller;
use App\Models\TravellerInformation;
use Illuminate\Support\Facades\Auth;
use App\Models\FeaturePropertyPayment;

class UserManagementController extends Controller
{
    public function OwnerBillingAdress(Request $request){
        if($request->ajax()):
            $OwnerBillingDetails = OwnerBillingDetails::with('users');
            return Datatables::of($OwnerBillingDetails)
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
        endif;
        return view('admin.user-management.manage-billing-address');
    }

    public function userMangement(Request $request){
        if($request->ajax()):
            $user = User::whereNot('id',Auth()->user()->id);
            return Datatables::of($user)
            ->addIndexColumn()
            ->addColumn('status',function($row){
                // dd($row);
                if($row->status==='1'):
                    return '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm" onclick="userStatusChange(0,'.$row->id.')">BLocked</a>';
                else:
                    return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onclick="userStatusChange(1,'.$row->id.')">UnBLocked</a>';
                endif;
            })
            ->rawColumns(['status'])
            ->make(true);
        endif;
        return view('admin.user-management.manage-user');
    }

    public function changeUserStatus(Request $request) {
        $userUpadte = User::where('id',$request->input('id'))->update([
            'status'=>$request->input('value')
        ]);
        if($userUpadte):
            return response()->json([
                'status'=>'1',
                'msg'=> $request->input('value')=='1'?"User Unblocked Successfully !":"User blocked Successfully ",
            ]);
        else:
            return response()->json([
                'status'=>'1',
                'msg'=> 'User Status Not Change, Please try again',
            ]);
        endif;
    }

    public function ownerSubscription (Request $request) {
        if($request->ajax()):
            $paymentTransaction = FeaturePropertyPayment::where(['payment_status'=>'success'])->with('users')->latest();
            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->editColumn('created_date',function($row){
                return date('d F Y',strtotime($row->created_at));
            })
            ->addColumn('status',function($row){
                if($row->property['0']->feature =='1' && $row->property[0]->property_feature_expiration_date ==null):
                    return '<span class="badge badge-pill badge-success">Active</span>';
                elseif($row->property['0']->feature =='0' && $row->property['0']->property_feature_expiration_date ==null):
                    return '<span class="badge badge-pill badge-secondary">Pending Approval</span>';
                elseif($row->property['0']->feature =='0' && $row->property['0']->property_feature_expiration_date !=null):
                    return '<span class="badge badge-pill badge-danger">Expired</span>';
                endif;
            })
            ->addColumn('expiration_date',function($row){
                return date('d F Y',strtotime('+'.$row->month.'month',strtotime($row->created_at)));
            })
            ->rawColumns(['created_date','expiration_date','status'])
            ->make(true);
        endif;
        return view('admin.user-management.owner-subscription');
    }

    public function propertyBookingList(Request $request) {
      
        if($request->ajax()):
            $paymentTransaction = BookingInformation::when(auth()->user()->roles()->first()->name=='Traveller',function($traveller){
                $traveller->where('user_id',auth()->user()->id);
            })->when(auth()->user()->roles()->first()->name=='Owner',function($owner){
                $owner->whereHas('property',function($property){
                    $property->where('user_id',auth()->user()->id);
                });
            })->where('status','confirmed');
            if($request->input('bookingType') == 'upcomming-booking'):
                $paymentTransaction =$paymentTransaction->where('check_out','>',now()->format('Y-m-d'))->orderBy('check_in','ASC');
            endif;
            if($request->input('bookingType') == 'ongoing-booking'):
                $paymentTransaction=$paymentTransaction->whereNot('dues_amount','0');
            endif;
            if($request->input('bookingType') == 'payment-due'):
                $paymentTransaction=$paymentTransaction->whereNot('dues_amount','0');
            endif;
            if($request->input('bookingType') == ''):
                $paymentTransaction->latest();
            endif;
           
            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->editColumn('paid_amount',function($row){
                return $row->total_amount - $row->dues_amount;
            })
            ->addColumn('action', function($row){
                $url=route('admin.property.booking.details',base64_encode($row->id));
                $actionBtn = '<a href="'.$url.'" class="edit btn btn-success btn-sm" onclick="viewDetails('.$row->id.')">View Details</a> ';
                return $actionBtn;
            })
            ->filter(function ($instance) use ($request){
                if($request->input('bookingType') == 'upcomming-booking'):
                    $instance->orderBy('check_in','ASC');
                endif;
            })
            ->rawColumns(['paid_amount','action'])
            ->make(true);
        endif;
        return view('admin.user-management.property-booking-details');
    }

    public function propertyBookingDetails($id) {
        $bookingDetails = BookingInformation::where('id',base64_decode($id))->first();
        return view('admin.booking-details',compact('bookingDetails'));
    }
}
