@extends('admin.layouts.master')
@push('title')
    Manage Cancel Booking
@endpush
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    @include('flash-message.flash-message')
                    <div class="row">
                        <div class="col-md-6"><h4 style="color:black">Manage Cancel Booking</h4></div>                   
                    </div>
                </div>
            </div> 
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="cancelBookingList">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Booking Id</th>
                                                <th>Transaction Id</th>
                                                <th>Cancellention Date</th>
                                                <th>Refund Amount</th>
                                                <th>Property Id</th>
                                                <th>Traveller Phone</th>
                                                <th>Traveller Email Id</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection
@push('js')
    <script>
        $(function () {
            var table = $('#cancelBookingList').DataTable({
                "language": {
                "zeroRecords": "No record(s) found.",
                searchPlaceholder: "Search records"
            },
            "bDestroy": true,
            searching: false,
            ordering: false,
            paging: true,
            processing: true,
            serverSide: true,
            lengthChange: true,
            "bSearchable":false,
            bStateSave: true,
            scrollX: true,
                ajax:{
                    url:"{{route('admin.cancel.booking.list')}}",
                },
                dataType: 'html',
                columns: [
                    {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
                    {data: 'booking_id' ,name:'booking_id',searching: false,orderable: false},
                    {data: 'refund_id', name: 'refund_id',orderable: false},
                    {data: 'created_at', name: 'created_at',orderable: false},
                    {data: 'refundable_amount', name: 'refundable_amount',orderable: false,defaultContent:0},
                    {data: 'booking_information.property_id', name: 'booking_information.property_id',orderable: false,defaultContent:"07 June 2023"},
                    {data: 'traveller_phone', name: 'traveller_phone',orderable: false,defaultContent:0},
                    {data: 'traveller_email', name: 'traveller_email',orderable: false,defaultContent:"07 June 2023"},
                ]
            });
            $.fn.dataTable.ext.errMode = 'none';
            $('#cancelBookingList').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })

        });
    </script>
@endpush