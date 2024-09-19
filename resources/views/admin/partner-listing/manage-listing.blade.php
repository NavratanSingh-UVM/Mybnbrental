@extends('admin.layouts.master')
@push('title')
    Manage Listing
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
                        <div class="col-md-6"><h4 style="color:black">Manage Listing</h4></div>                   
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
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="manageListing">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Owner Name</th>
                                                <th>Title</th>
                                                <th>Address	</th>
                                                <th>Email</th>
                                                <th>Phone</th>
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
            var table = $('#manageListing').DataTable({
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
                    url:"{{route('admin.partner.listing.manage.listing')}}",
                },
                dataType: 'html',
                columns: [
                     {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
                    {data: 'user.name' ,name:'user.name',searching: false,orderable: false},
                    {data: 'title', name: 'title',orderable: false},
                    {data: 'address', name: 'address',orderable: false},
                    {data: 'email', name: 'email',orderable: false,defaultContent:0},
                    {data: 'phone', name: 'phone',orderable: false,defaultContent:"07 June 2023"},
                ]
            });
            $.fn.dataTable.ext.errMode = 'none';
            $('#manageListing').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })

        });
    </script>
@endpush