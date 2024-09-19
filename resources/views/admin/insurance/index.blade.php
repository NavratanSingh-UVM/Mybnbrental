@extends('admin.layouts.master')
@push('title')
    Manage Insurance
@endpush
@section('content')
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    @include('flash-message.flash-message')
                    {{-- <div class="row">
                        <div class="col-md-6"><h4 style="color:black">Manage Insurance</h4></div>
                        <div class="col-md-6 text-right"><a href="{{ route('admin.insurance.create') }}" class="btn mb-1 btn-primary float-right">Add Insurance <span class="btn-icon-right"><i class="fa fa-plus"></i></span>
                        </a> </div>                                
                    </div> --}}
                </div>
            </div> 
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           <div class="card-header">
                               <div style="margin: 20px 0px;">
                                  <strong>Date Filter:</strong>
                                  <input type="text" id="filter" name="daterange" value="" />
                                  <button class="btn btn-success filter">Filter</button>
                               </div>
                                 <form action="/admin/insurance/export" method="POST" class="excledownload">
                                    @csrf
                                    <div class="row ">
                                        <div class=" col-lg-3 col-12">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" id="start_date" name="start_date" required>                                        
                                        </div>

                                        <div class="col-lg-3 col-12">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" id="end_date" name="end_date" required>
                                        </div>

                                        <div class="col-lg-4 col-12">
                                          <select class="form-control form-control-lg mb-3" name="select">
                                              <option value="0">----- Select -----</option>
                                              <option value="Check_in">Check In date</option>
                                              <option value="Payment">Payment date</option>
                                          </select>                                        
                                        </div>

                                        <div class="col-lg-2 col-12"><button class="btn btn-success" type="submit">Export to Excel</button></div>    
                                        
                                    </div>
                                 </form>
                               <div>
                               </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="datepicker">
                                    <table class="table table-striped table-bordered zero-configuration" id="insurances-table">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                 <th>Insurance Name</th>
                                                <th>Property Name</th>
                                                <th>Payment date</th>
                                                <th>Start date</th>
                                                <th>End date</th>
                                                <th>Check In date</th>
                                                <th>Check Out date</th>
                                                <th>Details</th>
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
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection
@push('js')
<script>
$.noConflict();
 $(function () {
 $('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
        endDate: moment()
    });
    var table = $('#insurances-table').DataTable({
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
        ajax:{
            url:"{{route('admin.insurance.list')}}",
             data:function (d) {
                d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        dataType: 'html',
        columns: [
             {data: 'DT_RowIndex' ,name:'DT_RowIndex',searchable: false,orderable: false},
             {data: 'insurance_name', name: 'insurance_name',orderable: false},
            {data: 'property_name.property_name', name: 'property_name.property_name',orderable: false},
            {data: 'payment_date', name: 'payment_date',orderable: false},
            {data: 'start_date', name: 'start_date',orderable: false},
            {data: 'end_date', name: 'end_date',orderable: false},
            {data: 'check_in', name: 'check_in',orderable: false},
            {data: 'check_out', name: 'check_out',orderable: false},
             {data: 'details', name: 'details',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $.fn.dataTable.ext.errMode = 'none';
    $('#amenites').on('error.dt', function(e, settings, techNote, message) {
       console.log( 'An error has been reported by DataTables: ', message);
    })
    $('.mega-menu').on('click',function(){
        try {
            table.insurance.clear();
        }
        catch(err) {
            console.log(err.message);
        }
    })
      $(".filter").click(function(){
        table.draw();
    });
  });
// set on change date picker

//  state  Delete Method

  function insuranceDelete(id){
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
                url: "{{ route('admin.insurance.delete') }}",
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

  