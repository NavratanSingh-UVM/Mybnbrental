<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInsurance;
use Illuminate\Http\Request;
use Validator;
use App\Models\Insurance;
use App\Models\PropertyListing;
use DataTables;
use DB;

class InsuranceController extends Controller
{
    public function list(Request $request){
        
        if($request->ajax()):
            $insurance = Insurance::with('property_name')->latest();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $insurance = $insurance->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
            return Datatables::of($insurance)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="insuranceDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
       return view("admin.insurance.index");
   }

public function export(Request $request){
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    if($request->input('select')=='Check_in'){
        $insurance= DB::table('insurances')
        ->select('insurances.id','insurance_name','property_listings.property_name','payment_date','start_date','end_date','insurances.check_in','insurances.check_out','details')
        ->join('property_listings','property_listings.id','=','insurances.property_id')
         ->whereDate('insurances.check_in', '>=', $startDate)
         ->whereDate('insurances.check_out', '<=', $endDate)
        ->get();
        return Excel::download(new ExportInsurance($insurance), 'insurances.xlsx');
    }else{
       $insurance= DB::table('insurances')
        ->select('insurances.id','insurance_name','property_listings.property_name','payment_date','start_date','end_date','insurances.check_in','insurances.check_out','details')
        ->join('property_listings','property_listings.id','=','insurances.property_id')
        ->whereBetween('payment_date', [$startDate,$endDate])
        ->get();
        return Excel::download(new ExportInsurance($insurance), 'insurances.xlsx');

    }
}
  public function destroy(Request $request){
  
  }
}
