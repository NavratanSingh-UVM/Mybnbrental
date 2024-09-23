<div class="tab-pane tab-pane-parent fade px-0" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0" id="heading-reviews">
            <h5 class="mb-0">
                <button class="btn btn-block collapse-parent collapsed border shadow-none" data-toggle="collapse" data-number="7." data-target="#reviews-collapse" aria-expanded="true" aria-controls="reviews-collapse">
                    <span class="number">7.</span> Calender
                </button>
            </h5>
        </div>
        <div id="reviews-collapse" class="collapse collapsible" aria-labelledby="heading-reviews" data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="row">
                    <div class="col-lg-12">
                       <div class="card mb-6">
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviews_heading">Reviews Heading</label>
                                            <input type="text" class="form-control" id="reviews_heading" name="reviews_heading">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guest_name">Guest Name</label>
                                            <input type="text" class="form-control"
                                                id="guest_name" name="guest_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="place">Place</label>
                                            <input type="text" class="form-control"
                                                id="place" name="place">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviews">Reviews</label>
                                            <textarea class="form-control" id="reviews" name="reviews"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rating">Rating</label>
                                            <select name="rating" id="rating" class="form-control" style="width: 100%">
                                                <option value="">Select Rating</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}"> {{ $i }} Star</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary add_reviews" style="margin-top:32px;">Add Reviews</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration display nowrap" style="width:100%" id="reviews_rating">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Reviews Heading</th>
                                                <th>Guest Name</th>
                                                <th>Reviews</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void(0)" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16"><i class="fal fa-long-arrow-left"></i></span>Prev step
                    </a>
                    <button class="btn btn-lg btn-primary next-button mb-3  craete_property">
                        @if (!empty($propertyListing))
                            Update Property
                        @else
                            Create Property
                        @endif
                        {{-- <span class="d-inline-block ml-2 fs-16"><i class="fal fa-long-arrow-right"></i></span> --}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>