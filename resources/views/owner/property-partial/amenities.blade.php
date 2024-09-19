<div class="tab-pane tab-pane-parent fade px-0" id="amenities" role="tabpanel" aria-labelledby="amenities-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0" id="heading-amenities">
            <h5 class="mb-0">
                <button class="btn btn-block collapse-parent collapsed border shadow-none" data-toggle="collapse" data-number="2." data-target="#amenities-collapse" aria-expanded="true" aria-controls="amenities-collapse">
                    <span class="number">2.</span> Amenities
                </button>
            </h5>
        </div>
        <div id="amenities-collapse" class="collapse collapsible" aria-labelledby="heading-amenities" data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="card mb-6">
                    @if (!empty($propertyListing))
                        @php
                            $subAminitiesId = [];
                            $subAminities = $propertyListing->property_aminities->toArray();
                            foreach ($subAminities as $key => $subAminitie):
                                $subAminitiesId[] = $subAminitie['sub_aminities_id'];
                            endforeach;
                        @endphp
                    @endif
                    @if (!empty($mainAminity))
                        @foreach ($mainAminity as $aminities)
                            <div class="card-body p-3">
                                <h3 class="card-title mb-0 text-heading fs-22 lh-15"> {{ $aminities->aminity_name }}</h3>
                                @if (!empty($aminities->subAminities))
                                    <div class="row">
                                        @foreach ($aminities->subAminities as $subAminities)
                                            <div class="col-sm-6 col-lg-3 mt-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"  class="custom-control-input" name="sub_aminites" id="{{ $subAminities->name }}" @isset($subAminitiesId)@if (in_array($subAminities->id, $subAminitiesId)) checked @endif @endisset value="{{ $subAminities->id }}">
                                                    <label class="custom-control-label" for="{{ $subAminities->name }}">{{ $subAminities->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void(0)"
                        class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16"><i
                                class="fal fa-long-arrow-left"></i></span>Prev step
                    </a>
                    <button class="btn btn-lg btn-primary mb-3 aminities_attraction"
                        type="button">@if(!empty($propertyListing)) Update Next @else Next step @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>