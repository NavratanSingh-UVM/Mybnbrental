@extends('admin.layouts.master')
@push('title')
    Manage Property Listing
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
                        <div class="col-md-6"><h4 style="color:black">Manage Property Listing</h4></div>
                        <div class="col-md-6 text-right"><a href="{{ route('admin.property.listing.create') }}" class="btn mb-1 btn-primary float-right">Add Property Listing <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
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
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="property_id">Property id</label>
                                            <input type="text" name="property_id" class="form-control" placeholder="Property Id" id='property_id' value="{{ $propertyListing->property_name??"" }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="phone" id='Owner Phone' value="{{ $propertyListing->property_name??"" }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control" placeholder="Owner Email" id='email' value="{{ $propertyListing->property_name??"" }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="owner_name">Owner Name</label>
                                            <input type="text" name="owner_name" class="form-control" placeholder="Owner Name" id='owner_name' value="{{ $propertyListing->property_name??"" }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <button class="btn btn-primary search" style="margin: 31px;">Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="property_listing">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Property Id</th>
                                                <th>Property Name</th>
                                                <th>No Of Enquiries</th>
                                                <th>Subscription Date</th>
                                                <th>Property Created Date</th>
                                                <th>Renewal Date</th>
                                                <th>No Visitors</th>
                                                <th>Property Photo</th>
                                                <th>Property Approved</th>
                                                <th>Featured Property</th>
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
    var table = $('#property_listing').DataTable({
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
            url:"{{route('admin.property.listing.index')}}",
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
            {data: 'no_enquires', name: 'no_enquires',orderable: false,defaultContent:0},
            {data: 'subscription_date', name: 'subscription_date',orderable: false,defaultContent:"07 June 2023"},
            {data: 'created_date', name: 'created_date',orderable: false,defaultContent:"07 June 2023"},
            {data: 'renval_date', name: 'renval_date',orderable: false,defaultContent:"07 June 2023"},
            {data: '', name: '',orderable: false,defaultContent:0},
            {data: 'property_main_photos', name: 'property_main_photos',orderable: false},
            {data: 'property_approved', name: 'property_approved',orderable: false},
            {data: 'featured_approved', name: 'featured_approved',orderable: false},
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

//   Region  Delete Method
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

function propertyApproved(id,value){
    showLoader();
        $.ajax({
        url: "{{ route('admin.property.listing.approval.property') }}",
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
function propertyFeatured(id,value){
    showLoader();
        $.ajax({
        url: "{{ route('admin.property.listing.feature.property') }}",
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
</script>
    
@endpush