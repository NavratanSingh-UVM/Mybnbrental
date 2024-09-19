<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CancelBooking;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CancelBookingController extends Controller
{
    public function cancelBookingList(Request $request) {
        if($request->ajax()):
            $paymentTransaction = CancelBooking::with('bookingInformation')->orderBy('id','desc');
            return DataTables::of($paymentTransaction)
            ->addIndexColumn()
            ->addColumn('transaction_id',function($row){
                $transactionIds = [];
                foreach($row->bookingInformation->bookingTransactionHistory as $transactionId):
                    $transactionIds[] = $transactionId->transaction_id;
                endforeach; 
                return implode(',',$transactionIds);
            })
            ->addColumn('traveller_phone',function($row){
                return $row->bookingInformation->user->phone;
            })
            ->addColumn('traveller_email',function($row){
                return $row->bookingInformation->user->email;
            })
            ->editColumn('paid_amount',function($row){
                return $row->bookingInformation->total_amount - $row->bookingInformation->dues_amount;
            })
            ->addColumn('action', function($row){
                $url=route('owner.property.booking.details',base64_encode($row->bookingInformation->id));
                $actionBtn = '<a href="'.$url.'" class="edit btn btn-success btn-sm" onclick="viewDetails('.$row->bookingInformation->id.')">View Details</a> ';
                return $actionBtn;
            })
            ->rawColumns(['paid_amount','action','transaction_id','traveller_phone','traveller_email'])
            ->make(true);
        endif;
        return view('admin.cancel-booking.list');
    }
}
