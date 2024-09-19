@extends('owner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Partner Lisiting</h2>
        </div>
        <form action ="{{ route('owner.store.partner.listing.payment') }}" method="post">
            @csrf
            <div class="row mb-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="subscription_fees" class="text-heading">Subscription Fees</label>
                                        <input type="text" class="form-control form-control-lg" id="subscription_fees" name="subscription_fees" value="${{env('PARTNER_LISTING_PRICE')}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="no_of_listing" class="text-heading">No Of Listing</label>
                                        <select name="no_of_listing" id="no_of_listing" style="width: 100%" class="form-control form-control-lg" onchange="calculatePrice()">
                                            <option value="">Select No of listing</option>
                                            @for ($i=1;$i<=25;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        @error('no_of_listing')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="no_year" class="text-heading">No Year</label>
                                        <select class="form-control form-control-lg" id="no_year" name="no_year" onchange="calculatePrice()">
                                            <option value="">Select No Year</option>
                                            @for ($i=1;$i<=12;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        @error('no_year')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="account_holder_name" class="text-heading">Total Amount</label>
                                        <input type="text" class="form-control form-control-lg" id="price" name="price" value="${{env('PARTNER_LISTING_PRICE')}}" readonly>
                                        @error('account_holder_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end flex-wrap">
                <button class="btn btn-lg btn-primary ml-4 mb-3" type="submit">Add</button>
            </div>
        </form>
    </div>
 </main>
@endsection
@push('js')
    <script>
        calculatePrice = () =>{
            let total = {{env('PARTNER_LISTING_PRICE')}};
            if($("#no_of_listing").val() !=''){
                total  = total * parseInt($("#no_of_listing").val());
            }
            if($("#no_year").val() !=""){
                total  = total * parseInt($("#no_year").val());
            }
            $("#price").val("");
            $("#price").val("$"+total);
        }
    </script>
@endpush