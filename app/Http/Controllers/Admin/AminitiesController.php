<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MainAminity;
use DataTables;
use App\Models\SubAminities;

class AminitiesController extends Controller
{
    /*
    Manage main Aminity Method start
    */

    public function manageMainAminity (Request $request) {

        return view("admin.master.aminity.main");
    }

    /*
    Manage main Aminity Method end
    */

    /*
    Create Main Aminity method start
    */
    public function createMainAminty() {
        return view('admin.master.aminity.create-main');
    }
    /*
    Create Main Aminity method end
    */
    public function storeMainAminity(Request $request) {
        $rule = [
            'aminity_name'=>'required|unique:main_aminities'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $mainAminity = MainAminity::create([
                'aminity_name'=>$request->input('aminity_name'),
                'status'=>'1'
            ]);
            if($mainAminity):
                return to_route('admin.master.manage.main.aminity')->with('success','Aminity Created Successfully !.');
            else:
                return redirect()->back()->with('error',"Aminity Not Created, Please try again !.");
            endif;

        endif;
    }
    /*
        Store Main Aminity Method Start
    */
    /*
        Store Main Aminity Method end
    */

    public function getAmenitesUsingDatatble(Request $request) {
        if ($request->ajax()) {
            $data = MainAminity::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.master.edit.main.aminities',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="amenitiesDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Aminities Delete Method

    public function DeleteMAinAminity(Request $request) {
        $mainAminity = MainAminity::find($request->input('id'))->delete();
        if($mainAminity):
            return response()->json([
                'status'=>'1',
                'msg'=>"Aminities Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>"Aminities Not Delete, Please Try again !"
            ]);
        endif;
    }

    // edit Aminities Method
    public function editMainAminity ($id) {
        $aminities = MainAminity::findOrFail(decrypt($id));
        return view('admin.master.aminity.edit-main',compact('aminities'));
    }

    // Update main aminities
    public function updateMainAminities(Request $request) {
        $rule = [
            'aminity_name'=>'required|unique:main_aminities'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $mainAminity = MainAminity::where('id',decrypt($request->id))->update([
                'aminity_name'=>$request->input('aminity_name'),
                'status'=>'1'
            ]);
            if($mainAminity):
                return to_route('admin.master.manage.main.aminity')->with('success','Aminity Updated Successfully !.');
            else:
                return redirect()->back()->with('error',"Aminity Not update, Please try again !.");
            endif;

        endif;
    }

    public function manageSubAminity (Request $request) {
        if ($request->ajax()) {
            $data = SubAminities::with('mainAminities')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('admin.master.edit.sub.aminities',['id'=>encrypt($row->id)]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="subAmenitiesDelete('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.aminity.sub-index");
    }

    public function createsubAminty() {
        $mainAminities = MainAminity::get();
        return view("admin.master.aminity.create-sub-aminities",compact('mainAminities'));
    }


    // Store Sub aminity Method
    public function storeSubAminity(Request $request) {
        $rule = [
            'main_aminity_name'=>'required',
            'name'=>'required|unique:sub_aminities'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $mainAminity = SubAminities::create([
                'main_aminities_id'=>$request->input('main_aminity_name'),
                'name'=>$request->input('name'),
            ]);
            if($mainAminity):
                return to_route('admin.master.manage.sub.aminity')->with('success','Sub Aminities created Successfully !.');
            else:
                return redirect()->back()->with('error',"Sub Aminities Not created, Please try again !.");
            endif;

        endif;
    }

    // Delete Sub Aminities
    public function DeleteSubAminity(Request $request) {
        $SubAminities = SubAminities::find($request->input('id'))->delete();
        if($SubAminities):
            return response()->json([
                'status'=>'1',
                'msg'=>"Aminities Delete Successfully !"
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>"Aminities Not Delete, Please Try again !"
            ]);
        endif;
    }

    // Edit Sub Aminity
    public function editSubAminity ($id) {
        $subAminities = SubAminities::findOrFail(decrypt($id));
        $mainAminities = MainAminity::get();
        return view('admin.master.aminity.edit-sub',compact('subAminities','mainAminities'));
    }

    // Update Sub Aminity
    public function updateSubAminities (Request $request) {
        $rule = [
            'main_aminity_name'=>'required',
            'name'=>'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()) :
            return redirect()->back()->withErrors($validator)->withInput();
        else:
            $mainAminity = SubAminities::where('id',decrypt($request->input('id')))->update([
                'main_aminities_id'=>$request->input('main_aminity_name'),
                'name'=>$request->input('name'),
            ]);
            if($mainAminity):
                return to_route('admin.master.manage.sub.aminity')->with('success','Sub Aminities updated Successfully !.');
            else:
                return redirect()->back()->with('error',"Sub Aminities Not updated, Please try again !.");
            endif;

        endif;
    }



}
