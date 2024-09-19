@extends('admin.layouts.master')
@push('title')
    Manage Payments
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
                        <div class="col-md-6"><h4 style="color:black">Manage Payments</h4></div>                               
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
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="managePayment">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Transaction Id</th>
                                                <th>No Of Listings</th>
                                                <th>Transaction Amount</th>
                                                <th>Expired Date</th>
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
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection
@push('js')
    <script>
        $(function () {
            var table = $('#managePayment').DataTable({
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
                    url:"{{route('admin.partner.listing.manage.payment')}}",
                },
                dataType: 'html',
                columns: [
                    {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
                    {data: 'transaction_id', name: 'transaction_id',searchable: false,orderable: false},
                    {data: 'no_of_listing', name: 'no_of_listing',orderable: false},
                    {data: 'total_amount', name: 'total_amount',orderable: false,defaultContent:0},
                    {data: 'expired_date', name: 'expired_date',orderable: false,defaultContent:"07 June 2023"},
                    {data: 'created_at', name: 'created_at',searching:false,orderable: false,defaultContent:"07 June 2023"},
                ]
            });
            $.fn.dataTable.ext.errMode = 'none';
          //  $('#managePayment').on('error.dt', function(e, settings, techNote, message) {
              //  console.log( 'An error has been reported by DataTables: ', message);
          //  })
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
           
  
        });
    </script>
@endpush