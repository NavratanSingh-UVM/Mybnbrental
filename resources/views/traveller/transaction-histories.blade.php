@extends('traveller.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h2 class="mb-0 text-heading fs-22 lh-15">Transaction Histroies</h2>
                </div>
            </div>
        </div>
        <div class="row mb-12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="transactionHistories" class="table table-hover bg-white border rounded-lg" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th>Sr No.</th>
                                        <th>Transaction Id</th>
                                        <th>Transaction Amount</th>
                                        <th>Transaction Date</th>
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
            var table = $("#transactionHistories").DataTable({
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
                    url:"{{route('traveller.booking.transaction.histories')}}",
                },
                dataType: 'html',
                columns: [
                    {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
                    {data: 'transaction_id', name: 'transaction_id',orderable: false},
                    {data: 'pay_amount', name: 'pay_amount',orderable: false},
                    {data: 'created_at', name: 'created_at',orderable: false,defaultContent:919786123454},
                ]
            });
        })
    </script>
@endpush
