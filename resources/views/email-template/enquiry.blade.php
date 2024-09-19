<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!-- Turn off iOS phone number autodetect -->
  <meta name="format-detection" content="telephone=no">
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
                        <a href="{{route('frontend.index')}}"> <img src="{{asset('frontend-assets/img/logo.png')}}" width="200" height="42" border="0" alt="" style="width:200px; height:42px;background: #1e1d85;padding: 5px;border-radius: 2px;"  /></a>
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
                                        <h2 style="color: #404040; font-weight: 300; margin: 0 0 12px 0; font-size: 20px; line-height: 30px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; ">
                                        Respond to {{$emailContent['traveller_name']}}, inquiry</h2>
                                        <p style="color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif; " class="">{{$emailContent['request_data']['description']}}</p>

                                        <a href="javascript:void(0)" style="background: #1e1d85;padding: 10px 35px;color: #fff;text-decoration: none;font-weight: normal;font-size: 20px;display: inline-block;margin-top: 5px;border-radius: 4px;">Send A Reply</a>
                                        
                                        <table width="100%" border="2" cellspacing="0" cellpadding="0" style="margin-top: 12px; margin-bottom: 12px; margin: 24px 0; color: #666666; font-weight: 400; font-size: 15px; line-height: 21px; font-family: 'Helvetica neue', Helvetica, arial, sans-serif;" >

                                        <tr>
                                            <td style="padding: 10px;">
                                                <a href="{{$emailContent['property_url']}}">
                                                    <img src="{{$emailContent['property_image']}}" style="width: 100%; display:block; border-radius: 8px;">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:20px 20px; font-weight:700; font-size: 25px; ">
                                                <a href="javascript:void(0)" style="text-decoration: none;color: #222222;line-height: 30px;font-weight: 800;font-size: 22px;margin: 0px;display: block;">{{$emailContent['property_name']}}</a>
                                                <h5 style="margin: 0px 0px 20px;">{{$emailContent['property_type']}}</h5>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td >
                                                <table style="width: 100% !important; margin: 20px 0px;">
                                                    <tr>
                                                    <td colspan="2" width="50%" style="padding: 20px 20px;border-right: 1px solid #eeeeee;">
                                                        <span>Check-in</span>
                                                        <h2 style="margin: 5px 0px;">{{date('D,M jS,Y',strtotime($emailContent['request_data']['check_in']))}}</h2>
                                                        <small>4:00 PM</small>
                                                    </td>
                                                    <td colspan="2" width="50%" style="padding: 20px 20px;">
                                                        <span>Checkout</span>
                                                        <h2 style="margin: 5px 0px;">{{date('D,M jS,Y',strtotime($emailContent['request_data']['check_out']))}}</h2>
                                                        <small>10:00 AM</small>
                                                    </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:20px 20px 10px ; font-weight:700; font-size: 18px; ">
                                                <h2 style="margin: 5px 0px;">Guests</h2>
                                                <p style="padding-top:0px; font-weight:700; font-size: 12px; ">{{$emailContent['request_data']['no_of_guest']}} adults</p>
                                            </td>
                                        </tr>        
                                        <tr>
                                            <td style="padding:20px 20px 10px;">
                                                <h2 style="margin: 5px 0px;">You have 24 hours to respond</h2>
                                                <p>A prompt response helps guests finalize their trips. If you don’t respond to {{$emailContent['traveller_name']}} inquiry within 24 hours, it could negatively impact your response rate and your listing’s placement in search.</p>
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