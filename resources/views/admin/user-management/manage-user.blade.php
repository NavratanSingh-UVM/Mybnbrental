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
                        <div class="col-md-6"><h4 style="color:black">User Management</h4></div>                             
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
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="owner-list">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Customer Phone</th>
                                                <th>Password</th>
                                                <th>Status</th>
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
    var table = $('#owner-list').DataTable({
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
            url:"{{route('admin.user.management')}}",
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
            {data: 'name', name: 'name',orderable: false},
            {data: 'email', name: 'email',orderable: false},
            {data: 'phone', name: 'phone',orderable: false,defaultContent:919786123454},
            {data: 'show_password', name: 'show_password',orderable: false},
            {data: 'status', name: 'status',orderable: false},
            // {data: 'routing_number', name: 'routing_number',orderable: false},
        ],
        // dom: 'Bfrtip',
        // buttons: [
        //   'excelHtml5',
        //   'csvHtml5'
        // ],
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

//   Region  Delete Method
// function userStatusChange()(id){
//     Swal.fire({
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'
//       }).then((result) => {
//         if (result.isConfirmed) {
//             showLoader();
//             $.ajax({
//                 url: "{{ route('admin.property.listing.delete.propert') }}",
//                 type: 'POST',
//                 dataType: "json",
//                 data:{'id':id,'_token': '{{ csrf_token()}}'},
//                 cache:false,
//                 success:function (res) {
//                     hideLoader();
//                     Swal.fire(
//                         'Confirmed!',
//                         res.msg,
//                         ).then((res)=>{
//                             setTimeout(function() {
//                                 location.reload();
//                             },500);
//                     })
//                 }
//             });
//         }
//     });
// } 

function userStatusChange(value,id){
    showLoader();
       $.ajax({
        url: "{{ route('admin.change.user.status') }}",
        type: 'POST',
        dataType: "json",
        data:{'id':id,"value":value,'_token': '{{ csrf_token()}}'},
        cache:false,
        success:function (res) {
            hideLoader();
            if(res.status=='1'){
                toastr.success(res.msg)
                setTimeout(function() {
                    location.reload();
                },500);
            }else{
                toastr.error(res.msg)
            }
        }
    });
   
}
// function propertyFeatured(id){
//     showLoader();
//     let value = $(".feature_property").val();
//         $.ajax({
//         url: "{{ route('admin.property.listing.feature.property') }}",
//         type: 'POST',
//         dataType: "json",
//         data:{'id':id,"value":value,'_token': '{{ csrf_token()}}'},
//         cache:false,
//         success:function (res) {
//             hideLoader();
//             if(res.status=='1'){
//                 toastr.success(res.msg)
//                 setTimeout(function() {
//                     location.reload();
//                 },500);
//             }else{
//                 toastr.error(res.msg)
//             }
//         }
//     });
// }
</script>
    
@endpush