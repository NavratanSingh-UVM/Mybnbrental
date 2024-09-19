<div class="tab-pane tab-pane-parent fade px-0" id="rental-policies" role="tabpanel" aria-labelledby="rental-policies-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0"
            id="heading-rental-policies">
            <h5 class="mb-0">
                <button class="btn btn-block collapse-parent collapsed border shadow-none"
                    data-toggle="collapse" data-number="4."
                    data-target="#rental-policies-collapse" aria-expanded="true"
                    aria-controls="photo-collapse">
                    <span class="number">5.</span> Rental Policies
                </button>
            </h5>
        </div>
        <div id="rental-policies-collapse" class="collapse collapsible" aria-labelledby="heading-rental-policies"
            data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="card mb-6">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rental_policies">Rental Policies</label>
                                <textarea class="form-control h-150px" rows="6" id="rental_policies" name="rental_policies">@if (!empty($propertyListing)){{ $propertyListing->rental_policies }}@endif
                               </textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cancel_polices">Cancellation Policies</label></br>
                                @foreach ($cancelletionPolicies as $cancelletionPolicy)
                                    <input type="radio" value="{{ $cancelletionPolicy->id }}" name="cancelletion_policies" id="cancelletion_{{ $cancelletionPolicy->id }}" @if (!empty($propertyListing)) @checked($cancelletionPolicy->id == $propertyListing->cancelletion_policies_id) @endif>
                                    <label for="cancelletion_{{ $cancelletionPolicy->id }}">
                                        <strong> {{ $cancelletionPolicy->name }}</strong> :
                                        <span>{{ $cancelletionPolicy->description }}</span>
                                    </label>
                                    </br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void(0)" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16"><i class="fal fa-long-arrow-left"></i></span>Prev step
                    </a>
                    <button class="btn btn-lg btn-primary next-button mb-3 rental_policies">@if(!empty($propertyListing)) Update Next @else Create Property @endif
                        <span class="d-inline-block ml-2 fs-16">
                            <i class="fal fa-long-arrow-right"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>