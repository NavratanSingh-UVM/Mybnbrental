@extends('owner.layouts.master')
@section('content')
<div class="col-md-6">
</div>
{{-- <div class="col-md-6">
    <div class="text-right">
        <a href="{{ route('owner.create.property') }}" class="btn btn-lg btn-primary next-button property_information" type="button">Add New Property
        <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span>
        </a>
    </div>
</div> --}}

<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
    <div class="table-responsive">
        <table id="booking-enquiry" class="table table-hover bg-white border rounded-lg" style="width: 100%">
            <thead>
                <tr role="row">
                    <th>Sr No.</th>
                    <th>Property Name</th>
                    <th>Traveller Name</th>
                    <th>Description</th>
                    <th>Check in</th>
                    <th>Check Out</th>
                    <th>Enquiry Date</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</main>
@endsection
@push('js')
<script>
    $(function () {
        var table = $('#booking-enquiry').DataTable({
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
                url:"{{route('owner.booking.request')}}",
            },
            dataType: 'html',
            columns: [
                {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
                {data: 'property.property_name' ,name:'property.property_name',searching: false,orderable: false},
                {data: 'user.name' ,name:'user.name',searching: false,orderable: false},
                {data: 'message' ,name:'message',searching: false,orderable: false},
                {data: 'check_in' ,name:'check_in',searching: false,orderable: false},
                {data: 'check_out' ,name:'check_out',searching: false,orderable: false},
                {data: 'enquiry_date' ,name:'enquiry_date',searching: false,orderable: false},
            ]
        });
        $.fn.dataTable.ext.errMode = 'none';
        $('#booking-enquiry').on('error.dt', function(e, settings, techNote, message) {
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