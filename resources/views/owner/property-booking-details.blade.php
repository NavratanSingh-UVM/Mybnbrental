@extends('owner.layouts.master')
@section('content')
<style>
.customfilter {
    margin-top: 20px;
    border-bottom: 1px solid #efefef;
}

.customfilter ul li {
    display: inline-block;
}
.customfilter ul li a.active {
    background: #7571f9;
    color: #fff;
    border-color: #7571f9;
}
.customfilter ul li a {
    display: block;
    border: 1px solid #cdcccc;
    padding: 8px 20px;
    border-radius: 50px;
    margin-right: 10px;
}
.customfilter ul li a:hover {
    background: #7571f9;
    color: #fff;
    border-color: #7571f9;
}
</style>
<div class="col-md-6">
</div>
{{-- <div class="col-md-6">
    <div class="text-right">
        <a href="{{ route('owner.create.property') }}" class="btn btn-lg btn-primary next-button property_information" type="button">Add New Property
        <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span>
        </a>
    </div>
</div> --}}
  <div class="customfilter">
        <ul>
           <li><a href="javascript:void(0)" class="active upcomming" onclick="upCommingBooking()">Upcoming Bookings : <span  id="upcomming"></span></a></li>
           <li><a href="javascript:void(0)" class="ongoing" onclick="onGoingBooking()">Ongoing Bookings : <span id="ongoing"></span></a></li>
           <li><a href="javascript:void(0)" class="payment" onclick="paymentDue()">Payment Due Pending : <span id="payment"></span></a></li>
            <li><a href="javascript:void(0)" class="all" onclick="allData()">All Data : <span id="all"></span></a></li>
        </ul>
    </div>

<div class="px-3 px-lg-6 px-xxl-13 py-5 invoice-listing">
    <div class="table-responsive">
        <table id="property_booking" class="table table-hover bg-white border rounded-lg" style="width: 100%">
            <thead>
                <tr role="row">
                    <th>Sr No.</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Total Booking Fess</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="propertyBookingDetails" tabindex="-1" role="dialog" aria-labelledby="propertyBookingDetailsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">View Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
@push('js')
<script>
    var table
    var bookingType = "";
    $(function () {
    var table = $('#property_booking').DataTable({
        "language": {
        "zeroRecords": "No record(s) found.",
         searchPlaceholder: "Search records"
      },
      "bDestroy": true,
      searching: true,
       ordering: false,
       paging: true,
       processing: true,
       serverSide: true,
       lengthChange: true,
       "bSearchable":true,
       bStateSave: true,
       scrollX: true,
        ajax:{
            url:"{{route('owner.property.booking')}}",
             data:function(d){
                d.bookingType=bookingType
             },
                 dataSrc: function (json) {
                if(bookingType=="upcomming-booking"){
                  document.getElementById("upcomming").innerHTML=json.data.length;
                }else if(bookingType=="ongoing-booking"){
                  document.getElementById("ongoing").innerHTML=json.data.length;
                }else if(bookingType=="payment-due"){
                 document.getElementById("payment").innerHTML=json.data.length;
                }else if(bookingType=="all-data"){
                   document.getElementById("all").innerHTML=json.data.length; 
                }
                
                 // console.log('Total Count:', json.totalCount,bookingType);
               return json.data;
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
            {data: 'check_in', name: 'check_in',orderable: false},
            {data: 'check_out', name: 'check_out',orderable: false},
            {data: 'total_amount', name: 'total_amount',orderable: false,defaultContent:919786123454},
            {data: 'paid_amount', name: 'paid_amount',orderable: false},
            {data: 'dues_amount', name: 'dues_amount',orderable: false},
            {data: 'next_payment_date', name: 'next_payment_date',searchable: false,orderable: false},
            {data: 'action', name: 'action',orderable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#amenites').on('error.dt', function(e, settings, techNote, message) {
       console.log( 'An error has been reported by DataTables: ', message);
    })
    $('.mega-menu').on('click',function(){
        try {
            table.state.clear();
        }
        catch(err) {
            console.log(err.message);
        }
    })
    $(".search").on('click',function(){
        table.draw();
    })
  });
  
 function upCommingBooking() {
    bookingType ="upcomming-booking";
    $(".payment").removeClass('active');
    $(".ongoing").removeClass('active');
    $(".upcomming").addClass('active');
    $(".all").removeClass('active');
   // table.draw();
}
function onGoingBooking() {
    bookingType ="ongoing-booking";
    $(".ongoing").addClass('active');
    $(".payment").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".all").removeClass('active');
  //  table.draw();
}
function paymentDue() {
    bookingType ="payment-due";
    $(".ongoing").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".payment").addClass('active');
    $(".all").removeClass('active');
  //  table.draw();
}
function allData() {
    bookingType ="all-data";
    $(".ongoing").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".payment").removeClass('active');
    $(".all").addClass('active');
     //table.draw();
}
</script>
@endpush