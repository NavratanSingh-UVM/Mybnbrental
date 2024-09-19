@extends('owner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    

    

    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="text-right">
                    <a href="{{ route('owner.create.property') }}" class="btn btn-lg btn-primary next-button property_information" type="button">Add New Property
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
                            <table id="my-property-listing" class="table table-hover bg-white border rounded-lg" style="width: 100%">
                                <thead>
                                    <tr role="row">
                                        <th>Sr No.</th>
                                        <th>Property Id</th>
                                        <th>Property Name</th>
                                        {{-- <th>No Of Enquiries</th> --}}
                                        <th>Property Created On</th>
                                        {{-- <th>Created Date</th> --}}
                                        {{-- <th>Renewal Date</th> --}}
                                        {{-- <th>No Visitors</th> --}}
                                        <th>Photo</th>
                                        <th>Status</th>
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
</main>
@endsection
@push('js')
<script>
   $(function () {
    var table = $('#my-property-listing').DataTable({
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
            url:"{{route('owner.my.property.listing')}}",
            data:function(d){
               d.property_id =$("input[name='property_id']").val()
               d.phone =$("input[name='phone']").val()
               d.email =$("input[name='email']").val()
               d.name =$("input[name='owner_name']").val()
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
            {data: 'id', name: 'id',orderable: false},
            {data: 'property_name', name: 'property_name',orderable: false},
            // {data: '', name: '',orderable: false,defaultContent:0},
            {data: 'subscription_date', name: 'subscription_date',orderable: false,defaultContent:"07 June 2023"},
            // {data: '', name: '',orderable: false,defaultContent:"07 June 2023"},
            // {data: 'renval_date', name: 'renval_date',orderable: false,defaultContent:"07 June 2023"},
            // {data: '', name: '',orderable: false,defaultContent:0},
            {data: 'property_main_photos', name: 'property_main_photos',orderable: false},
            {data: 'status', name: 'status',orderable: false},
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
    $(".search").on('click',function(){
        table.draw();
    })




  });

  function propertyDelete(id){
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
                url: "{{ route('admin.property.listing.delete.propert') }}",
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