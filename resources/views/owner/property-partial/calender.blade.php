<div class="tab-pane tab-pane-parent fade px-0" id="calender" role="tabpanel" aria-labelledby="calender-tab">
    <div class="card bg-transparent border-0">
        <div class="card-header d-block d-md-none bg-transparent px-0 py-1 border-bottom-0" id="heading-calender">
            <h5 class="mb-0">
                <button class="btn btn-block collapse-parent collapsed border shadow-none" data-toggle="collapse" data-number="7." data-target="#calender-collapse" aria-expanded="true" aria-controls="calender-collapse">
                    <span class="number">7.</span> Calender
                </button>
            </h5>
        </div>
        <div id="calender-collapse" class="collapse collapsible" aria-labelledby="heading-calender" data-parent="#collapse-tabs-accordion">
            <div class="card-body py-4 py-md-0 px-0">
                <div class="card mb-6">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="import_calender_url">Import Calender Url</label>
                                        <input type="text" name="import_calender_url" class="form-control" id="import_calender_url" placeholder="Import Calender link" value="{{ $propertyListing?->icalLink[0]?->ical_link ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary sync_now" style="margin: 30px;">Sync Now</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="exportIcalLink({{(request()->id)??''}})">Export Calender (iCal File)</a>
                                    <a class="copy_text btn btn-primary"  data-toggle="tooltip" title="Copy to Clipboard" href="" style="display:none">Copy ical Link</a>
                                </div>
                            </div>

                            <div style="height: 100vh;width:100%">
                                <div id='calendar1'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <a href="javascript:void()" class="btn btn-lg bg-hover-white border rounded-lg mb-3 mr-auto prev-button">
                        <span class="d-inline-block text-primary mr-2 fs-16"><i class="fal fa-long-arrow-left"></i></span>Prev step
                    </a>
                    <button class="btn btn-lg btn-primary next-button mb-3 craete_property">
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
