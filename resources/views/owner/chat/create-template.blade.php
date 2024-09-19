@extends('owner.layouts.master')
@push('css')
<link rel="stylesheet" href="{{asset('traveller-assets/css/chat.css')}}" rel="text/css">
  <script src="{{asset('assets/custom/multiple_selected.js')}}"></script>
@endpush
@section('content')
 <main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
      
            <h2 class="mb-0 text-heading fs-22 lh-15">@if(!empty($templateMessages)) Update Tempate @else Create Template @endif</h2>
        </div>
          <form id="createTemplate">
            @csrf
            <div class="row mb-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <input type="hidden" name="user_id" value="{{$id}}" id="user_id">
                                        <input type="hidden" name="template_msg_id" value="{{$templateMessages->template_msg_id ?? '' }}" id="template_msg_id">
                                        <label for="template_name" class="text-heading">Template Name</label>
                                        <input type="text" class="form-control form-control-lg" id="template_name" name="template_name" value="{{$templateMessages->template_name ?? '' }}">
                                        <span class="template_name text-danger"></span>
                                    </div>
                                </div>
                                  <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="message" class="text-heading">Message</label>
                                        <textarea class="form-control border-0" rows="4" id="message" name="message" placeholder="Enter your Notes" >{{$templateMessages->message ?? '' }}</textarea>
                                        <span class="message text-danger"></span>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                  <div class="form-group">
                                   <label for="property_listing">Property listings</label>
                                       <select name="property_listing_id[]" id="property_listing" multiple multiple-search="true" multiple-select-max-items="10" multiple data-multi-select>
                                         @foreach ($propertListing as $item)
                                             <option value="{{$item->id}}">
                                             {{$item->property_name}}</option>
                                        @endforeach
                                      </select>
                                         <span class="property_listing text-danger"></span>
                                  </div>
                             </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                   <label for="scheduling">Scheduling</label>
                                     <select name="scheduling"  id="scheduling" onchange="schedulingSelect(this.value)" class="form-control form-control-lg">
                                        <option value=>Action</option> 
                                         <option value="1"@if (!empty($templateMessages)) @selected("1" ===$templateMessages->scheduling) @endif>Booking confirmed </option>
                                        <option value="2"@if (!empty($templateMessages)) @selected("2" ===$templateMessages->scheduling) @endif>Check-in</option>
                                        <option value="3"@if (!empty($templateMessages)) @selected("3" ===$templateMessages->scheduling) @endif>Check-out</option>
                                       
                                      </select>
                                         <span class="scheduling text-danger"></span>
                                  </div>
                             </div>
                              <div class="col-md-6" id="booking_confirmed" style="display:none">
                                 <div class="form-group">
                                     <select name="booking_confirmed"  id="booking_confirmed"  class="form-control form-control-lg">
                                        <option value=>When to send</option>
                                        <option value=>Immediately after</option>
                                        <option value="5 minute after"@if (!empty($templateMessages)) @selected("5 minute after" ===$templateMessages->day) @endif>5  minutes after</option>
                                        <option value="10 minute after"@if (!empty($templateMessages)) @selected("10 minute after" ===$templateMessages->day) @endif>10 minutes after</option>
                                        <option value="15 minutes after"@if (!empty($templateMessages)) @selected("15 minute after" ===$templateMessages->day) @endif>15 minutes after</option>
                                        <option value="30 minutes after"@if (!empty($templateMessages)) @selected("30 minute after" ===$templateMessages->day) @endif>30 minutes after</option>
                                        <option value="1 hours after"@if (!empty($templateMessages)) @selected("1 hours after" ===$templateMessages->day) @endif> 1  hour after</option>
                                        <option value="2 hours after"@if (!empty($templateMessages)) @selected("2 hours after" ===$templateMessages->day) @endif> 2  hours after</option>
                                        <option value="4 hours after"@if (!empty($templateMessages)) @selected("4 hours after" ===$templateMessages->day) @endif> 4  hours after</option>
                                        <option value="8 hours after"@if (!empty($templateMessages)) @selected("8 hours after" ===$templateMessages->day) @endif> 8  hours after</option>
                                        <option value="16 hours after"@if (!empty($templateMessages)) @selected("16 hours after" ===$templateMessages->day) @endif> 16 hours after</option>
                                        <option value="24 hours after"@if (!empty($templateMessages)) @selected("24 hours after" ===$templateMessages->day) @endif> 24 hours after</option>
                                     </select>
                                 </div>
                              </div>
                              <div class="col-md-6" id="check_in" style="display:none">
                                 <div class="form-group">
                                     <select name="check_In_day"  id="check_In_day"  class="form-control form-control-lg">
                                        <option value=>Day</option>
                                        <option value="14 days before"@if (!empty($templateMessages)) @selected("14 days before" ===$templateMessages->day) @endif>14 days before</option>
                                        <option value="13 days before"@if (!empty($templateMessages)) @selected("13 days before" ===$templateMessages->day) @endif>13 days before</option>
                                        <option value="12 days before"@if (!empty($templateMessages)) @selected("12 days before" ===$templateMessages->day) @endif>12 days before</option>
                                        <option value="11 days before"@if (!empty($templateMessages)) @selected("11 days before" ===$templateMessages->day) @endif>11 days before</option>
                                        <option value="10 days before"@if (!empty($templateMessages)) @selected("10 days before" ===$templateMessages->day) @endif>10 days before</option>
                                        <option value="9 days before"@if (!empty($templateMessages)) @selected("9 days before" ===$templateMessages->day) @endif> 9 days before</option>
                                        <option value="8 days before"@if (!empty($templateMessages)) @selected("8 days before" ===$templateMessages->day) @endif> 8 days before</option>
                                        <option value="7 days before"@if (!empty($templateMessages)) @selected("7 days before" ===$templateMessages->day) @endif> 7 days before</option>
                                        <option value="6 days before"@if (!empty($templateMessages)) @selected("6 days before" ===$templateMessages->day) @endif> 6 days before</option>
                                        <option value="5 days before"@if (!empty($templateMessages)) @selected("5 days before" ===$templateMessages->day) @endif> 5 days before</option>
                                        <option value="4 days before"@if (!empty($templateMessages)) @selected("4 days before" ===$templateMessages->day) @endif> 4 days before</option>
                                        <option value="3 days before"@if (!empty($templateMessages)) @selected("3 days before" ===$templateMessages->day) @endif> 3 days before</option>
                                        <option value="2 days before"@if (!empty($templateMessages)) @selected("2 days before" ===$templateMessages->day) @endif> 2 days before</option>
                                        <option value="1 day before"@if (!empty($templateMessages)) @selected("1 day before" ===$templateMessages->day) @endif> 1 day before</option>
                                        <option value="0 day of"@if (!empty($templateMessages)) @selected("0 day before" ===$templateMessages->day) @endif>  Day of</option>
                                        <option value="1 day after"@if (!empty($templateMessages)) @selected("1 day after" ===$templateMessages->day) @endif>1 day after</option>
                                        <option value="2 days after"@if (!empty($templateMessages)) @selected("2 days after" ===$templateMessages->day) @endif>2 days after</option>
                                        <option value="3 days after"@if (!empty($templateMessages)) @selected("3 days after" ===$templateMessages->day) @endif>3 days after</option>
                                        <option value="4 days after"@if (!empty($templateMessages)) @selected("4 days after" ===$templateMessages->day) @endif>4 days after</option>
                                        <option value="5 days after"@if (!empty($templateMessages)) @selected("5 days after" ===$templateMessages->day) @endif>5 days after</option>
                                        <option value="6 days after"@if (!empty($templateMessages)) @selected("6 days after" ===$templateMessages->day) @endif>6 days after</option>
                                        <option value="7 days after"@if (!empty($templateMessages)) @selected("7 days after" ===$templateMessages->day) @endif>7 days after</option>
                                        <option value="8 days after"@if (!empty($templateMessages)) @selected("8 days after" ===$templateMessages->day) @endif>8 days after</option>
                                        <option value="9 days after"@if (!empty($templateMessages)) @selected("9 days after" ===$templateMessages->day) @endif>9 days after</option>
                                        <option value="10 days after"@if (!empty($templateMessages)) @selected("10 days after" ===$templateMessages->day) @endif>10 days after</option>
                                        <option value="11 days after"@if (!empty($templateMessages)) @selected("11 days after" ===$templateMessages->day) @endif>11 days after</option>
                                        <option value="12 days after"@if (!empty($templateMessages)) @selected("12 days after" ===$templateMessages->day) @endif>12 days after</option>
                                        <option value="13 days after"@if (!empty($templateMessages)) @selected("13 days after" ===$templateMessages->day) @endif>13 days after</option>
                                        <option value="14 days after"@if (!empty($templateMessages)) @selected("14 days after" ===$templateMessages->day) @endif>14 days after</option>  
                                     </select>
                                 </div>
                                   <div class="form-group">
                                     <select name="check_In_time"  id="check_In_time"  class="form-control form-control-lg">
                                        <option value=>Time</option>
                                        <option value="12 Am"@if (!empty($templateMessages)) @selected("12 Am" ===$templateMessages->time) @endif>12:00 AM </option>
                                        <option value="11 Am"@if (!empty($templateMessages)) @selected("11 Am" ===$templateMessages->time) @endif>11:00 AM </option>
                                        <option value="10 Am"@if (!empty($templateMessages)) @selected("10 Am" ===$templateMessages->time) @endif>10:00 AM </option>
                                        <option value="9 Am"@if (!empty($templateMessages)) @selected("9 Am" ===$templateMessages->time) @endif> 9:00 AM </option>
                                        <option value="8 Am"@if (!empty($templateMessages)) @selected("8 Am" ===$templateMessages->time) @endif> 8:00 AM </option>
                                        <option value="7 Am"@if (!empty($templateMessages)) @selected("7 Am" ===$templateMessages->time) @endif> 7:00 AM </option>
                                        <option value="6 Am"@if (!empty($templateMessages)) @selected("6 Am" ===$templateMessages->time) @endif> 6:00 AM </option>
                                        <option value="5 Am"@if (!empty($templateMessages)) @selected("5 Am" ===$templateMessages->time) @endif> 5:00 AM </option>
                                        <option value="4 Am"@if (!empty($templateMessages)) @selected("4 Am" ===$templateMessages->time) @endif> 4:00 AM </option>
                                        <option value="3 Am"@if (!empty($templateMessages)) @selected("3 Am" ===$templateMessages->time) @endif> 3:00 AM </option>
                                        <option value="2 Am"@if (!empty($templateMessages)) @selected("2 Am" ===$templateMessages->time) @endif> 2:00 AM </option>
                                        <option value="1 Am"@if (!empty($templateMessages)) @selected("1 Am" ===$templateMessages->time) @endif> 1:00 AM </option>
                                        <option value="1 pm"@if (!empty($templateMessages)) @selected("1 pm" ===$templateMessages->time) @endif>1:00 PM </option>
                                        <option value="2 pm"@if (!empty($templateMessages)) @selected("2 pm" ===$templateMessages->time) @endif>2:00 PM </option>
                                        <option value="3 pm"@if (!empty($templateMessages)) @selected("3 pm" ===$templateMessages->time) @endif>3:00 PM </option>
                                        <option value="4 pm"@if (!empty($templateMessages)) @selected("4 pm" ===$templateMessages->time) @endif>4:00 PM </option>
                                        <option value="5 pm"@if (!empty($templateMessages)) @selected("5 pm" ===$templateMessages->time) @endif>5:00 PM </option>
                                        <option value="6 pm"@if (!empty($templateMessages)) @selected("6 pm" ===$templateMessages->time) @endif>6:00 PM </option>
                                        <option value="7 pm"@if (!empty($templateMessages)) @selected("7 pm" ===$templateMessages->time) @endif>7:00 PM </option>
                                        <option value="8 pm"@if (!empty($templateMessages)) @selected("8 pm" ===$templateMessages->time) @endif>8:00 PM </option>
                                        <option value="9 pm"@if (!empty($templateMessages)) @selected("9 pm" ===$templateMessages->time) @endif>9:00 PM </option>
                                        <option value="10 pm"@if (!empty($templateMessages)) @selected("10 pm" ===$templateMessages->time) @endif>10:00 PM </option>
                                        <option value="11 pm"@if (!empty($templateMessages)) @selected("11 pm" ===$templateMessages->time) @endif>11:00 PM </option> 
                                     </select>
                                 </div>
                              </div>
                               <div class="col-md-6" id="check_out" style="display:none">
                                 <div class="form-group">
                                     <select name="check_out_day"  id="check_out_day"  class="form-control form-control-lg">
                                        <option value=>Day</option>
                                       <option value="14 days before"@if (!empty($templateMessages)) @selected("14 days before" ===$templateMessages->day) @endif>14 days before</option>
                                        <option value="13 days before"@if (!empty($templateMessages)) @selected("13 days before" ===$templateMessages->day) @endif>13 days before</option>
                                        <option value="12 days before"@if (!empty($templateMessages)) @selected("12 days before" ===$templateMessages->day) @endif>12 days before</option>
                                        <option value="11 days before"@if (!empty($templateMessages)) @selected("11 days before" ===$templateMessages->day) @endif>11 days before</option>
                                        <option value="10 days before"@if (!empty($templateMessages)) @selected("10 days before" ===$templateMessages->day) @endif>10 days before</option>
                                        <option value="9 days before"@if (!empty($templateMessages)) @selected("9 days before" ===$templateMessages->day) @endif> 9 days before</option>
                                        <option value="8 days before"@if (!empty($templateMessages)) @selected("8 days before" ===$templateMessages->day) @endif> 8 days before</option>
                                        <option value="7 days before"@if (!empty($templateMessages)) @selected("7 days before" ===$templateMessages->day) @endif> 7 days before</option>
                                        <option value="6 days before"@if (!empty($templateMessages)) @selected("6 days before" ===$templateMessages->day) @endif> 6 days before</option>
                                        <option value="5 days before"@if (!empty($templateMessages)) @selected("5 days before" ===$templateMessages->day) @endif> 5 days before</option>
                                        <option value="4 days before"@if (!empty($templateMessages)) @selected("4 days before" ===$templateMessages->day) @endif> 4 days before</option>
                                        <option value="3 days before"@if (!empty($templateMessages)) @selected("3 days before" ===$templateMessages->day) @endif> 3 days before</option>
                                        <option value="2 days before"@if (!empty($templateMessages)) @selected("2 days before" ===$templateMessages->day) @endif> 2 days before</option>
                                        <option value="1 day before"@if (!empty($templateMessages)) @selected("1 day before" ===$templateMessages->day) @endif> 1 day before</option>
                                        <option value="0 day of"@if (!empty($templateMessages)) @selected("0 day before" ===$templateMessages->day) @endif>  Day of</option>
                                        <option value="1 day after"@if (!empty($templateMessages)) @selected("1 day after" ===$templateMessages->day) @endif>1 day after</option>
                                        <option value="2 days after"@if (!empty($templateMessages)) @selected("2 days after" ===$templateMessages->day) @endif>2 days after</option>
                                        <option value="3 days after"@if (!empty($templateMessages)) @selected("3 days after" ===$templateMessages->day) @endif>3 days after</option>
                                        <option value="4 days after"@if (!empty($templateMessages)) @selected("4 days after" ===$templateMessages->day) @endif>4 days after</option>
                                        <option value="5 days after"@if (!empty($templateMessages)) @selected("5 days after" ===$templateMessages->day) @endif>5 days after</option>
                                        <option value="6 days after"@if (!empty($templateMessages)) @selected("6 days after" ===$templateMessages->day) @endif>6 days after</option>
                                        <option value="7 days after"@if (!empty($templateMessages)) @selected("7 days after" ===$templateMessages->day) @endif>7 days after</option>
                                        <option value="8 days after"@if (!empty($templateMessages)) @selected("8 days after" ===$templateMessages->day) @endif>8 days after</option>
                                        <option value="9 days after"@if (!empty($templateMessages)) @selected("9 days after" ===$templateMessages->day) @endif>9 days after</option>
                                        <option value="10 days after"@if (!empty($templateMessages)) @selected("10 days after" ===$templateMessages->day) @endif>10 days after</option>
                                        <option value="11 days after"@if (!empty($templateMessages)) @selected("11 days after" ===$templateMessages->day) @endif>11 days after</option>
                                        <option value="12 days after"@if (!empty($templateMessages)) @selected("12 days after" ===$templateMessages->day) @endif>12 days after</option>
                                        <option value="13 days after"@if (!empty($templateMessages)) @selected("13 days after" ===$templateMessages->day) @endif>13 days after</option>
                                        <option value="14 days after"@if (!empty($templateMessages)) @selected("14 days after" ===$templateMessages->day) @endif>14 days after</option>  
                                     </select>
                                 </div>
                                   <div class="form-group">
                                     <select name="check_out_time"  id="check_out_time"  class="form-control form-control-lg">
                                        <option value=>Time</option>
                                        <option value="12 Am"@if (!empty($templateMessages)) @selected("12 Am" ===$templateMessages->time) @endif>12:00 AM </option>
                                        <option value="11 Am"@if (!empty($templateMessages)) @selected("11 Am" ===$templateMessages->time) @endif>11:00 AM </option>
                                        <option value="10 Am"@if (!empty($templateMessages)) @selected("10 Am" ===$templateMessages->time) @endif>10:00 AM </option>
                                        <option value="9 Am"@if (!empty($templateMessages)) @selected("9 Am" ===$templateMessages->time) @endif> 9:00 AM </option>
                                        <option value="8 Am"@if (!empty($templateMessages)) @selected("8 Am" ===$templateMessages->time) @endif> 8:00 AM </option>
                                        <option value="7 Am"@if (!empty($templateMessages)) @selected("7 Am" ===$templateMessages->time) @endif> 7:00 AM </option>
                                        <option value="6 Am"@if (!empty($templateMessages)) @selected("6 Am" ===$templateMessages->time) @endif> 6:00 AM </option>
                                        <option value="5 Am"@if (!empty($templateMessages)) @selected("5 Am" ===$templateMessages->time) @endif> 5:00 AM </option>
                                        <option value="4 Am"@if (!empty($templateMessages)) @selected("4 Am" ===$templateMessages->time) @endif> 4:00 AM </option>
                                        <option value="3 Am"@if (!empty($templateMessages)) @selected("3 Am" ===$templateMessages->time) @endif> 3:00 AM </option>
                                        <option value="2 Am"@if (!empty($templateMessages)) @selected("2 Am" ===$templateMessages->time) @endif> 2:00 AM </option>
                                        <option value="1 Am"@if (!empty($templateMessages)) @selected("1 Am" ===$templateMessages->time) @endif> 1:00 AM </option>
                                        <option value="1 pm"@if (!empty($templateMessages)) @selected("1 pm" ===$templateMessages->time) @endif>1:00 PM </option>
                                        <option value="2 pm"@if (!empty($templateMessages)) @selected("2 pm" ===$templateMessages->time) @endif>2:00 PM </option>
                                        <option value="3 pm"@if (!empty($templateMessages)) @selected("3 pm" ===$templateMessages->time) @endif>3:00 PM </option>
                                        <option value="4 pm"@if (!empty($templateMessages)) @selected("4 pm" ===$templateMessages->time) @endif>4:00 PM </option>
                                        <option value="5 pm"@if (!empty($templateMessages)) @selected("5 pm" ===$templateMessages->time) @endif>5:00 PM </option>
                                        <option value="6 pm"@if (!empty($templateMessages)) @selected("6 pm" ===$templateMessages->time) @endif>6:00 PM </option>
                                        <option value="7 pm"@if (!empty($templateMessages)) @selected("7 pm" ===$templateMessages->time) @endif>7:00 PM </option>
                                        <option value="8 pm"@if (!empty($templateMessages)) @selected("8 pm" ===$templateMessages->time) @endif>8:00 PM </option>
                                        <option value="9 pm"@if (!empty($templateMessages)) @selected("9 pm" ===$templateMessages->time) @endif>9:00 PM </option>
                                        <option value="10 pm"@if (!empty($templateMessages)) @selected("10 pm" ===$templateMessages->time) @endif>10:00 PM </option>
                                        <option value="11 pm"@if (!empty($templateMessages)) @selected("11 pm" ===$templateMessages->time) @endif>11:00 PM </option> 
                                     </select>
                                 </div>
                              </div>
                              
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end flex-wrap">
                <button class="btn btn-lg btn-primary ml-4 mb-3" type="submit">@if(!empty($templateMessages)) Update  @else Create  @endif</button>
            </div>
          </form>
     </div>
 </main>
