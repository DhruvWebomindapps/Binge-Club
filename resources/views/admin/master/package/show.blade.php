<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>Package Create</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Select City </label>
                                <select class="form-select" name="city_id" id="city_id"
                                    aria-label="Default select example">
                                    <option value="{{ $package_list->city ? $package_list->getCity->id : '' }}">
                                        {{ $package_list->city_id ? $package_list->getCity->name : '' }}
                                    </option>

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Select Location </label>
                                <select class="form-select" name="location_id" id="location_id"
                                    aria-label="Default select example">
                                    <option
                                        value="{{ $package_list->location_id ? $package_list->getLocation->id : '' }}">
                                        {{ $package_list->location_id ? $package_list->getLocation->name : '' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label ">Select Screen </label>
                                <select class="form-select" name="screen_id" id="screen_id"
                                    aria-label="Default select example">
                                    <option value="{{ $package_list->screen_id ? $package_list->getScreen->id : '' }}">
                                        {{ $package_list->screen_id ? $package_list->getScreen->screen_name : '' }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label ">Title <span class="mandatorStar">*</span></label>
                                <input type="text" class="form-control" id="title_id" name="title"
                                    value="{{ $package_list->title }}" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control bg-white" id="slug_id" name="slug"
                                    readonly value="{{ $package_list->slug }}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_id" name="description">{{ $package_list->description }}</textarea>

                            </div>
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-lg-6">
                                <label class="form-label">Price <span class="mandatorStar">*</span></label>
                                <input type="text" class="form-control" id="price_id" name="price"
                                    value="{{ $package_list->price }}" readonly>
                                <div id="priceHelp" class="form-text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Discount Percentage</label>
                                <input type="text" class="form-control" id="discount_percentage_id"
                                    name="discount_percentage" value="{{ $package_list->discount_percent }}" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Discount Amount</label>
                                <input type="text" class="form-control" id="discount_amount_id"
                                    name="discount_amount" value="{{ $package_list->discount_price }}" readonly>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Grand Total</label>
                                <input type="text" class="form-control" id="grandTotal_id" name="grand_total"
                                    value="{{ $package_list->grand_total }}" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Discount Start Date</label>
                                <input type="date" class="form-control" id="dicount_s_date_id" name="discount_s_date"
                                    value="{{ $package_list->discount_s_date }}" min="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Discount End Date</label>
                                <input type="date" class="form-control" id="discount_e_date_id"
                                    name="discount_e_date" value="{{ $package_list->discount_e_date }}"
                                    min="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <label class="form-label">Image <span class="mandatorStar">*</span></label>
                                <div id="priceHelp" class="form-text">
                                    @if ($errors->has('image_file'))
                                        <span class="error validation">{{ $errors->first('image_file') }}</span>
                                    @endif
                                    @php
                                        $pkgImg = $package_list->getPackageImage->first();
                                    @endphp
                                    <img class="mt-2" src="{{ asset('storage/' . $pkgImg->package_image) }}"
                                        id="preview_id" width="200px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $("#description_id").summernote({
                placeholder: 'Package Description',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        </script>
    @endpush
</x-admin-layout>
