<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PartnerListing;
use App\Http\Controllers\Controller;
use App\Models\PartnerListingPaymnet;
use Yajra\DataTables\Facades\DataTables;

class PartnerListingController extends Controller
{
    public function managePayment(Request $request) {
        if($request->ajax()):
            $partnerListingPayment = PartnerListingPaymnet::where(['payment_status'=>'success'])->orderBy('id','desc');
            return DataTables::of($partnerListingPayment)
            ->addIndexColumn()
            ->editColumn('created_at',function($row){
                return date('M dS Y',strtotime($row->created_at));
            })
            ->addColumn('expired_date',function($row){
                return date('M dS Y',strtotime("+12 months",strtotime($row->created_at)));
            })
            ->rawColumns(['created_at','status','expired_date'])
            ->make(true);
        endif;
        return view('admin.partner-listing.manage-payments');
    }

    public function manageListing(Request $request) {
        if($request->ajax()):
            $partnerListings = PartnerListing::orderBy('id','DESC')->with('user');
            return DataTables::of($partnerListings)
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
        endif;
        return view('admin.partner-listing.manage-listing');
    }
}
