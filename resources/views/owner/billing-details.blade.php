@extends('owner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
        @include('flash-message.flash-message')
        <div class="mb-6">
            <h2 class="mb-0 text-heading fs-22 lh-15">Billing Details</h2>
        </div>
        <form action ="{{ route('owner.billing.details.store') }}" method="post">
            @csrf
            <div class="row mb-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="billing_details_id" value="{{ $ownerBillingAdress->id??"" }}">
                                    <div class="form-group">
                                        <label for="account_holder_name" class="text-heading">Account Holder Name</label>
                                        <input type="text" class="form-control form-control-lg" id="account_holder_name" name="account_holder_name" value="{{ $ownerBillingAdress->account_holder_name??"" }}">
                                        @error('account_holder_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_name" class="text-heading">Bank Name</label>
                                        <input type="text" class="form-control form-control-lg" id="bank_name" name="bank_name" value="{{ $ownerBillingAdress->bank_name??"" }}">
                                        @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_number" class="text-heading">Account Number</label>
                                        <input type="text" class="form-control form-control-lg" id="account_number" name="account_number" value="{{ $ownerBillingAdress->account_number??"" }}">
                                        @error('account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="routing_number" class="text-heading">Routing Number</label>
                                        <input type="text" class="form-control form-control-lg" id="routing_number" name="routing_number" value="{{ $ownerBillingAdress->routing_number??"" }}">
                                        @error('routing_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_address" class="text-heading">Billing Address</label>
                                        <input type="text" class="form-control form-control-lg" id="billing_address" name="billing_address" value="{{ $ownerBillingAdress->billing_address??"" }}">
                                        @error('billing_address')
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
                <button class="btn btn-lg btn-primary ml-4 mb-3" type="submit">@if(empty($ownerBillingAdress)) Add @else Update @endif </button>
            </div>
        </form>
    </div>
 </main>
@endsection