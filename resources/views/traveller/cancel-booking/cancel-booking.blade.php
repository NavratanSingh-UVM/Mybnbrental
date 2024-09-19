@extends('traveller.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Cancellation Booking</h2>
        </div>
        <form id="cancelBooking">
            @csrf
            <input type="hidden" name="id" value="{{request()->cancel_id}}">
            <div class="row mb-6">
                <div class="col-lg-12">
                    <div class="card mb-6">
                        <div class="card-body px-6 pt-6 pb-5">
                            <div class="row">   
                                <div class="form-group col-md-6 px-4">
                                    <label for="cancel_reason" class="text-heading">Cencel Reason</label>
                                    <select id="cancel_reason" class="form-control" name="cancel_reason">
                                        <option value="">Select Reason</option>
                                        @foreach ($cancellentionReasons as $cancellentionReason)
                                            <option value="{{$cancellentionReason->id}}">{{$cancellentionReason->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger cancel_reason"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="reason" class="text-heading">Write Reason</label>
                                    <textarea name="reason" id="reason" class="form-control"></textarea>
                                    <span class="text-danger reason"></span>
                                </div>
                                {{-- <div class="form-group col-md-6 px-4">
                                </div> --}}
                               
                            </div>
                            <hr>
                            <div class="ownermoredetail">
                                <h5>Cancellations Policy</h5>
                                <p>{{$booking?->cancelletionPolicies?->name}}</p>
                                <p>{{$booking?->cancelletionPolicies?->description}}
                                </p>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="from-group col-md-6">
                                    <div class="d-flex justify-content-left flex-wrap mt-6">
                                       <strong>Refund Amount</strong> 
                                    </div>
                                </div>
                                <div class="from-group col-md-6">
                                    <div class="d-flex justify-content-right flex-wrap mt-6 ml-20">
                                       <strong>${{$refundAbleAmount}}</strong> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-left flex-wrap mt-6">
                                    <button class="btn btn-lg btn-primary mb-3">Cancel Booking</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
@push('js')
    <script>
        cancelBooking.onsubmit = async (e) =>{
            e.preventDefault();
            Swal.fire({
                title: "Are you sure cancel the booking ?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Cancel it!"
            }).then(async(result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    // title: "Deleted!",
                    // text: "Your file has been deleted.",
                    // icon: "success"
                    // });
                    showLoader();
                    const response = await fetch ("{{route('cancel.booking.store')}}",{
                        method:"POST",
                        body:new FormData(cancelBooking),
                        headers:{
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            // 'Content-Type': 'application/json',
                        }
                    })
                    const results = await response.json();
                    if(response.status==422){
                        hideLoader();
                        $("#cancelBooking").find('span').text("");
                        for(let index in results.errors){
                            $("."+index).text(results.errors[index]);
                        }

                    }
                    if(results.status){
                        toastr.success(results.msg);
                        setTimeout(() => {
                            window.location.href=results.url;
                        }, 2000);
                        hideLoader();
                    }
                    if(!results.status && response.status ==500) {
                        hideLoader();
                        $("#cancelBooking").trigger("reset");
                        toastr.error(results.msg);
                    }
                }
            });    
        }
    </script>
@endpush