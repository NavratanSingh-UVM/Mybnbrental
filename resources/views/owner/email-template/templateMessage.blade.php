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
    <body border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#F7F7F7" style="margin:0;">
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
                                                <td class="grid__col" style="font-family: 'Helvetica neue', Helvetica, arial, sans-serif; padding: 20px; ">
                                                    <div style="background: #f7f7f7;padding: 20px;text-align: center;margin-bottom: 20px;    border-radius: 8px;">
                                                        <img src="{{asset('email-templates-assets/images/accountcreated.png')}}" width="120">
                                                    </div>
                                                    <h1 style="color: #404040; font-weight: 800; margin: 0 0 12px 0; font-size: 30px; line-height: 35px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; ">
                                                    Hi,</h1>

                                                    <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; " class="">{{$template->message}},</p>
                                                   
                                                 
                                                    <p style="color: #666666; font-weight: 400; font-size: 17px;  font-family: 'Helvetica neue', Helvetica, arial, sans-serif; margin-bottom: 0px;">My BNB Rentals</p>
                                                </td>
                                            </tr>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                 
                </td>
            </tr>
        </table>
    </body>
</html>