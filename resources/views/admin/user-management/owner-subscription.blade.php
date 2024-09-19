@extends('admin.layouts.master')
@push('title')
    User Management
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
                        <div class="col-md-6"><h4 style="color:black">Featured Property Subscription List</h4></div>                             
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
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="owner-subscription">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Owner Name</th>
                                                <th>Owner Email</th>
                                                <th>Owner Phone</th>
                                                <th>Transction Id</th>
                                                <th>transaction Amount</th>
                                                <th>Properties Id</th>
                                                <th>No Month</th>
                                                <th>Status</th>
                                                <th>Transaction Date</th>
                                                <th>Expiration Date</th>
                                                {{-- <th>Action</th> --}}
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
    var table = $('#owner-subscription').DataTable({
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
            url:"{{route('admin.owner.subscription')}}",
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
            {data: 'users.name', name: 'users.name',orderable: false},
            {data: 'users.email', name: 'users.email',orderable: false},
            {data: 'users.phone', name: 'users.phone',orderable: false,defaultContent:919786123454},
            {data: 'transaction_id', name: 'transaction_id',orderable: false},
            {data: 'amount', name: 'amount',orderable: false},
            {data: 'property_id', name: 'property_id',orderable: false},
            {data: 'month', name: 'month',orderable: false},
            {data: 'status', name: 'month',orderable: false},
            {data: 'created_date', name: 'created_date',searchable: false,orderable: false},
            {data: 'expiration_date', name: 'expiration_date',orderable: false},
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

</script>
    
@endpush