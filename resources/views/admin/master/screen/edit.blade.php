<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Screen Edit
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/screen/' . $screen->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" name="screen_id" id="id_screen" value="{{ $screen->id }}" />
                            <input type="hidden" name="deleted_slots" id="deleted_slots" />
                            <input type="hidden" name="deleted_constraint" id="deleted_constraint" />
                            <div class=" row">
                                <div class="col col-ms-6">
                                    <input type="hidden" id="isEdit" value="{{ true }}">
                                    <label for="exampleInputEmail1" class="form-label">Select State
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="state_id" id="state_id"
                                        aria-label="Default select example" required>
                                        @foreach ($state_lists as $list)
                                            <option value="{{ $list->id }}"
                                                @if ($list->id == $screen->state_id) selected @endif>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="error validation">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-6">
                                    <label for="exampleInputEmail1" class="form-label">Select City
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="city_id"
                                        aria-label="Default select example" required>
                                        <option value="">Select City</option>
                                        @foreach ($city_lists as $c_list)
                                            <option value="{{ $c_list->id }}"
                                                {{ $c_list->id == $screen->city_id ? 'selected' : '' }}>
                                                {{ $c_list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="error validation">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col col-ms-6">
                                    <label for="exampleInputEmail1" class="form-label">Select Location
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select " name="location_id" id="location_id"
                                        aria-label="Default select example" required>
                                        <option value="">Select Location</option>
                                        @foreach ($location_lists as $lc_list)
                                            <option value="{{ $lc_list->id }}"
                                                @if ($lc_list->id == $screen->location_id) selected @endif>{{ $lc_list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('location_id'))
                                        <span class="error validation">{{ $errors->first('location_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-6">
                                    <label class="form-label">Screen Name <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="screen_id" name="screen_name"
                                        value="{{ $screen->screen_name }}" aria-describedby="emailHelp" required>
                                    @if ($errors->has('screen_name'))
                                        <span class="error validation">{{ $errors->first('screen_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-ms-3">
                                    <label class="form-label">Allowed people <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="capacity_id" name="capacity"
                                        value="{{ $screen->capacity }}" onkeypress="return onlyNumberKey(event)"
                                        required>
                                    @if ($errors->has('capacity'))
                                        <span class="error validation">{{ $errors->first('capacity') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-3">
                                    <label class="form-label">Capacity <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="max_people" name="max_people" value="{{ $screen->max_people }}" required>
                                    @if ($errors->has('max_people'))
                                        <span class="error validation">{{ $errors->first('max_people') }}</span>
                                    @endif
                                </div>
                                <div class="col col-sm-6">
                                    <label class="form-label">Select Images</label>
                                    <input type="file" class="form-control" id="file_image_id" name="file_image[]"
                                        multiple>
                                    @if ($errors->has('file_image'))
                                        <span class="error validation">{{ $errors->first('file_image') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label for="">Calendar Id</label>
                                    <input type="text" name="calendar_id" class="form-control"
                                        value="{{ $screen->calendar_id }}">
                                    @if ($errors->has('calendar_id'))
                                        <span class="error validation">{{ $errors->first('calendar_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-ms-6">
                                    <label class="form-label">Full Address <span class="mandatorStar">*</span></label>
                                    <textarea class="form-control" id="address_id" name="address" value="" required rows="5"
                                        cols="50">{{ $screen->address }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="error validation">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-6">
                                    <label class="form-label">Description <span class="mandatorStar">*</span></label>
                                    <textarea class="form-control" id="description" name="description" required rows="5" cols="50">{{ $screen->description }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col col-md-12">
                                    <div class="card">
                                        <div class="p-4 pb-0">
                                            <h4>Screen Icon</h4>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($screen->getScreenImages as $screenImg)
                                                <div class="" style="position: relative;">
                                                    <img src="{{ asset('storage/' . $screenImg->screen_icon) }}"
                                                        alt="ScreenImage" class="multipleImgedit mt-4" />
                                                    <a href="{{ url('admin/master/screen_img/delete', $screenImg->id) }}"
                                                        onclick="return confirm('Are you sure? Do you want to delete slected Image');">
                                                        <i class='fa fa-times deletepackgeImgae'></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col col-md-12">
                                    <div class="card">
                                        <div class="p-4 pb-0">
                                            <h4>Slots</h4>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="existing_slots"
                                                value="{{ json_encode($screen->days) }}" id="existing_slots">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>
                                                            slots
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-section" id="screen-slots-table">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 mb-4 mt-4">
                                <div class="col col-md-12">
                                    <div class="card">
                                        <div class="p-4 pb-0">
                                            <h4>Slot Constrained</h4>
                                            <input type="hidden" name="existing_constrained"
                                                value="{{ json_encode($screen->constraints) }}"
                                                id="existing_constrained">
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Slots</th>
                                                        <th>
                                                            <button class="btn btn-primary slotConst create" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-section" id="screen-constrained-table">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 mb-4 mt-4">
                                <div class="col col-md-12">
                                    <div class="card">
                                        <div class="p-4 pb-0">
                                            <h4>Feature</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        {{-- <th colspan="3">Icon</th> --}}
                                                        <th colspan="6">Title</th>
                                                        <th colspan="3">Status</th>
                                                        <th colspan="3">
                                                            <button class="btn btn-primary create"
                                                                id="dynamicFeatureModal" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-section-feature">
                                                    @foreach ($screen->getFeatures as $feature)
                                                        <tr id="tr-section">
                                                            {{-- <td colspan="3">
                                                            <img src="{{ asset('storage/'.$feature->icon) }}" class="rounded" height="60px" width="70px" alt="">
                                                        </td> --}}
                                                            <td colspan="6">
                                                                <input type="text" class="form-control"
                                                                    name="title[]" required
                                                                    value="{{ $feature->title }}">
                                                                @if ($errors->has('title.*'))
                                                                    <span
                                                                        class="error validation">{{ $errors->first('title.*') }}</span>
                                                                @endif
                                                            </td>
                                                            <td colspan="3">
                                                                <select name="status[]" class="form-select">
                                                                    <option value="1"
                                                                        {{ $feature->status == 1 ? 'selected' : '' }}>
                                                                        Active
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $feature->status == 0 ? 'selected' : '' }}>
                                                                        not
                                                                        Active
                                                                    </option>
                                                                </select>
                                                                @if ($errors->has('status.*'))
                                                                    <span
                                                                        class="error validation">{{ $errors->first('status.*') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('remove.feature', $feature->id) }}"
                                                                    onclick="return confirm('are you sure ? you want to delete')">
                                                                    <i class="fa fa-trash " style="color:red"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="addtocart float-right mt-4" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="screenFeatureAdd" tabindex="-1" aria-labelledby="featureAdd" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="addMoreTimeSlot" method="post" action="{{ route('screen.more-feature') }}">
                        @csrf
                        <input type="hidden" value="{{ $screen->id }}" name="screen_id" />
                        <div class="row mt-2">
                            <div class="col col-sm-12">
                                <label class="form-label mt-2">Feature</label>
                                <input type="text" class="form-control" name="title" required
                                    value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="error validation">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col col-sm-12">
                                <label class="form-label mt-2">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Not Active</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="error validation">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="addtocart float-end">Save </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $("#state_id").on('change', function() {
                var state_id = $("#state_id").val();
                $.ajax({
                    url: "{{ url('admin/master/getCity') }}",
                    method: "get",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "state_id": state_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#city_id').empty();
                        var options = '<option value="">Select city</option>';
                        data.forEach(function(city) {
                            options += '<option value="' + city.id + '">' + city.name + '</option>';
                        });
                        $('#city_id').append(options);
                    }
                });
            });
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
            $("#dynamicFeatureModal").on('click', function() {
                $("#screenFeatureAdd").modal('show');
            });
        </script>
    @endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('backend/js/screen.js') }}"></script>
</x-admin-layout>
