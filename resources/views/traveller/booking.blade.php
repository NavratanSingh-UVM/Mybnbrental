@extends('traveller.layouts.master')
@section('content')
<style>
.customfilter {
    margin-bottom: 40px;
    border-bottom: 1px solid #efefef;
}
.customfilter ul {
    padding: 0;
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
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="text-right">
                </div>
            </div>
        </div>
        <div class="row mb-12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                     <div class="customfilter">
                        <ul>
                          <li><a href="javascript:void(0)" class="active upcomming" onclick="upCommingBooking()">Upcoming Bookings : <span></span></a></li>
                          <li><a href="javascript:void(0)" class="ongoing" onclick="onGoingBooking()">Ongoing Bookings : <span></span></a></li>
                          <li><a href="javascript:void(0)" class="payment" onclick="paymentDue()">Payment Due Pending : <span></span></a></li>
                        <li><a href="javascript:void(0)" class="all" onclick="allData()">All Data : <span></span></a></li>
                        </ul>
                      </div>
                        <div class="table-responsive">
                            <table id="your-booking" class="table table-hover bg-white border rounded-lg" style="width: 100%">
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
                            </table>
                        </div>
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
             table = $("#your-booking").DataTable({
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
                    {data: 'next_payment_date', name: 'next_payment_date',searchable: false,orderable: false,defaultContent:'NA'},
                    {data: 'action', name:'action',searchable: false,orderable: false},
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
   //table.draw();
}
function onGoingBooking() {
    bookingType ="ongoing-booking";
    $(".ongoing").addClass('active');
    $(".payment").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".all").removeClass('active');
   // table.draw();
}
function paymentDue() {
    bookingType ="payment-due";
    $(".ongoing").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".payment").addClass('active');
    $(".all").removeClass('active');
  //  table.draw();
}
  function allData(){
    //console.log('hello');
     bookingType ="all-data";
    $(".ongoing").removeClass('active');
    $(".upcomming").removeClass('active');
    $(".payment").removeClass('active');
    $(".allData").addClass('active');
     //  table.draw();
  }  

    </script>
@endpush
