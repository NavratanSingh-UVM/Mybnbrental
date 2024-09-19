@php
    $curr_date=date("Ymd");
    if(!empty($cdate)){
        $curr_date=$cdate;
    }
    $curr_year=substr($curr_date,0,4);
    $curr_month=substr($curr_date,4,2);
    $curr_day=01;
    $currentdateofmk= mktime("0","0","0",$curr_month,$curr_day,$curr_year);
    $currentdateofmkcurrent=mktime("0","0","0",date("m"),date("d"),date("Y"));
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="calendar-section">
            <div class="row no-gutters">
                <div class="col-md-6">
                    {!!App\Http\Helper\Helper::show_property_calendar(App\Http\Helper\Helper::get_current_month($curr_month,$curr_year),$propertyDetail->id,$currentdateofmk,$currentdateofmkcurrent)!!}
                </div>
                <div class="col-md-6">
                    {!!App\Http\Helper\Helper::show_property_calendar(App\Http\Helper\Helper::get_next_month_num($curr_month,$curr_year,1),$propertyDetail->id,$currentdateofmk,$currentdateofmkcurrent)!!}
                </div>
            </div>
        </div>
        
<table class="thide" border="0" width="100%" align="center" style="margin-top:10px">
    <tbody>
        <tr>
            <!--  <td width="16" height="16" bgcolor="red">&nbsp;&nbsp;</td> -->
            <td width="30" height="15" style="background:#1e1d85">&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;Booked&nbsp;&nbsp;</td>
            <td width="30" height="15" style="background:#ffffff; border:1px solid #cdcccc;">&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;Available&nbsp;&nbsp;</td>
            <td width="30" height="15" align="center" valign="top" style="background:#05dcff"></td>
            <td> &nbsp;&nbsp;Arrival&nbsp;&nbsp;</td>
            <td width="30" height="15" align="center" valign="top" style="background:#00ffdc"></td>
            <td> &nbsp;&nbsp;Departure&nbsp;&nbsp;</td>
        </tr>
    </tbody>
</table>
        
    </div>
</div>