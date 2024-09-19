@extends('partner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Card Details</h2>
        </div>
        <form id="makePayment">
            @csrf
            <div class="row mb-6">
                <div class="col-lg-12">
                    <div class="card mb-6">
                        <div class="card-body px-6 pt-6 pb-5">
                            <div class="row">   
                                <div class="form-group col-md-6 px-4">
                                    <label for="name_on_card" class="text-heading">Name On Card</label>
                                    <input type="text" name="name_on_card" id="name_on_card" class="form-control">
                                    <span class="text-danger name_on_card"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="card_number" class="text-heading">Card Number</label>
                                    <input type="text" name="card_number" id="card_number" class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <span class="text-danger card_number"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="cvv_pin" class="text-heading">Cvv Pin</label>
                                    <input type="text" name="cvv_pin" id='cvv_pin' class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <span class="text-danger cvv_pin"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="expiry_month" class="text-heading">Expiry Month</label>
                                    <input type="text" class="form-control form-control-lg border-0" id="expiry_month" name="expiry_month" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <span class="text-danger expiry_month"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="expiry_year" class="text-heading ">Expiry year</label>
                                    <input type="text" class="form-control form-control-lg border-0" id="expiry_year" name="expiry_year" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <span class="text-danger expiry_year"></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <div class="d-flex justify-content-center flex-wrap mt-6">
                                        <button class="btn btn-lg btn-primary ml-4 mb-3">Confirm Payment $({{$total_amount}})</button>
                                    </div>
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
        makePayment.onsubmit = async (e) =>{
            e.preventDefault();
            showLoader();
            const response = await fetch (site_url+"/make-partner-listing-paymnet",{
                method:"POST",
                body:new FormData(makePayment),
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    // 'Content-Type': 'application/json',
                }
            })
            const results = await response.json();
            if(response.status==422){
                hideLoader();
                $("#makePayment").find('span').text("");
                for(let index in results.errors){
                    $("."+index).text(results.errors[index]);
                }
                $('select').select2();

            }
            if(results.msg_type =='success_msg'){
                
                toastr.success(results.msg);
                setTimeout(() => {
                    window.location.href=results.url;
                }, 2000);
                hideLoader();
            }

            if(results.msg_type =='error_msg') {
                hideLoader();
                $("#makePayment").trigger("reset");
                toastr.error(results.msg);
            }
        }
    </script>
@endpush