<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Bouquet Create
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/bouquet') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class=" row mt-3">
                                    <div class="col col-lg-6">
                                        <label class="form-label">Select City
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <select class="form-select" aria-label="Default select example" name="city_id"
                                            id="city_id">
                                            <option value="" selected>Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('city_id'))
                                            <span class="error validation">{{ $errors->first('city_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col col-lg-6">
                                        <label class="form-label">Select Location
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <select class="form-select" aria-label="Default select example"
                                            name="location_id" id="location_id">
                                            <option value="">Select Location</option>
                                        </select>
                                        @if ($errors->has('location_id'))
                                            <span class="error validation">{{ $errors->first('location_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class=" row mt-3">
                                    <div class="col col-lg-6">
                                        <label class="form-label">Name <span class="mandatorStar">*</span></label>
                                        <input type="text" class="form-control" id="name_id" name="title"
                                            value="{{ old('title') }}" required>
                                        @if ($errors->has('title'))
                                            <span class="error validation">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="col col-lg-6">
                                        <label class="form-label">Price <span class="mandatorStar">*</span></label>
                                        <input type="text" class="form-control"
                                            onkeypress="return onlyNumberKey(event)" id="price_id" name="price"
                                            value="{{ old('price') }}" required />
                                        @if ($errors->has('price'))
                                            <span class="error validation">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-6">
                                        <label class="form-label">Select Image
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <input type="file" class="form-control" id="slug_id" name="icon"
                                            value="{{ old('image') }}" required />
                                        @if ($errors->has('icon'))
                                            <span class="error validation">{{ $errors->first('icon') }}</span>
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
                            </div>
                            <button class="addtocart float-right" type="submit">Save</button>
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
        </script>
    @endpush
</x-admin-layout>
