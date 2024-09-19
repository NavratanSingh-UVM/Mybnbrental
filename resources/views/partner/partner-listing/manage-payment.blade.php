@extends('partner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Manage Transactions</h2>
        </div>
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="text-right">
                    <a href="{{ route('partner.add.partner.listing.payment') }}" class="btn btn-lg btn-primary next-button property_information" type="button">Make Payment
                    <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mb-12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="paymentTransaction" class="table table-hover bg-white border rounded-lg" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th>Sr No.</th>
                                        <th>Transaction Id</th>
                                        <th>No Of Listings</th>
                                        <th>Transaction Amount</th>
                                        <th>Expired Date </th>
                                        <th>Transaction Date</th>
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
</main>
@endsection
@push('js')
<script>
    $(function () {
    var table = $('#paymentTransaction').DataTable({
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
            url:"{{route('partner.manage.payment')}}",
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'transaction_id', name: 'transaction_id',orderable: false},
            {data: 'no_of_listing', name: 'no_of_listing',orderable: false},
            {data: 'total_amount', name: 'total_amount',orderable: false,defaultContent:0},
            {data: 'expired_date', name: 'expired_date',orderable: false,defaultContent:"07 June 2023"},
            {data: 'created_at', name: 'created_at',orderable: false,defaultContent:"07 June 2023"},
            // {data: 'status', name: 'status',orderable: false,defaultContent:"07 June 2023"},
            // {data: 'created_date', name: 'created_date',orderable: false,defaultContent:"07 June 2023"},
            /* {data: '', name: '',orderable: false,defaultContent:0},
            {data: 'property_main_photos', name: 'property_main_photos',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}, */
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#paymentTransaction').on('error.dt', function(e, settings, techNote, message) {
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
})
</script>
    
@endpush