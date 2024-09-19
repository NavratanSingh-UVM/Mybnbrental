<?php
namespace App\Http\Helper;
use Carbon\Carbon;
use App\Models\Chat;
use Carbon\CarbonPeriod;
use App\Models\PropertyRates;
use App\Models\PropertyBooking;
use App\Models\PropertyListing;
use App\Models\PropertiesAminites;
use App\Models\SmsApiLog;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class Helper {
    static $gb_date;
    static public function ownerRelatedProperty($user_name=null,$userId=null){
        if($user_name !=null):
            $ownerRelatedProperty = PropertyListing::where(['owner_first_name'=>$user_name,'approval'=>'1'])->get();
        else:
            $ownerRelatedProperty = PropertyListing::where(['user_id'=>$userId,'approval'=>'1'])->get();
        endif;
        return  $ownerRelatedProperty;
    }

    public static function getSubAmenites($id,$property_id){
        $subAmenites = PropertiesAminites::where(['aminities_id'=>$id,'property_id'=>$property_id])->get();
        return $subAmenites;
    }

    public static function getRoles() {
        return Role::whereNot('id','1')->get(['id','name']);
    }

    public static function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public static function show_property_calendar($date,$property_id,$currentdateofmk,$currentdateofmkcurrent) {
       
        $curr_year=substr($date,0,4);
		$curr_month=substr($date,4,2);
        $curr_day=date("j");
        $tempreturn = self::get_booking_days($property_id);
		$days = $tempreturn[0];
		$days_type = $tempreturn[1];
        $payment=$tempreturn[2];
        $calnders = '<div class="calendar calendar-first" id="calendar_first_sk"><div class="calendar_header">';
        if($currentdateofmk > $currentdateofmkcurrent):
            $calnders .= '<button class="switch-month switch-left" onclick="calenderAvailability('.date('Ymd',strtotime('-2 month',$currentdateofmk)).','.$property_id.')">  <i class="fa fa-chevron-left"></i></button>';
        else:
            $calnders .= '<button class="switch-month switch-left">  <i class="fa fa-chevron-left"></i></button>';
        endif;
        $calnders.='<h2>'.self::get_month($curr_month).' - '.$curr_year.'</h2>';
        $calnders .='<button class="switch-month switch-right" onclick="calenderAvailability('.date('Ymd',strtotime('+2 month',$currentdateofmk)).','.$property_id.')"> <i class="fa fa-chevron-right"></i></button>';
        $calnders.='</div><div class="calendar_weekdays"><div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div></div>';
        $curr_month_days=self::get_month_days($curr_month,$curr_year);
        $days_before=date("w",mktime("0","0","0",$curr_month,1,$curr_year));
        $days_after_1=date("w",mktime("0","0","0",$curr_month,$curr_month_days,$curr_year));
        $days_after=6-$days_after_1;
        $no_of_weeks=ceil(($days_before+$curr_month_days+$days_after)/7);
        $count=0;
        // dd($no_of_weeks);
        while($count<($no_of_weeks*7)):
            if($count%7==0):
                $calnders .='<div class="calendar_content">';
            endif;
            if($count<$days_before || $count>($days_before+$curr_month_days-1)):
                $calnders .= '<div class="blank"></div>';
            else:
                $this_day = $count-$days_before+1;
                $unique_this_day = array();
                $unique_this_day = array_count_values($days);
                $this_days = $this_day.'-'.$curr_month.'-'.$curr_year;
                if(in_array($this_days,$days)):
                    if($days_type[$this_day] == "3"):
                        $calnders .='<div class="calendar_days_outofservice">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                    elseif(($unique_this_day[$this_days] > 1) && in_array($curr_month,self::$gb_date['start_month']) && in_array($curr_year,self::$gb_date['start_year'])):
                        $calnders .='<div  class="calendar_book_first calendar_book_last">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                    elseif(in_array($this_days,self::$gb_date['start_day'])):
                        $calnders .='<div  class="calendar_book_first">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                    elseif(in_array($this_days,self::$gb_date['end_day'])):
                        $calnders .='<div  class="calendar_book_last">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                    else:
                        $calnders .='<div  class="calendar_days_unavailable">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                    endif;
                else:
                    $calnders .='<div class="calendar_days_available">'.($count-$days_before+1).'<small>'.self::getRatePerday($property_id,Carbon::parse($this_days)->format('Y-m-d')).'</small></div>';
                endif;
            endif;
            if($count%7==6):
            $calnders .='</div>';
            endif;
            $count=$count+1;
        endwhile;

        $calnders.='</div>';

        return $calnders;
    }

    public static function get_current_month($mnth_no,$year_no){
        return $year_no.$mnth_no."01";
    }

    public static function get_next_month_num($mnth_no,$year_no,$num)
	{
		$mnth_no = intval(intval($mnth_no)+intval($num));
		if($mnth_no>12)
		{
			$mnth_no = $mnth_no-12;
			if(strlen($mnth_no)==1)
				$mnth_no="0".$mnth_no;
			return ($year_no+1).$mnth_no."01";
		}
		else
		{
			if(strlen($mnth_no)==1)
				$mnth_no="0".$mnth_no;
			return $year_no.$mnth_no."01";
		}
	}

    public static function get_booking_days($property_id){
        $start_days_arr = [];
        $end_days_arr= [];
        $start_months_arr=[];
        $end_months_arr = [];
        $start_years_arr = [];
        $end_years_arr = [];
        $daysre = [];
        $days_type=[];
        $payment=array();
     
            $propertyBookings = PropertyBooking::where('property_id',$property_id)->where('events','!=','')->get();
        foreach($propertyBookings as $propertyBooking):
            $start_days_arr[] = Carbon::parse($propertyBooking->start_date)->format('j-m-Y');
            $end_days_arr[] = Carbon::parse($propertyBooking->end_date)->format('j-m-Y');
            $start_months_arr[]= Carbon::parse($propertyBooking->start_date)->format('m');
            $end_months_arr []=Carbon::parse($propertyBooking->end_date)->format('m');
            $start_years_arr[]=Carbon::parse($propertyBooking->start_date)->format('Y');
            $end_years_arr[] = Carbon::parse($propertyBooking->end_date)->format('Y');
            $dateRange = CarbonPeriod::create(Carbon::parse($propertyBooking->start_date),Carbon::parse($propertyBooking->end_date));
            $days = array_map(fn ($date) => $date->format('j-m-Y'), iterator_to_array($dateRange));
            foreach($days as $day):
                $daysre[]=$day;
                $days_type[Carbon::parse($day)->format('j')]='1';
            endforeach;
        endforeach;
        self::$gb_date['start_day'] = $start_days_arr;
        self::$gb_date['end_day'] = $end_days_arr;
        self::$gb_date['start_month'] = $start_months_arr;
        self::$gb_date['end_month'] = $end_months_arr;
        self::$gb_date['start_year'] = $start_years_arr;
        self::$gb_date['end_year'] = $end_years_arr;
        return array($daysre,$days_type,$payment);
    }

    public static function get_month($mnth_no){
        switch($mnth_no){
            case 1:return "January";
            break;
            case 2:return "February";
            break;
            case 3:return "March";
            break;
            case 4:return "April";
            break;
            case 5:return "May";
            break;
            case 6:return "June";
            break;
            case 7:return "July";
            break;
            case 8:return "August";
            break;
            case 9:return "September";
            break;
            case 10:return "October";
            break;
            case 11:return "November";
            break;
            case 12:return "December";
            break;
        }
    }

    public static function get_month_days($mnth_no,$year_no) {
        switch($mnth_no){
			case 1:return 31;
			break;
			case 3:return 31;
			break;
			case 5:return 31;
			break;
			case 7:return 31;
			break;
			case 8:return 31;
			break;
			case 12:return 31;
			break;
			case 10:return 31;
			break;
			case 4:return 30;
			break;
			case 6:return 30;
			break;
			case 9:return 30;
			break;
			case 11:return 30;
			break;
			case 2:
                if(self::check_leap_year($year_no)){
					return 29;
				}
				else
				{
					return 28;
				}
			break;
		}
    }

    public static function check_leap_year($year_no){
        if($year_no%400==0 || $year_no%4==0)
			return true;
		else
			return false;
    }

    public static function checkOddMonth($month){
        if($month/2==0):
            return true;
        else:
            return false;
        endif;
    }


    public static function getTotalUnreadMesage($userId){
        return Chat::where(['reciver_id'=>$userId,'status'=>"0"])->count();

    }
    public static function getTotalUnreadReciverMesage($userId,$reciverId){

        return Chat::where(['reciver_id'=>$userId,'status'=>"0",'sender_id'=>$reciverId])->count();

    }

    public static function getRatePerday($property_id,$date) {
        $propertyRates = PropertyBooking::where('property_id',$property_id)->where('rate', '!=', '')->where('start_date',$date)
      ->where('end_date',$date)
        ->pluck('property_id','rate','start_date','end_date','minimum_stay')->first();
         $propertyRates =Carbon::parse($propertyRates)->format('Y-m-d');
        if($propertyRates ==null)
        return "$".$propertyRates->rate;
    }

    public static function getPropertyBookingDate($property_id){
        ini_set('memory_limit', -1);
        $selectedDate = [];
         $PropertyRates = PropertyBooking::where('property_id',$property_id)->where('events', '!=', '')->get();
        foreach($PropertyRates as $propertyBooking):
            $startdate =$propertyBooking->start_date;
            $enddate = $propertyBooking->end_date;
            $dateRange = CarbonPeriod::create(Carbon::parse($startdate)->addDays(1),Carbon::parse($enddate)->subDays(1) );
            $days = array_map(fn ($date) => $date->format('d-m-Y'), iterator_to_array($dateRange));
            foreach( $days as $day):
                $selectedDate[] = $day;
            endforeach;
        endforeach;
        return json_encode($selectedDate);
    }

      public static function getPropertyRatesWhichDate($property_id) {
        ini_set('memory_limit', -1);
        $selectedDate = [];
        $propertyBookings = PropertyBooking::where('property_id',$property_id)->where('rate','!=','')->get();
        foreach($propertyBookings as $propertyBooking):
            $startdate =$propertyBooking->start_date;
            $enddate = $propertyBooking->end_date;
                if($propertyBooking !=null)
                $day = Carbon::createFromFormat('Y-m-d', $propertyBooking->start_date)->format('d-m-Y');
               $selectedDate[] = $day;
        endforeach;
        return json_encode($selectedDate);
    }

    public static function sendSms($mobileNo,$message) {
        try{
            $response = Http::withHeaders([
                'Authorization'=>"Bearer ".env('SMS_TOKEN')
            ])->post('https://api.telnyx.com/v2/messages',[
                'from'=>"+18889191772",
                'to'=>$mobileNo,
                'text'=>$message
            ]);
            SmsApiLog::create([
                'api_url'=>"https://api.telnyx.com/v2/messages",
                'request'=>json_encode([
                    'from'=>"+18889191772",
                    'to'=>$mobileNo,
                    'text'=>$message
                ]),
                'response'=>json_encode(json_decode($response->body(),true))
            ]);
        }catch (Exception $e){
            return $e->getMessage();
        }

    }


}
