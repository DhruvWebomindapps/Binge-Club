<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>Package Edit</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/package/' . $package->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="row">
                                <input type="hidden" value="{{ $package->id }}" id="packageEdit_id" />
                                <div class="col col-md-6">
                                    <label class="form-label">Select City </label>
                                    <select class="form-select" name="city_id" id="city_id"
                                        aria-label="Default select example">
                                        <option value="">Select City</option>
                                        @foreach ($city_lists as $list)
                                            <option value="{{ $list->id }}"
                                                @if ($list->id == $package->city_id) selected @endif>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="error validation">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-6">
                                    <label class="form-label">Select Location </label>
                                    <select class="form-select" name="location_id" id="location_id"
                                        aria-label="Default select example">
                                        <option value="">Select Location</option>
                                        @foreach ($location_list as $lc_list)
                                            <option value="{{ $lc_list->id }}"
                                                @if ($lc_list->id == $package->location_id) selected @endif>{{ $lc_list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('location_id'))
                                        <span class="error validation">{{ $errors->first('location_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-6">
                                    <label class="form-label mt-3">Select Screen
                                    </label>
                                    <select class="form-select" name="screen_id" id="screen_id"
                                        aria-label="Default select example">
                                        <option value="">Select Screen</option>
                                        @foreach ($screen_list as $sc_list)
                                            <option value="{{ $sc_list->id }}"
                                                @if ($sc_list->id == $package->screen_id) selected @endif>
                                                {{ $sc_list->screen_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('screen_id'))
                                        <span class="error validation">{{ $errors->first('screen_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label mt-3">Title <span class="mandatorStar">*</span></label>
                                        <input type="text" class="form-control" id="title_id" name="title"
                                            value="{{ $package->title }}">
                                        <div id="emailHelp" class="form-text">
                                            @if ($errors->has('title'))
                                                <span class="error validation">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" class="form-control bg-white" id="slug_id"
                                            name="slug" readonly value="{{ $package->slug }}">
                                    </div>
                                    @if ($errors->has('slug'))
                                        <span class="error validation">{{ $errors->first('slug') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Priority</label>
                                    <input type="number" class="form-control" name="priority"
                                        value="{{ $package->priority }}" required />
                                    @if ($errors->has('priority'))
                                        <span class="error validation">{{ $errors->first('priority') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea type="text" class="form-control" id="description_id" name="description">{{ $package->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Price <span class="mandatorStar">*</span></label>
                                        <input type="text" class="form-control"
                                            onkeypress="return onlyNumberKey(event)" id="price_id" name="price"
                                            value="{{ $package->price }}">
                                        <div id="priceHelp" class="form-text">
                                            @if ($errors->has('price'))
                                                <span class="error validation">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Discount Percentage</label>
                                        <input type="text" class="form-control"
                                            onkeypress="return onlyNumberKey(event)" id="discount_percentage_id"
                                            name="discount_percentage" value="{{ $package->discount_percent }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Discount Amount</label>
                                        <input type="text" class="form-control"
                                            onkeypress="return onlyNumberKey(event)" id="discount_amount_id"
                                            name="discount_amount" value="{{ $package->discount_price }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Grand Total</label>
                                        <input type="text" class="form-control" id="grandTotal_id"
                                            name="grand_total" value="{{ $package->grand_total }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Discount Start Date</label>
                                        <input type="date" class="form-control" id="dicount_s_date_id"
                                            name="discount_s_date" value="{{ $package->discount_s_date }}">
                                    </div>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Discount End Date</label>
                                        <input type="date" class="form-control" id="discount_e_date_id"
                                            name="discount_e_date" value="{{ $package->discount_e_date }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col col-sm-6" id="imgField">
                                    <div class="mb-3">
                                        <label class="form-label"> Image </label>
                                        <input type="file" class="form-control" id="img_file_id"
                                            name="image_file[]" value="{{ old('image_file') }}" multiple>
                                        <div id="priceHelp" class="form-text">
                                            @if ($errors->has('image_file'))
                                                <span
                                                    class="error validation">{{ $errors->first('image_file') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-md-12">
                                <div class="card">
                                    <div class="pb-0 p-4">
                                        <h4>Package Image</h4>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($package->getPackageImage as $key => $packImg)
                                            <img src="{{ asset('storage/' . $packImg->package_image) }}"
                                                value={{ $packImg->id }} class="mt-4 multipleImgedit">
                                            <a href="{{ url('/admin/packages/package/packImg/delete', $packImg->id) }}"
                                                onclick="return confirm('Are you sure? Do you want to delete this image');">
                                                <i class='fa fa-times deletepackgeImgae'></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="addtocart float-right mt-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#city_id').on('change', function() {
                var city_id = this.value;
                // console.log(city_id);
                $.ajax({
                    url: "{{ url('admin/master/getLocation') }}",
                    method: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "city_id": city_id
                    },
                    success: function(data) {
                        $('#location_id').empty();
                        var options = '<option value="">Select Location</option>';
                        data.forEach(function(location) {
                            options += '<option value="' + location.id + '">' + location.name +
                                '</option>';
                        });
                        $('#location_id').append(options);
                    }
                });
            });
            $("#location_id").on('change', function() {
                var location_id = this.value;
                $.ajax({
                    url: "{{ url('/admin/master/getScreen') }}",
                    method: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "location_id": location_id
                    },
                    success: function(data) {
                        $('#screen_id').empty();
                        var options = '<option value="">Select Screen</option>';
                        data.forEach(function(screen) {
                            options += '<option value="' + screen.id + '">' + screen.screen_name +
                                '</option>';
                        });
                        $('#screen_id').append(options);
                    }
                });
            });
        </script>
        <script>
            // function for slug the input field data
            $("#title_id").on('keyup', function() {
                var title = $("#title_id").val();
                var slug_id = document.getElementById('slug_id');
                const replacedValue = title.replaceAll(' ', '-');
                slug_id.value = replacedValue.toLowerCase();
            });

            // function for preview the image
            img_file_id.onchange = evt => {
                preview = document.getElementById('preview_id');
                preview.style.display = 'block';
                const [file] = img_file_id.files
                if (file) {
                    preview.src = URL.createObjectURL(file)
                }
            }

            // calculate discount percentage
            $("#discount_percentage_id").on('changes blur', function() {
                var real_price = $("#price_id").val();
                var discount_percent = $("#discount_percentage_id").val();
                var discount_amount = ((real_price * discount_percent) / 100).toFixed(2);
                var grand_amount = (real_price - discount_amount).toFixed(2);
                $("#discount_amount_id").val(Math.round(discount_amount));
                $("#grandTotal_id").val(Math.round(grand_amount));
                // console.log(discount_amount);
            });

            // text editor for description
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
