<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> Partner Listing </title>
        <meta name="robots" content="noindex,nofollow" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
        <style type="text/css">
            @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);
            body { 
                margin: 0; 
                padding: 0; 
                background: #e1e1e1; 
            }
            div, p, a, li, td {
                -webkit-text-size-adjust: none; 
            }
            .ReadMsgBody { 
                width: 100%; 
                background-color: #ffffff; 
            }
            .ExternalClass { 
                width: 100%; 
                background-color: #ffffff; 
            }
            body {
                width: 100%; 
                height: 100%; 
                background-color: #e1e1e1; 
                margin: 0;
                padding: 0;
                 -webkit-font-smoothing: antialiased; 
            }
            html { 
                width: 100%; 
            }
            p { 
                padding: 0 !important; 
                margin-top: 0 !important; 
                margin-right: 0 !important; 
                margin-bottom: 0 !important; 
                margin-left: 0 !important; 
            }
            .visibleMobile { 
                display: none; 
            }
            .hiddenMobile { 
                display: block; 
            }
            @media only screen and (max-width: 600px) {
                body { 
                    width: auto !important; 
                }
                table[class=fullTable] { 
                    width: 96% !important; 
                    clear: both; 
                }
                table[class=fullPadding] { 
                    width: 85% !important; 
                    clear: both; 
                }
                table[class=col] { 
                    width: 45% !important; 
                }
                .erase { display: none; }
            }

            @media only screen and (max-width: 420px) {
                table[class=fullTable] { 
                    width: 100% !important; 
                    clear: both; 
                }
                table[class=fullPadding] { 
                    width: 85% !important; 
                    clear: both; 
                }
                table[class=col] { 
                    width: 100% !important; 
                    clear: both; 
                }
                table[class=col] td { 
                    text-align: left !important; 
                }
                .erase { 
                    display: none; 
                    font-size: 0; 
                    max-height: 0; 
                    line-height: 0;
                     padding: 0; 
                }
                .visibleMobile { 
                    display: block !important; 
                }
                .hiddenMobile { 
                    display: none !important; 
                }
            }
        </style>
    </head>
    <body border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7" style="margin:0;">
        <!-- Header -->
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td>
                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                        <tr class="hiddenMobile">
                            <td height="40"></td>
                        </tr>
                        <tr class="visibleMobile">
                            <td height="30"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="550" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" style="padding:3px 2px 0px;background:#1e1d85;border-radius:4px;"> 
                                                                <img src="{{asset('frontend-assets/img/logo.png')}}" width="200" height="42" alt="logo" border="0" />
                                                            </td>
                                                        </tr>
                                                        <tr class="hiddenMobile">
                                                            <td height="40"></td>
                                                        </tr>
                                                        <tr class="visibleMobile">
                                                            <td height="20"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 16px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 22px; vertical-align: top; text-align: left;">
                                                                Hello, {{auth()->user()->name}}.
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellpadding="0" width="100%" >
                                                    <div style="font-size: 15px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 22px; vertical-align: top; text-align: left;margin-top: 20px;">Thank you for upgrading to Treble Premium. Your subscription information has been added below. If you did not initiate this subscription, please reach out to us at <a href="#">support@mybnbrentals.com</a></div>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellpadding="0" border="0" width="100%" class="col" style="margin-top: 20px;font-family: 'Open Sans', sans-serif;font-size: 14px;">
                                                    <thead style="background: #1e1d85;color: #ffffff;">
                                                        <tr>
                                                        <th style="padding: 10px;font-weight: 200;" width="130">Subscription Fees</th>
                                                        <th style="padding: 10px;font-weight: 200;">No of Listing</th>
                                                        <th style="padding: 10px;font-weight: 200;">No Of Year</th>
                                                        <th style="padding: 10px;font-weight: 200;">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        <td align="center" style="padding: 10px; background: #eeeeee;">${{env('PARTNER_LISTING_PRICE')}}</td>
                                                        <td align="center" style="padding: 10px; background: #eeeeee;">{{$content->no_of_listing}}</td>
                                                        <td align="center" style="padding: 10px; background: #eeeeee;">{{$content->no_year}} Year</td>
                                                        <td align="center" style="padding: 10px; background: #eeeeee;">${{$content->total_amount}}/-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellpadding="0" width="100%" >
                                                    <div style="font-size: 15px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 22px; vertical-align: top; text-align: left;margin-top: 20px;">Your subscription will be auto-renewed before the expiry date. However, if you wish to discontinue, please remove your billing information by logging in to your account. <br><br>
                                                        Visit our FAQs page to know more about different subscription levels.
                                                    </div>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellpadding="0" width="100%" style="border-top: 1px solid #eeeeee; padding-top: 10px; margin-top: 20px;" >
                                                    <tr>
                                                        <td>
                                                            <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Open Sans', sans-serif; " class="">Hope you enjoyed the booking experience and will like the stay too.</p>
                                                            <br>
                                                            <p style="color: #666666; font-weight: 400; font-size: 17px; line-height: 24px; font-family: 'Open Sans', sans-serif; margin-bottom: 6px; margin-top: 24px;" class="">Cheers,</p>
                                                            <p style="color: #666666; font-weight: 400; font-size: 17px;  font-family: 'Open Sans', sans-serif; margin-bottom: 6px; margin-top: 10px;">My BNB Rentals</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellpadding="0" width="100%" style="border-top: 1px solid #eeeeee;  margin-top: 20px;">
                                                <tr>
                                                    <td>
                                                    <h4 style="margin-bottom: 10px;font-family: 'Open Sans', sans-serif;font-size: 14px; font-weight: 400;color: #666666;">Get the My BNB Rentals app</h4>
                                                    <ul style="padding: 0px; margin: 0px;">
                                                        <li style="display: inline-block; vertical-align: text-top; margin-right: 10px;"><a href="javascript:void(0)"><img src="{{asset('email-templates-assets/images/android.png')}}" style="width: 130px;" alt=""></a></li>
                                                        <li style="display: inline-block; vertical-align: text-top;"><a href="javascript:void(0)"><img src="{{asset('email-templates-assets/images/appstore.png')}}" style="width: 115px;" alt=""></a></li>
                                                    </ul>
                                                    </td>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- /Header -->
    </body>
</html>