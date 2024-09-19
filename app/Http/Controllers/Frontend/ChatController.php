<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\PropertyType;
use App\Models\PropertyListing;
use Illuminate\Support\Facades\Auth;
use App\Models\TemplateMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ChatController extends Controller
{
    public function chat() {
        return view('traveller.chat.index');
    }

    public function getUser() {
        // dd('hello',User::when(auth()->user()->roles()));
        $users = User::when(auth()->user()->roles()->first()->name=='Traveller',function($user){
            $user->whereHas('roles',function($roles){
                $roles->where('name','Owner');
            })->whereHas('reciverChat',function($user){
                $user->where('sender_id',auth()->user()->id);
            });
        })->when(auth()->user()->roles()->first()->name=='Owner',function($user){
            $user->whereHas('roles',function($roles){
                $roles->where('name','Traveller');
            })->whereHas('senderChat',function($user){
                $user->where('reciver_id',auth()->user()->id);
            });
        });
        $users=$users->get(['id','name','image']);

        $user = [];
        foreach($users as $us):
            $user []=[
                'id'=>$us->id,
                'name'=>$us->name,
                'image'=>$us->image !=null?url('public/storage/profile_image/'.$us->image):asset('owner-assets/img/agent-1.jpg'),
                'unread_message' =>Helper::getTotalUnreadReciverMesage(auth()->user()->id,$us->id)
            ];
        endforeach; 
        if($users->count()>0):
            return response()->json([
                'status'=>true,
                'msg'=>"user fetched successfully",
                'data'=>$user
            ],);
        else:
            return response()->json([
                'status'=>true,
                'msg'=>"User Does Not exists",
            ],);
        endif;
    }

    public function InsertChat(Request $request) {
        Chat::where(['sender_id'=>$request->input('reciverId'),'reciver_id'=>auth()->user()->id,'status'=>'0'])->update([
            'status'=>'1',
        ]);
        $chats = Chat::create([
            'sender_id'=>auth()->user()->id,
            'reciver_id'=>$request->input('reciverId'),
            'msg'=>$request->input('msg'),
        ]);
        if($chats):
            return response()->json([
                'status'=>true,
            ]);
        else:
            return response()->json([
                'status'=>false
            ]);
        endif;
    }

    public function getChat(Request $request) {
        $groupGetChats = Chat::where(['sender_id'=>auth()->user()->id,'reciver_id'=>$request->id])->orWhere(function($q) use ($request){
            $q->where(['sender_id'=>$request->id,'reciver_id'=>auth()->user()->id]);
        })->groupBy(DB::raw('Date(created_at)'))->get();
        $html = " <ul>";
        foreach($groupGetChats as $Groupchat):
            $dailyAccourdingChat = Chat::where(['sender_id'=>auth()->user()->id,'reciver_id'=>$request->id])->whereDate('created_at',Carbon::parse($Groupchat->created_at)->format('Y-m-d'))->orWhere(function($q) use ($request,$Groupchat ){
                $q->where(['sender_id'=>$request->id,'reciver_id'=>auth()->user()->id])->whereDate('created_at',Carbon::parse($Groupchat->created_at)->format('Y-m-d'));
            })->get();
            if(now()->diffInHours($Groupchat->created_at) >=24):
                $html .= '<li><div class="divider"> <h6>'.Carbon::parse($Groupchat->created_at)->format('d M Y').'</h6> </div> </li>';
            else:
                $html .= '<li><div class="divider"> <h6>Today</h6> </div> </li>';
            endif;
            foreach($dailyAccourdingChat as $key=> $dailyChat):
                if(now()->diffInMinutes($dailyChat->created_at) >=1):
                    $time = Carbon::parse($dailyChat->created_at)->format('H:i');
                else:
                    $time ="Just Now";
                endif;
                if(auth()->user()->id === $dailyChat->sender_id):
                   
                    $html .='<li class="repaly"><p>'.$dailyChat->msg.'</p><span class="time">'.$time.'</span></li>';
                else:
                    if( $dailyChat->status=='0'):
                        $html .= '<li><div class="divider"> <h6>Unread Message</h6> </div> </li>';
                    endif;
                    $html .= '<li class="sender"><p>'.$dailyChat->msg.'</p> <span class="time">'.$time.'</span></li>';
                endif;
            endforeach;
        endforeach;
        $html .='</ul>'; 
        return response()->json([
            'status'=>true,
            'data'=>$html,
        ]);
        
    }

    public function scheduledMessage(Request $request,$id){
        return view('owner.chat.scheduled-message',compact('id'));
    }

    public function templateListing(Request $request,$id){
        $user_id= (is_numeric(base64_decode(decrypt($id)))==true)?base64_decode(decrypt($id)):decrypt(decrypt($id));
        if($request->ajax()):
            $templateMessages =TemplateMessages::where('user_id',$user_id)->get();
            return Datatables::of($templateMessages,$id)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if($request->get('4	property_listing_id') != ''):
                    $instance->where('id', $request->get('4	property_listing_id'));
                endif;
            })   
            ->editColumn('property_name',function($row){
                return Helper::limit_text($row->property_name,2);
            })
           
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('owner.chat.edit.template',['id'=>encrypt($row->template_msg_id )]).'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="propertyDelete('.$row->template_msg_id .')">Delete</a>';
                return $actionBtn;
            })
            ->addColumn('Template Action',function($row) {
                if($row->scheduling =='1'):
                    return '<span class="badge badge-pill badge-success">Booking Confirmed</span>';
                elseif($row->scheduling =='2'):
                    return '<span class="badge badge-pill badge-primary">Check In</span>';
                else:
                    return '<span class="badge badge-pill badge-secondary">Check Out</span>';
                endif;
            })
            ->editColumn('subscription_date',function($row){
                return $row->subscription_date !=null ?date('M, d, Y',strtotime($row->subscription_date)):"NA";
            })
            ->rawColumns(['action','Template Action'])
            ->make(true);
        endif;
    }
   
     public function quickReplies(Request $request){
        return view('owner.chat.quick-replies');
    }

    public function createTemplate(Request $request,$id){
        $propertListing=PropertyListing::where('user_id',base64_decode(decrypt($id)))->get();
        if(empty($propertListing->toarray())){
           $propertListing=PropertyListing::where('user_id',(decrypt(decrypt($id))))->get();
           $id=decrypt(decrypt($id));
           return view('owner.chat.create-template',compact('propertListing','id'));
        }
        $id= base64_decode(decrypt($id));
        return view('owner.chat.create-template',compact('propertListing','id'));
    }

     public function editTemplate(Request $request){
        $templateMessages = TemplateMessages::where("template_msg_id",decrypt($request['id']))->first();
        $propertListing_id=explode(',',$templateMessages->property_listing_id);
       $propertListing=PropertyListing::where('user_id',$templateMessages->user_id)->get();
       $id=$templateMessages->user_id;
         return view('owner.chat.create-template',compact('propertListing','templateMessages','propertListing_id','id'));
     }

    public function store(Request $request){
        date_default_timezone_set('Asia/Kolkata');
        $user_id=$request['user_id'];
        $msg_send_time=[];
        if($request->input('booking_confirmed')==!null){
            $arr= (explode(" ",$request->input('booking_confirmed')));
           array_push( $msg_send_time,date('Y-m-d H:i', strtotime("+$arr[0] $arr[1]")));
        }elseif($request->input('check_In_day')==!null && $request->input('check_In_time')==!null){
            $arr= (explode(" ",$request->input('check_In_day')));
           $time= (explode(" ",$request->input('check_In_time')));
           array_push( $msg_send_time,date('Y-m-d H:i', strtotime("+$arr[0] $arr[1] $time[0] $time[1]")));
        }elseif($request->input('check_out_day')==!null && $request->input('check_out_time')==!null){
            $arr= (explode(" ",$request->input('check_out_day')));
           $time= (explode(" ",$request->input('check_out_time')));
           array_push( $msg_send_time,date('Y-m-d H:i', strtotime("+$arr[0] $arr[1] $time[0] $time[1]")));
        }
        $rules=[
            'template_name'=>'required',
            'message'=>'required',
            'property_listing_id'=>'required',
            'scheduling'=>'required'
        ];
        $messages=[
            'template_name' => 'Please enter a template name.',
            'message' => 'Please enter a message.',
            'property_listing.required' => 'Please select a property id.',
            'scheduling.required' => 'scheduling .'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            return response()->json([ 'status'=>500 ,"errors"=>$messages], 500);
        }
        $template_id=TemplateMessages::where("template_msg_id",$request->input('template_msg_id'))->first();
        if($template_id==null){
        $data= new TemplateMessages();
        $data->template_name=$request->input('template_name');
        $data->user_id=$user_id;
        $data->message=$request->input('message');
        $data->property_listing_id=implode(',',$request->input('property_listing_id'));
        $data->scheduling=$request->input('scheduling');
        $data->day=($request->input('booking_confirmed')==!null) ? $request->input('booking_confirmed') :(($request->input('check_In_day')==!null)?$request->input('check_In_day'):$request->input('check_out_day'));
        $data->time=($request->input('check_In_time')==!null)?$request->input('check_In_time') :(($request->input('check_out_time')==!null)?$request->input('check_out_time'):null);
        $data->msg_send_time=$msg_send_time[0];
        $result= $data->save();
        }else{
            $result = TemplateMessages::where("template_msg_id",$request->input('template_msg_id'))->update([
                'template_name'=>$request->input('template_name'),
                'user_id'=>$request->input('user_id'),
                'message'=>$request->input('message'),
                'scheduling'=>$request->input('scheduling'),
                'day'=>($request->input('booking_confirmed')==!null) ? $request->input('booking_confirmed') :(($request->input('check_In_day')==!null)?$request->input('check_In_day'):$request->input('check_out_day')),
                'time'=>($request->input('check_In_time')==!null)?$request->input('check_In_time') :(($request->input('check_out_time')==!null)?$request->input('check_out_time'):null),
                'msg_send_time'=>$msg_send_time[0],
            ]);
            return response()->json([
                'id'=>encrypt($user_id),
                'status'=>200,
                "msg"=>"Update message template successFully"
            ]);
        }
        if($result):
            return response()->json([
                'status'=>200,
                'id'=>encrypt($user_id),
                "msg"=>"Create message template  successFully"
            ]);
        else:
            return response()->json([
                'status'=>500,
                'id'=>encrypt($user_id),
                "msg"=>"Message Template Not create,Please try again"
            ]);
        endif;
       
    }

    public function destroy(Request $request) {
      //  dd($request->all());
        $result = TemplateMessages::where('template_msg_id',$request->input('id'))->delete();
        if($result):
            return response()->json([
                'status'=>200,
                'message'=>'Message Template  Delete Successfully'
            ]);
        else:
            return response()->json([
                'status'=>500,
                'message'=>'Message Template Not Delete, Please Try again',
            ]);
        endif;
    }
}
