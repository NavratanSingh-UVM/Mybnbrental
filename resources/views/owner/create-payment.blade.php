@extends('owner.layouts.master')
@push('css')
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
@endpush
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Add Feature Property </h2>
        </div>
        <form id="authorizeDotNetPayemnt">
            @csrf
            <div class="row mb-6">
                <div class="col-lg-12">
                    <div class="card mb-6">
                        <div class="card-body px-6 pt-6 pb-5">
                            <div class="row">   
                                <div class="form-group col-md-6 px-4">
                                    <label for="property" class="text-heading">Property</label>
                                    <select name="property[]" id="property" class="form-control property" multiple onchange="calculatePrice()">
                                        <option value="">Select Property</option>
                                        @foreach ($properties as $property)
                                            <option value="{{$property->id}}">{{$property->property_name}}</option>
                                        @endforeach 
                                    </select>
                                    <span class="text-danger "></span>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="no_of_month" class="text-heading">No Month</label>
                                    <select name="no_of_month" id="no_of_month" class="form-control select" onchange="calculatePrice()">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}">{{$i}} Month</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-6 px-4">
                                    <label for="total_amount" class="text-heading ">Total Amount</label>
                                    <input type="text" class="form-control form-control-lg border-0" id="total_amount" name="total_amount" value="0" readonly>
                                </div>
                                <div class="form-group col-md-12 px-4">
                                    <div class="d-flex justify-content-center flex-wrap">
                                        <button class="btn btn-lg btn-primary ml-4 mb-3" disabled>Make Payment</button>
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
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".property").chosen({
            no_results_text: "Oops, nothing found!"
        })
    });
</script>
<script>
    calculatePrice = async () =>{
        showLoader();
        let data = {
            'property' :$("#property").val(),
            'no_month':$('#no_of_month').val(),
        };
        const response = await fetch (site_url+'/owner/calculate-price',{
            method:"POST",
            body:JSON.stringify(data),
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                'Content-Type': 'application/json',
            }

        });
        const results = await response.json();
        if(response.status==200){
            hideLoader();
            $("button").removeAttr('disabled')
            $("#total_amount").val(results.data);
        }else{
            hideLoader();
            $("#total_amount").val(0);
        }
    }
    authorizeDotNetPayemnt.onsubmit = async (e) =>{
        e.preventDefault();
        showLoader();
        const response = await fetch (site_url+"/owner/make-payment",{
            method:"POST",
            body:new FormData(authorizeDotNetPayemnt),
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                // 'Content-Type': 'application/json',
            }
        })
        const results = await response.json();
        if(response.status==422){
            hideLoader();
            $("#authorizeDotNetPayemnt").find('span').text("");
            for(let index in results.errors){
                $("."+index).text(results.errors[index]);
            }
            $('select').select2();

        }
        if(response.status==200){
            hideLoader();
            toastr.success(results.msg);
            window.location.href=results.url;
        }
    }

</script>
@endpush