@php
    $toDay = date('Y-m-d');
    $date1 = new DateTime($toDay);
    $date2 = new DateTime($bookingInformation->check_in);
    $interval = $date1->diff($date2);
    $diffDays = $interval->days;
@endphp
@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/travel.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
    <main id="content">
        <section class="pb-4 page-title shadow">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pt-6 lh-15 pb-3">
                        {{-- <li class="breadcrumb-item"><a href="#">< Back</a></li> --}}
                    </ol>
                    <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600">Request to book</h1>
                </nav>
            </div>
        </section>
        <section class="pt-8 pb-11 bg-gray-01">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-8 mb-lg-0 order-1 order-lg-2">
                        <div class="py-5 px-4 border rounded-lg shadow-hover-1 bg-white mb-4" data-animate="fadeInUp">
                            <div class="propertypayment">
                                <h2>Your trip</h2>
                                <ul>
                                    <li>
                                        <strong>Dates</strong>
                                        <span>{{ date('jS M', strtotime($bookingInformation->check_in)) }} –
                                            {{ date('jS M Y', strtotime($bookingInformation->check_out)) }}</span>
                                    </li>
                                    <li>
                                        <strong>Adults</strong>
                                        <span>{{ $bookingInformation->total_guest }} guests</span>
                                    </li>
                                    <li>
                                        <strong>Children</strong>
                                        <span>{{ $bookingInformation->total_children }} children</span>
                                    </li>
                                </ul>
                                 <h2>Insurance</h2>
                                   <!----- Modal---->
                                   <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Insurance">Insurance</button>-->
                                    <div class="modal fade" id="Insurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                       <ul class="nav nav-pills d-none d-md-flex mb-6" role="tablist">
                                                         <!--<li class="nav-item col p-1">-->
                                                         <!--   <button type="button" class="btn btn-primary"   onclick="travel()">Travel Insurance</button>-->
                                                         <!--</li>-->
                                                         <!--<li class="nav-item col p-1">-->
                                                         <!--    <button type="button" class="btn btn-primary"  onclick="damage()">Damage Protection</button>-->
                                                         <!--</li>-->
                                                         <!-- <li class="nav-item col p-1">-->
                                                         <!--    <button type="button" class="btn btn-primary"  onclick="travelDamage()">Travel & Damage Insurance</button>-->
                                                         <!--</li>-->
                                                       </ul>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                 <form name="TestForm" id="travel" method="post">
                                                      @csrf
                                                    <input type="hidden" id="formSubmit" name="xmlrequeststring" value="<purchaserequest>
                                                          <actioncode>NEW</actioncode>
                                                          <aff>PROPTST2</aff>
                                                          <producer>PROPTST2</producer>
                                                          <productclass>G-330CSA</productclass>
                                                          <bookingreservno>0123456789AB</bookingreservno>
                                                          <numinsured>{{$bookingInformation->total_guest+$bookingInformation->total_children}}</numinsured>                      
                                                          <departdate>{{date("Y-m-d", strtotime($bookingInformation->check_in))}}</departdate>
                                                          <returndate>{{date("Y-m-d", strtotime($bookingInformation->check_out))}}</returndate>
                                                          <tripcost> {{floatval(str_replace(',', '',number_format($bookingInformation->total_amount, 2)))}}</tripcost>
                                                        <travelers>
                                                            <traveler>
                                                                <travelerfirstname>Navratan</travelerfirstname>
                                                                <travelerlastname>Singh</travelerlastname>
                                                            </traveler>
                                                        </travelers>
                                                           <address1>26749 Princeton Ave.</address1>
                                                           <city>San Diego</city>
                                                           <state>CA</state>
                                                           <zipcode>92123</zipcode>
                                                           <telephonehome>09997513572</telephonehome>
                                                           <emailaddress>navratansingh0507@gmail.com</emailaddress>
                                                           <printpolconfltr>3</printpolconfltr>
                                                           <price>{{floatval(str_replace(',', '',number_format((($bookingInformation->total_amount)*6.95)/100, 2)))}}</price>
                                                              <payment>
                                                                 <paymentmethod>AR</paymentmethod>
                                                               </payment>
                                                     </purchaserequest>">  
                                                     <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                </form> 
                                                 {{-- <form name="TestForm" id="damage" action="https://staging.csatravelprotection.com/ws/policyrequest" method="POST" style="visibility:hidden">
                                                    <input type="hidden" name="xmlrequeststring" value='<xml version="1.0" encoding="UTF-8">
                                                     <purchaserequest>
                                                          <actioncode>NEW</actioncode>
                                                          <aff>MYBNBREN</aff>
                                                          <producer>MYBNBREN</producer>
                                                          <productclass>G-20VRD</productclass>
                                                          <bookingreservno>0123456789AB</bookingreservno>
                                                          <numinsured>{{$bookingInformation->total_guest+$bookingInformation->total_children}}</numinsured>                      
                                                          <departdate>{{date("Y-m-d", strtotime($bookingInformation->check_in))}}</departdate>
                                                          <returndate>{{date("Y-m-d", strtotime($bookingInformation->check_out))}}</returndate>
                                                          <tripcost> {{floatval(str_replace(',', '',number_format($bookingInformation->total_amount, 2)))}}</tripcost>
                                                        <travelers>
                                                            <traveler>
                                                                <travelerfirstname>George</travelerfirstname>
                                                                <travelerlastname>Smith</travelerlastname>
                                                            </traveler>
                                                        </travelers>
                                                           <address1>26749 Princeton Ave.</address1>
                                                           <city>San Diego</city>
                                                           <state>CA</state>
                                                           <zipcode>92123</zipcode>
                                                           <telephonehome>8585551212</telephonehome>
                                                           <emailaddress>georgesmith@test.com</emailaddress>
                                                           <printpolconfltr>3</printpolconfltr>
                                                           <price>834.00</price>
                                                              <payment>
                                                                 <paymentmethod>AR</paymentmethod>
                                                               </payment>
                                                     </purchaserequest>"> 
                                                     <input type="submit" class="btn btn-primary" name="submit" value="Test2...">
                                                </form>
                                                 <form name="TestForm" id="travelDamage" action="https://staging.csatravelprotection.com/ws/policyrequest" method="POST" style="visibility:hidden">
                                                    <input type="hidden" name="xmlrequeststring" value='<xml version="1.0" encoding="UTF-8">
                                                      <purchaserequest>
                                                          <actioncode>NEW</actioncode>
                                                          <aff>MYBNBREN</aff>
                                                          <producer>MYBNBREN</producer>
                                                          <productclass>G-20VRD</productclass>
                                                          <bookingreservno>0123456789AB</bookingreservno>
                                                          <numinsured>{{$bookingInformation->total_guest+$bookingInformation->total_children}}</numinsured>                      
                                                          <departdate>{{date("Y-m-d", strtotime($bookingInformation->check_in))}}</departdate>
                                                          <returndate>{{date("Y-m-d", strtotime($bookingInformation->check_out))}}</returndate>
                                                          <tripcost> {{floatval(str_replace(',', '',number_format($bookingInformation->total_amount, 2)))}}</tripcost>
                                                        <travelers>
                                                            <traveler>
                                                                <travelerfirstname>George</travelerfirstname>
                                                                <travelerlastname>Smith</travelerlastname>
                                                            </traveler>
                                                        </travelers>
                                                           <address1>26749 Princeton Ave.</address1>
                                                           <city>San Diego</city>
                                                           <state>CA</state>
                                                           <zipcode>92123</zipcode>
                                                           <telephonehome>8585551212</telephonehome>
                                                           <emailaddress>georgesmith@test.com</emailaddress>
                                                           <printpolconfltr>3</printpolconfltr>
                                                           <price>834.00</price>
                                                              <payment>
                                                                 <paymentmethod>AR</paymentmethod>
                                                               </payment>
                                                     </purchaserequest>'> 
                                                     <input type="submit" class="btn btn-primary" name="submit" value="Test3...">
                                                </form>               --}}
                                            </div>
                                        </div>
                                    </div>
                                   <!----- End Modal --->
                                  <div class="form-group">
							        <input  type="radio" name="insurance_type" value="travel" id="travelInsurance"> Travel Insurance
                                    <input  type="radio" name="insurance_type" value="damage" id="damageInsurance"> Damage Protection
							       <input  type="radio" name="insurance_type" value="both" id="both"> Travel & damage insurance
                                 </div> 
                                <h2>Choose how to pay</h2>
                                <div class="pricebox">
                                    <div class="priceboxone">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-lg-8">
                                                <strong>Pay in full</strong>
                                                <span id="Total_amount">Pay the total (${{ number_format($bookingInformation->total_amount, 2) }}).</span>
                                            </div>
                                            <div class="col-lg-4 text-center">
                                                <input type="radio" name="payment_type" value="full" checked>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                         $halfPayment = 0;
                                    @endphp
                                    @if ($diffDays >= 30)
                                        <div class="priceboxone border-0">
                                            <div class="row d-flex align-items-center justify-content-center">
                                                <div class="col-lg-8" id="duePayment">
                                                    <strong>Pay part now, part later</strong>
                                                    @php
                                                        $halfPayment = ($bookingInformation->total_amount * 50) / 100;
                                                    @endphp
                                                    <span>${{ number_format($halfPayment??0, 2) }} due today,${{ number_format($bookingInformation->total_amount - $halfPayment??0, 2) }} on {{ date('jS M Y', strtotime('-30 days', strtotime($bookingInformation->check_in))) }}. No extra fees.</span>
                                                </div>
                                                <div class="col-lg-4 text-center">
                                                    <input type="radio" name="payment_type" value="partial">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <hr>
                                <h2>Pay with</h2>
                                <form id="makePayment">
                                    <div class="form-group">
                                        <label for="key-word" class="sr-only">Card Number</label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-none" id="card-number" name="card_number" placeholder="Card Number...">
                                        <span class="card_number text-danger"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label for="key-word" class="sr-only">Expiry</label>
                                            <input type="text" class="form-control form-control-lg border-0 shadow-none" name="expiry_month" placeholder="MM/YYYY">
                                            <span class="expiry_month text-danger"></span>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="key-word" class="sr-only">CVV</label>
                                            <input type="text" class="form-control form-control-lg border-0 shadow-none" name="cvv_pin" placeholder="CVV">
                                            <span class="cvv_pin text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="key-word" class="sr-only">Card Holder Name</label>
                                        <input type="text" class="form-control form-control-lg border-0 shadow-none" id="key-word" name="card_holder_name" placeholder="Card Holder Name">
                                        <span class="cvv_pin text-danger"></span>
                                    </div>
                                    <h2>Cancellation policy</h2>
                                    <p>{{ $bookingInformation->property->cancelletionPolicies->description }}</p>
                                    <p>{{ $bookingInformation->property->cancelletionPolicies->note }}</p>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none mt-4">Confirm and pay</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 order-2 order-lg-2 primary-sidebar sidebar-sticky" id="sidebar">
                        <div class="primary-sidebar-inner">
                            <div class="card mb-4">
                                <div class="card-body px-6 py-4">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-md-6">
											<img src="{{ url('public/storage/upload/property_image/main_image/' . $bookingInformation->property->property_main_photos) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="property-detail">
                                                {{-- <small>Room in nature lodge</small> --}}
                                                <strong>{{ $bookingInformation->property->property_name }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h2>Price details</h2>
                                    @php
                                        $bookingDetails = json_decode($bookingInformation->booking_summary, true);
                                        ksort($bookingDetails, 5);
                                         $i=1;
                                    @endphp
                                    
                                    @foreach ($bookingDetails as $key => $booking)
                                        <div class="row d-flex align-items-center justify-content-end" id='PriceDetails{{$i}}'>
                                            <div class="col-lg-6">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                                            <div class="col-lg-6 text-right">${{ number_format($booking, 2) }}</div>
                                        </div>
                                       @php 
                                     $i++;
                                    @endphp
                                    @endforeach
                                   
                                    <div class="due-price-section d-none">
                                        <hr>
                                        <div class="row d-flex align-items-center justify-content-end">
                                            <div class="col-lg-6"><strong>Due now</strong></div>
                                            <div class="col-lg-6 text-right" id="dueNow"><strong>${{ number_format($halfPayment??0, 2) }} </strong></div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-end">
                                            <div class="col-lg-6">{{ date('jS M Y', strtotime('-30 days', strtotime($bookingInformation->check_in))) }}(Next Payment Date)</div>
                                            <div class="col-lg-6 text-right" id="nextPayment">${{ number_format($bookingInformation->total_amount - $halfPayment??0, 2) }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('js')
{{-- <script></script> --}}
<script>
    "use strict"
    $("input[name=payment_type]").on("click",function(){
       if($(this).val()=='partial'){
            $(".due-price-section").removeClass("d-none");
       }else{
            $(".due-price-section").addClass("d-none");
       }
    });
     $("input[name=insurance_type]").on("click",function(){
     var bookingAmount = "<?php Print($bookingInformation->total_amount); ?>";
       if($(this).val()=='travel'){
            var InsuranceAmount=(bookingAmount*6.95)/100;
            var Insurance_amount=InsuranceAmount.toFixed(2);
            let  Total_amount= parseFloat(bookingAmount) + parseFloat(Insurance_amount);
               let newEle =`<div id="PriceDetails2"><div class="row d-flex align-items-center justify-content-end" ><div class="col-lg-6">Travel Insurance</div><div class="col-lg-6 text-right">$${Insurance_amount}</div></div>
                <div class="row d-flex align-items-center justify-content-end"><div class="col-lg-6">Total amount</div><div class="col-lg-6 text-right">$${Total_amount}</div></div></div>`;
              document.getElementById('PriceDetails2').outerHTML = newEle;
              // pay in full
               let newElement=`<span id="Total_amount">Pay the total ($${ Total_amount }).</span>`;
               document.getElementById('Total_amount').outerHTML = newElement;
                let duePayment=`<div class="col-lg-8" id="duePayment">
                   <strong>Pay part now, part later</strong>$${ (Total_amount/2).toFixed(2) }
                    <span>$${ (Total_amount/2).toFixed(2) } due today,$${(Total_amount - Total_amount/2).toFixed(2)} on {{ date('jS M Y', strtotime('-30 days', strtotime($bookingInformation->check_in))) }}. No extra fees.</span></div>`;
               document.getElementById('duePayment').outerHTML = duePayment;
       }else if($(this).val()=='damage'){
            var  Insurance_amount=55;
            let  Total_amount= (parseFloat(bookingAmount) + parseFloat(Insurance_amount)).toFixed(2);
            let  newEle = `<div id="PriceDetails2"><div class="row d-flex align-items-center justify-content-end" id="PriceDetails2"><div class="col-lg-6">Damage Insurance</div><div class="col-lg-6 text-right">$${Insurance_amount}</div></div>
                         <div class="row d-flex align-items-center justify-content-end"><div class="col-lg-6">Total amount</div><div class="col-lg-6 text-right">$${Total_amount}</div></div>`;
                 document.getElementById('PriceDetails2').outerHTML = newEle;
                 // pay in full
                let newElement=`<span id="Total_amount">Pay the total ($${ Total_amount }).</span>`;
                    document.getElementById('Total_amount').outerHTML = newElement;
                let duePayment=`<div class="col-lg-8" id="duePayment"><strong>Pay part now, part later</strong>$${ (Total_amount/2).toFixed(2) }
                            <span>$${ (Total_amount/2).toFixed(2) } due today,$${(Total_amount - Total_amount/2).toFixed(2)} on {{ date('jS M Y', strtotime('-30 days', strtotime($bookingInformation->check_in))) }}. No extra fees.</span></div>`;
                document.getElementById('duePayment').outerHTML = duePayment;
      } else if($(this).val()=='both'){
            var InsuranceAmount=(bookingAmount*6.95)/100+55;
            var  Insurance_amount=InsuranceAmount.toFixed(2);
            let  Total_amount= parseFloat(bookingAmount) + parseFloat(Insurance_amount);
            let  newEle =`<div id="PriceDetails2"><div class="row d-flex align-items-center justify-content-end" ><div class="col-lg-6">Travel & damage Insurance</div><div class="col-lg-6 text-right">$${Insurance_amount}</div></div>
                       <div class="row d-flex align-items-center justify-content-end"><div class="col-lg-6">Total amount</div><div class="col-lg-6 text-right">$${Total_amount}</div></div></div>`;
                document.getElementById('PriceDetails2').outerHTML = newEle;
                 // pay in full
                let newElement=`<span id="Total_amount">Pay the total ($${ Total_amount }).</span>`;
                    document.getElementById('Total_amount').outerHTML = newElement;
                let duePayment=`<div class="col-lg-8" id="duePayment"><strong>Pay part now, part later</strong>$${ (Total_amount/2).toFixed(2) }
                    <span>$${ (Total_amount/2).toFixed(2) } due today,$${(Total_amount - Total_amount/2).toFixed(2)} on {{ date('jS M Y', strtotime('-30 days', strtotime($bookingInformation->check_in))) }}. No extra fees.</span></div>`;
               document.getElementById('duePayment').outerHTML = duePayment;
      }
    });

    makePayment.onsubmit = async(e)=>{
        showLoader();
        e.preventDefault();
        var formData = new FormData(makePayment);
       var Total_amount = document.getElementById("Total_amount").innerText;
       var insurance_amount = document.getElementById("PriceDetails2").innerText;
       //var duePayment = document.getElementById("duePayment").innerText;

        formData.append("payment_type",$("input[name=payment_type]:checked").val());
        formData.append("insurance_type",$("input[name=insurance_type]:checked").val());
         formData.append("insurance_amount",insurance_amount);
        formData.append("Total_amount",Total_amount);
        //formData.append("Due_payment",duePayment);
       const response = await fetch('{{route("make.paymnet")}}',{
            method:"POST",
           body:formData ,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           },
       });
        const result = await response.json();
        if(response.status==403){
            hideLoader();
            toastr.error(response.statusText);
        }
        if(result.status==500){
            hideLoader();
           toastr.error(result.msg);
            return false;
        }
       if(response.status==401){
            hideLoader();
       }
       if(response.status==500 && result.status) {
            hideLoader();
            toastr.error(response.statusText);
        }

        if(response.status==422){
            hideLoader();
            $("#makePayment").find("span").text('');
            for(let index in result.errors){
                $("."+index).text(result.errors[index]);
            }
        }
        if(response.status ==200){
             toastr.success()
           window.setTimeout(() => {
                hideLoader();
                window.location.href = result.url; 
           }, 2000);
        }
        if(result.status==false){
         toastr.success()
            window.setTimeout(() => {
               hideLoader();
               window.location.href = result.url; 
           }, 2000);
       }
    }
</script>
<script>
     $(document).ready(function() {
       $('#Insurance').on('shown.bs.modal', function () {
          $('.modal-backdrop').remove(); 
        });
      });
      function travel() {
         document.getElementById("travel").style.visibility = "visible";
         document.getElementById("damage").style.visibility = "hidden";
         document.getElementById("travelDamage").style.visibility = "hidden";
      }
       function damage() {
         document.getElementById("travel").style.visibility = "hidden";
         document.getElementById("damage").style.visibility = "visible";
         document.getElementById("travelDamage").style.visibility = "hidden";
      }
       function travelDamage() {
         document.getElementById("travel").style.visibility = "hidden";
         document.getElementById("damage").style.visibility = "hidden";
         document.getElementById("travelDamage").style.visibility = "visible";
      }
  $("#travel").submit(function(e) {
        e.preventDefault();
    var FormData = document.getElementById("formSubmit").value;
   // console.log('hello',FormData);
       // var form = $(this);
       //  console.log('hello',FormData);
          //var actionUrl = form.attr('action');
           // let headers = new Headers();
          // headers.append('Content-Type', 'application/json');
         //  headers.append('Accept', 'application/json');
        //   headers.append('Origin','http://localhost:8000');
          
           
            
       $.ajax({
            type: 'post',
            url: "https://staging.csatravelprotection.com/ws/policyrequest",
            data: FormData, // serializes the form's elements.
            dataType: "xml",
            cache: false, 
             headers: {
      'Access-Control-Allow-Origin': 'https://staging.csatravelprotection.com/ws/policyrequest'
    },
           success: function (xml) {
          
                console.log(xml,'Submission was successful.');
                
            },
            error: function (xml) {
                console.log('An error occurred.',xml);
          
            },
       });

          // action="https://staging.csatravelprotection.com/ws/policyrequest" method="POST"
    });
</script>
@endpush
