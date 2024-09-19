@extends('owner.layouts.master')
@push('css')
<link rel="stylesheet" href="{{asset('traveller-assets/css/chat.css')}}" rel="text/css">
@endpush
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="text-right">
                    <a href="{{ route('owner.chat.create.template',['user_id'=>encrypt($id)]) }}" class="btn btn-lg btn-primary next-button property_information" type="button">Create a message template
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
                            <table id="template-message-listing" class="table table-hover bg-white border rounded-lg" style="width: 100%">
                                <thead>
                                    <tr role="row">
                                        <th>Sr No.</th>
                                        <th>Template Name</th>
                                        <th>Template Action</th>
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
    var table = $('#template-message-listing').DataTable({
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
            url:"{{route('owner.chat.sheduled.message.listing',['id'=>encrypt($id)])}}",
            data:function(d){
                console.log(d);
                d.user_id=$("input[name=user_id]").val()
               d.property_id =$("input[name='property_id']").val()
               d.template_name =$("input[name='template_name']").val()
               d.scheduling =$("input[name='scheduling']").val()
               d.name =$("input[name='owner_name']").val()
            }
        },
        dataType: 'html',
        columns: [
            {data: 'DT_RowIndex' ,name:'DT_RowIndex',searching: false,orderable: false},
           // {data: 'id', name: 'id',orderable: false},
            {data: 'template_name', name: 'template_name',orderable: false},
            //{data: 'subscription_date', name: 'subscription_date',orderable: false,defaultContent:"07 June 2023"}
           // {data: 'property_main_photos', name: 'property_main_photos',orderable: false},
            {data: 'Template Action', name: 'Template Action',orderable: false},
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
                url: "{{route('owner.chat.delete.template')}}",
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