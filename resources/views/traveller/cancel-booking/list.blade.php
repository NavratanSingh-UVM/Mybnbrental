@extends('traveller.layouts.master')
@section('content')
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
                        <div class="table-responsive">
                            <table id="your-booking" class="table table-hover bg-white border rounded-lg" style="width: 100%">
                                <thead>
                                    <tr role="row">
                                        <th>Sr No.</th>
                                        <th>Check In Date</th>
                                        <th>Check Out Date</th>
                                        <th>Total Booking Fess</th>
                                        <th>Paid Amount</th>
                                        <th>Refundabe Amount</th>
                                         <th>Transaction Id</th>
                                        <th>Cancellention Date</th>
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
        $(function () {
            var table = $("#your-booking").DataTable({
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
                    url:"{{route('cancel.bokking.list')}}",
                },
                dataType: 'html',
                columns: [
                    {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
                    {data: 'booking_information.check_in', name: 'booking_information.check_in',orderable: false},
                    {data: 'booking_information.check_out', name: 'booking_information.check_out',orderable: false},
                    {data: 'booking_information.total_amount', name: 'booking_information.total_amount',orderable: false,defaultContent:919786123454},
                    {data: 'paid_amount', name: 'paid_amount',orderable: false},
                    {data: 'refundable_amount', name: 'refundable_amount',orderable: false},
                      {data: 'refund_id', name: 'refund_id',orderable: false},
                    {data: 'created_at', name: 'created_at',searchable: false,orderable: false,defaultContent:'NA'},
                    {data: 'action', name:'action',searchable: false,orderable: false},
                ]
            });
        })
    </script>
@endpush
