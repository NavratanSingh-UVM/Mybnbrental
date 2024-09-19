@extends('admin.layouts.master')
@push('title')
    Manage City
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
                        <div class="col-md-6"><h4 style="color:black">Manage City</h4></div>
                        <div class="col-md-6 text-right"><a href="{{ route('admin.location.city.create') }}" class="btn mb-1 btn-primary float-right">Add City <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                        </a> </div>                                
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
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="city">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Country Name</th>
                                                <th>State Name</th>
                                                <th>Region Name</th>
                                                <th>City Name</th>
                                                <th>Action</th>
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
    var table = $('#city').DataTable({
        "language": {
        "zeroRecords": "No record(s) found.",
         searchPlaceholder: "Search records"
      },
      "bDestroy": true,
       ordering: false,
       paging: true,
       processing: true,
       serverSide: true,
       lengthChange: true,
       searchable:true,
       bStateSave: true,
       scrollX: true,
        ajax:{
            url:"{{route('admin.location.city')}}",
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
            {data: 'country.name', name: 'country.name',orderable: false},
            {data: 'state.name', name: 'state.name',orderable: false},
            {data: 'region.name', name: 'state.name',orderable: false},
            {data: 'name', name: 'name',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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
  });
  

//   Region  Delete Method
function cityDelete(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: "{{ route('admin.location.city.delete') }}",
                type: 'POST',
                dataType: "json",
                data:{'id':id,'_token': '{{ csrf_token()}}'},
                cache:false,
                success:function (res) {
                    hideLoader();
                    Swal.fire(
                        'Confirmed!',
                        res.msg,
                        ).then((res)=>{
                            setTimeout(function() {
                                location.reload();
                            },500);
                    })
                }
            });
        }
    });
} 
</script>
    
@endpush