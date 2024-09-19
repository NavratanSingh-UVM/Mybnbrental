<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="" content="">
    <style>
        body, p {
            font-family: 'Helvetica Neue', Helvetica,Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border: 0;
            padding: 0;
        }
        img {
            margin: 0;
            padding: 0;
        }
    
        .content {
            width: 600px;
        }
    
        .no_text_resize {
            -moz-text-size-adjust: none;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
            text-size-adjust: none;
        }
    
        /* Media Queries */
        @media all and (max-width: 600px) {
    
            table[class="content"] {
                width: 100% !important;
            }
    
            tr[class="grid-no-gutter"] td[class="grid__col"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
    
            td[class="grid__col"] {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
    
            table[class="small_full_width"] {
                width: 100% !important;
                padding-bottom: 10px;
            }
    
            a[class="header-link"] {
                margin-right: 0 !important;
                margin-left: 10px !important;
            }
    
            a[class="btn"] {
                width: 100%;
                border-left-width: 0px !important;
                border-right-width: 0px !important;
            }
    
            table[class="col-layout"] {
                width: 100% !important;
            }
    
            td[class="col-container"] {
                display: block !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
    
            td[class="col-nav-items"] {
                display: inline-block !important;
                padding-left: 0 !important;
                padding-right: 10px !important;
                background: none !important;
            }
    
            img[class="col-img"] {
                height: auto !important;
                max-width: 520px !important;
                width: 100% !important;
            }
    
            td[class="col-center-sm"] {
                text-align: center;
            }
    
            tr[class="footer-attendee-cta"] > td[class="grid__col"] {
                padding: 24px 0 0 !important;
            }
    
            td[class="col-footer-cta"] {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
    
            td[class="footer-links"] {
                text-align: left !important;
            }
        }

    </style>
    </head>
    <body border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7" style="margin: 0;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7">
            <tr>
                <td style="padding-right: 10px; padding-left: 10px;">
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F7F7" style="width: 600px; max-width: 600px;">
                        <tr>
                            <td width="33%" valign="middle" style="text-align:left; padding:20px 0 10px 0;">
                                <a href="{{route('frontend.index')}}">
                                    <img src="{{asset('frontend-assets/img/logo.png')}}" width="200" height="42" border="0" alt="" style="width:200px; height:42px;background: #1e1d85;padding: 5px;border-radius: 2px;"  />
                                </a>
                            </td>
                            <td width="66%" valign="middle" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: right; padding-top: 12px; vertical-align: middle;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F7F7F7" style="width: 600px; max-width: 600px;">
                        <tr>
                            <td colspan="2" style="background: #fff; border-radius: 8px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                            <tr class="">
                                                <td class="grid__col" style="font-family: 'Helvetica neue', Helvetica, arial, sans-serif; padding: 32px 40px; ">
                                                    <h1 style="color: #404040; font-weight: 800; margin: 0 0 12px 0; font-size: 30px; line-height: 35px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; ">New booking confirmed! {{$travellerName}} arrives {{date('D jS M',strtotime($bookingInformation->check_in))}}.</h1>
                                                    <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; " class="">Send a message to confirm check-in details or welcome {{$travellerName}}.</p>
                                                    <a href="javascript:void(0)" style="background: #1e1d85;padding: 10px 20px;color: #fff;text-decoration: none;font-weight: normal;font-size: 18px;display: inline-block;margin-top: 5px;border-radius: 4px;">Send {{$name}} a Message</a>
                                                    <table width="100%" border="2" cellspacing="0" cellpadding="0" style="margin-top: 12px; margin-bottom: 12px; margin: 24px 0; color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif;" >
                                                        <tr>
                                                            <td style="padding: 10px;"><a href="{{route('property.listing.details',$property->id)}}"><img src="{{url('public/storage/upload/property_image/main_image/'.$property->property_main_photos)}}" style="width: 100%; display:block; border-radius: 8px;"></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:20px 20px; font-weight:700; font-size: 25px; ">
                                                                <a href="{{route('property.listing.details',$property->id)}}" style="text-decoration: none;color: #222222;line-height: 30px;font-weight: 800;font-size: 22px;margin: 0px;display: block;">{{$property->property_name}}</a>
                                                                {{-- <h5 style="margin: 0px 0px 20px;">Entire home/apt</h5> --}}
                                                            </td>
                                                        </tr> 
                                                        <tr>
                                                            <td>
                                                                <table style="width: 100% !important; margin: 20px 0px;">
                                                                    <tr>
                                                                        <td colspan="2" width="50%" style="padding: 20px 20px;border-right: 1px solid #eeeeee;">
                                                                            <span>Check-in</span>
                                                                            <h2 style="margin: 5px 0px; font-weight: 800;font-size: 20px; color: #000000;">{{date('D, M, jS, Y',strtotime($bookingInformation->check_in))}}</h2>
                                                                            <small style="font-size:18px;">4:00 PM</small>
                                                                        </td>
                                                                        <td colspan="2" width="50%" style="padding: 20px 20px;">
                                                                            <span>Checkout</span>
                                                                            <h2 style="margin: 5px 0px; font-weight: 800;font-size: 20px; color: #000000;">{{date('D, M, jS, Y',strtotime($bookingInformation->check_out))}}</h2>
                                                                            <small style="font-size:18px;">10:00 AM</small>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <table cellspacing="0" cellpadding="0" width="100%">
                                                                <tr>
                                                                  <td align="left">
                                                                    <h2 style="margin: 5px 0px;color: #000000;font-size: 20px;font-weight:800;">Adult</h2>
                                                                    <p style="padding-top:0px; margin-top: 0px; font-size: 18px; ">{{$bookingInformation->total_guest}} adult</p>
                                                                  </td>
                                                                  <td align="center">
                                                                    <h2 style="margin: 5px 0px;color: #000000;font-size: 20px;font-weight:800;">Children</h2>
                                                                    <p style="padding-top:0px; margin-top: 0px; font-size: 18px; ">{{$bookingInformation->total_children}} children</p>
                                                                  </td>
                                                                  <td align="right">
                                                                    <h2 style="margin: 5px 0px;color: #000000;font-size: 20px;font-weight:800;">Guests</h2>
                                                                    <p style="padding-top:0px; margin-top: 0px; font-size: 18px; ">{{$bookingInformation->total_guest + $bookingInformation->total_children}} guest</p>
                                                                  </td>
                                                                </tr>
                                                            </table>
                                                        <tr>
                                                            <td style="padding:20px 20px 10px;">
                                                                <h2 style="margin: 5px 0px;color: #000000;font-size: 20px;font-weight:800;">More details about who’s coming</h2>
                                                                <p style="margin-top: 0px;">Guests will now let you know if they’re bringing children and infants.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 20px;">
                                                                <table style="width: 100% !important;">
                                                                    <tr>
                                                                        <td colspan="2"><h2 style="margin: 5px 0px; font-weight: 800;font-size: 20px; color: #000000;">Guest paid</h2></td>
                                                                    </tr>
                                                                    @php
                                                                        $bookingDetailss = json_decode($bookingInformation->booking_summary, true);
                                                                        ksort($bookingDetailss, 5);
                                                                    @endphp
                                                                    @foreach($bookingDetailss as $key =>$value)
                                                                        <tr>
                                                                            @if ($key =='total_amount')
                                                                                <td style="padding: 10px 0px; text-align: left;font-weight:800;color:#000000;"><h3>Total (USD)</h3></td>
                                                                                <td style="padding: 10px 0px; text-align: right;font-weight:800;color:#000000;"><h3>${{ number_format($value, 2) }}</h3></td>
                                                                            @else
                                                                                <td style="padding: 10px 0px; text-align: left;">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                                                <td style="padding: 10px 0px; text-align: right;">${{ number_format($value, 2) }}</td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td style="padding: 10px 0px; text-align: left;">Guest Paid</td>
                                                                        <td style="padding: 10px 0px; text-align: right;">${{$payableAmount}}</td>
                                                                    </tr>
                                                                    @if ($paymentType =='partial')
                                                                        <tr>
                                                                            <td  style="padding: 10px 0px; text-align: left;color:#ff0000;">Remaining Balance <small><i>Next payment due : {{(date('d-m-Y',strtotime($nextPaymentDate)))}}</i></small></td>
                                                                            <td style="padding: 10px 0px; text-align: right;font-weight:800;color:#ff0000;">${{$bookingInformation->total_amount - $payableAmount}}</td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 20px;">
                                                                <table style="width: 100% !important;">
                                                                    @if ($role=='Owner')
                                                                        <tr>
                                                                            <td colspan="2"><h2 style="margin: 5px 0px; font-weight: 800;font-size: 20px; color: #000000;">Host payout</h2></td>
                                                                        </tr>
                                                                        @php
                                                                            $bookingDetailss = json_decode($bookingInformation->booking_summary, true);
                                                                            ksort($bookingDetailss, 5);
                                                                        @endphp
                                                                        @php
                                                                            $total_amount = 0;
                                                                        @endphp
                                                                        @foreach ($bookingDetailss as $key => $item)
                                                                            @if(!in_array($key,['refundable_damage_deposite','tax','total_amount']))
                                                                                @php
                                                                                    $total_amount += $item;        
                                                                                @endphp
                                                                                {{-- <tr>
                                                                                    <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                                                    <td align="right">${{ number_format($item, 2) }}</td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td style="padding: 10px 0px; text-align: left;">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                                                    <td style="padding: 10px 0px; text-align: right;">${{ number_format($item, 2) }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    
                                                                        {{-- <tr>
                                                                            <td style="padding: 10px 0px; text-align: left;">$521.61 x 7 nights</td>
                                                                            <td style="padding: 10px 0px; text-align: right;">$3,651.30</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding: 10px 0px; text-align: left;">Cleaning fee</td>
                                                                            <td style="padding: 10px 0px; text-align: right;">$300.00</td>
                                                                        </tr>--}}
                                                                        <tr>
                                                                            <td style="padding: 10px 0px; text-align: left;">Service fee</td>
                                                                            <td style="padding: 10px 0px; text-align: right;">-${{$total_amount*8/100}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding:10px 0px;text-align:left;font-weight:800;color:#000000;">Total (USD)</td>
                                                                            <td style="padding:10px 0px;text-align:right;font-weight:800;color:#000000;">${{$total_amount-($total_amount*8/100)}}</td>
                                                                        </tr>
                                                                        {{--<tr>
                                                                            <td colspan="2" style="padding: 10px 0px;width: 100%;border-top: 1px solid #eeeeee;"></td>
                                                                        </tr> --}}
                                                                        <tr>
                                                                            <td colspan="2" style="padding-bottom: 20px;">The money you earn hosting will be sent to you 24 hours after your guest arrives. You can check your upcoming payments in your Transaction History.</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="padding: 10px 0px;width: 100%;border-top: 1px solid #eeeeee;"></td>
                                                                        </tr>
                                                                        {{-- <tr>
                                                                            <td colspan="2" style="padding-bottom: 20px;">Your guest paid $513.67 in Occupancy Taxes. Airbnb remits these taxes on your behalf.</td>
                                                                        </tr> --}}
                                                                        <tr>
                                                                            <td colspan="2" style="padding: 10px 0px;width: 100%;border-top: 1px solid #eeeeee;"></td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <p style="margin-top: 0px;">{{$property->cancelletionPolicies->name}}</p>
                                                                            <p>{{$property->cancelletionPolicies->description}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; " class="">Hope you enjoyed the booking experience and will like the stay too.</p>
                                                    <p style="color: #666666; font-weight: 400; font-size: 17px; line-height: 24px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; margin-bottom: 6px; margin-top: 24px;" class="">Cheers,</p>
                                                    <p style="color: #666666; font-weight: 400; font-size: 17px;  font-family: 'Helvetica neue', Helvetica, arial, sans-serif; margin-bottom: 6px; margin-top: 10px;">My BNB Rentals</p>
                                                </td>
                                            </tr>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 600px; max-width: 600px; font-family: Helvetica, Arial, sans-serif;">
                        <tr>
                            <td style="padding-top: 24px;">
                                <table cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <td style="background-color: #dedede;  width: 100%; font-size: 1px; height: 1px; line-height: 1px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <td style="background-color: #dedede;  width: 100%; font-size: 1px; height: 1px; line-height: 1px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 style="margin-bottom: 10px;">Get the My BNB Rentals app</h4>
                                <ul style="padding: 0px; margin: 0px;">
                                <li style="display: inline-block; vertical-align: text-top; margin-right: 10px;"><a href="javascript:void(0)"><img src="{{asset('email-templates-assets/images/android.png')}}" style="width: 130px;" alt=""></a></li>
                                <li style="display: inline-block; vertical-align: text-top;"><a href="javascript:void(0)"><img src="{{asset('email-templates-assets/images/appstore.png')}}" style="width: 115px;" alt=""></a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>