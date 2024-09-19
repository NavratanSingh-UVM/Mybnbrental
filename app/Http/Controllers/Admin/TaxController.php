<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Country;
use App\Models\State;
use App\Models\Tax;
use DataTables;
use App\Models\SubAminities;

class TaxController extends Controller
{
    public function list(Request $request){
        if($request->ajax()):
            $tax = Tax::with('country')->with('state')->latest();
            return Datatables::of($tax)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.tax.edit',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="taxDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        endif;
       return view("admin.tax.index");
    }
    public function create(Request $request){
        $countries = Country::get();
        $states = State::with('country')->get();
            return view("admin.tax.create",compact('countries','states'));
    }
    public function store(Request $request){
        $rule = [
            'country_id'=>'required',
            'state_id'=>'required',
            'tax'=>'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $tax = Tax::create([
                'country_id' =>$request->input('country_id'),
                'state_id' =>$request->input('state_id'),
                'tax'=>$request->input('tax')
            ]);
            if($tax):
                return to_route('admin.tax.list')->with('success','Tax Created Successfully !');
            else:
                return redirect()->back()->with('error','Tax Not created successfully');
            endif;
        endif;
    }
    public function edit($id) {
        $countries = Country::get();
        $states = State::get();
        $data = Tax::findOrFail(decrypt($id));
        return view ('admin.tax.edit',compact('countries','states','data'));
    }

    public function Update(Request $request) {
        $rule = [
            'country_id'=>'required',
            'state_id' => 'required',
            'tax'=>'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $tax = Tax::where('id',decrypt($request->input('id')))->update([
                'country_id' =>$request->input('country_id'),
                'state_id' =>$request->input('state_id'),
                'tax'=>$request->input('tax')
            ]);
            if($tax):
                return to_route('admin.tax.list')->with('success','Tax Updated Successfully !');
            else:
                return redirect()->back()->with('error','Tax Not Updated successfully');
            endif;
        endif;
    }

    public function destroy(Request $request){
        $result = Tax::where('id',$request->input('id'))->delete();
        if($result):
            return response()->json([
                'status'=>200,
                'message'=>'Tax  Delete Successfully'
            ]);
        else:
            return response()->json([
                'status'=>500,
                'message'=>'Tax Not Delete, Please Try again',
            ]);
        endif;

    }

}
