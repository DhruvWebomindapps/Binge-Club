<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>Package Create</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/package') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label">Select City </label>
                                    <select class="form-select" name="city_id" id="city_id"
                                        aria-label="Default select example">
                                        <option value="">Select City</option>
                                        @foreach ($city_lists as $list)
                                            <option value="{{ $list->id }}"
                                                @if (old('city_id') == $list->id) selected @endif>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="error validation">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Select Location </label>
                                    <select class="form-select" name="location_id" id="location_id"
                                        aria-label="Default select example">
                                        <option value="">Select Location</option>
                                    </select>
                                    @if ($errors->has('location_id'))
                                        <span class="error validation">{{ $errors->first('location_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label ">Select Screen </label>
                                    <select class="form-select" name="screen_id" id="screen_id"
                                        aria-label="Default select example">
                                        <option value="">Select Screen</option>
                                    </select>
                                    @if ($errors->has('screen_id'))
                                        <span class="error validation">{{ $errors->first('screen_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label ">Title <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="title_id" name="title"
                                        value="{{ old('title') }}" required>
                                    @if ($errors->has('title'))
                                        <span class="error validation">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control bg-white" id="slug_id" name="slug"
                                        readonly value="{{ old('slug') }}">
                                    @if ($errors->has('slug'))
                                        <span class="error validation">{{ $errors->first('slug') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Priority</label>
                                    <input type="number" class="form-control" name="priority"
                                        value="{{ old('priority') }}" required />
                                    @if ($errors->has('priority'))
                                        <span class="error validation">{{ $errors->first('priority') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <label class="form-label">Description</label>
                                    {{-- <input type="text" class="form-control" id="description_id" name="description" value="{{old('description')}}" > --}}
                                    <textarea class="form-control" id="description_id" name="description" value="{{ old('description') }}"></textarea>

                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-lg-6">
                                    <label class="form-label">Price <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="price_id" name="price" value="{{ old('price') }}" required>
                                    <div id="priceHelp" class="form-text">
                                        @if ($errors->has('price'))
                                            <span class="error validation">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Discount Percentage</label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="discount_percentage_id" name="discount_percentage"
                                        value="{{ old('discount_amount') }}">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label">Discount Amount</label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="discount_amount_id" name="discount_amount"
                                        value="{{ old('discount_amount') }}" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Grand Total</label>
                                    <input type="text" class="form-control" id="grandTotal_id" name="grand_total"
                                        value="{{ old('grand_total') }}" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label">Discount Start Date</label>
                                    <input type="date" class="form-control" id="dicount_s_date_id"
                                        name="discount_s_date" value="{{ old('discount_s_date') }}"
                                        min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Discount End Date</label>
                                    <input type="date" class="form-control" id="discount_e_date_id"
                                        name="discount_e_date" value="{{ old('discount_e_date') }}"
                                        min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <label class="form-label">Image <span class="mandatorStar">*</span></label>
                                    <input type="file" class="form-control" id="img_file_id" name="image_file[]"
                                        value="{{ old('image_file') }}" multiple required>
                                    <div id="priceHelp" class="form-text">
                                        @if ($errors->has('image_file'))
                                            <span class="error validation">{{ $errors->first('image_file') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class=" addtocart float-right">Save</button>
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

            function onlyNumberKey(evt) {
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
                return true;
            }
        </script>
    @endpush
</x-admin-layout>