@endsection
@push('js')
    <script src="{{asset('assets/custom.js')}}"></script>
    <script>
     function schedulingSelect(){
        selectedValue= scheduling.options[scheduling.selectedIndex].value;
      if(selectedValue==1){
         $("#booking_confirmed").show();
        $("#check_in").hide();
        $("#check_out").hide();
       
      }else if(selectedValue==2){
        $("#booking_confirmed").hide();
        $("#check_in").show();
        $("#check_out").hide();
      }else if(selectedValue==3){
         $("#booking_confirmed").hide();
          $("#check_in").hide();
          $("#check_out").show();
      }
     }
      var e = document.getElementById("scheduling");
        if(e.value==1){
         $("#booking_confirmed").show();
        $("#check_in").hide();
        $("#check_out").hide();
       
      }else if(e.value==2){
        $("#booking_confirmed").hide();
        $("#check_in").show();
        $("#check_out").hide();
      }else if(e.value==3){
         $("#booking_confirmed").hide();
          $("#check_in").hide();
          $("#check_out").show();
      }
         createTemplate.onsubmit = async (e) =>{
            e.preventDefault();
           // showLoader();
            var formData = new FormData(createTemplate);
        
            const response = await fetch("{{route('owner.chat.template.stote')}}",{
                method:"POST",
                body:formData,
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    // 'Content-Type': 'application/json',
                }
            });
            const result =await response.json();
              console.log(result)
              if(result.status==500) {
                hideLoader()
                     $(".template_name").text("");
                     $(".message").text("");
                     $(".property_listing").text("");
                     $(".scheduling").text("");
                     $(".template_name").text("");
                     $(".template_name").text(result.errors.template_name);
                     $(".message").text(result.errors.message);
                     $(".property_listing").text(result.errors.property_listing);
                     $(".scheduling").text(result.errors.scheduling);
            }
             if(result.status==200){
             
                hideLoader();
                toastr.success(result.msg);
                setTimeout(() => {
                   window.location.href= site_url+"/owner/chat/scheduled-message/"+result.id;
               }, 500);
            }
         }
    </script>
@endpush