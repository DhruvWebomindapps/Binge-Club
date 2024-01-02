<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4 mt-2">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Screen Create
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/screen') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class=" row mt-2">
                                <div class="col col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Select State
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="state_id" id="state_id"
                                        aria-label="Default select example" required>
                                        {{-- <option value="">Select State</option> --}}
                                        @foreach ($state_lists as $list)
                                            <option value="{{ $list->id }}"
                                                @if (old('state_id') == $list->id) selected @endif>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="error validation">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">Select City
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="city_id"
                                        aria-label="Default select example" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="error validation">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-4">
                                    <label for="exampleInputEmail1" class="form-label">Select Location
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="location_id" id="location_id"
                                        aria-label="Default select example" required>
                                        <option value="">Select Location</option>
                                    </select>
                                    @if ($errors->has('location_id'))
                                        <span class="error validation">{{ $errors->first('location_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-md-4">
                                    <label class="form-label">Screen Name <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="screen_id" name="screen_name"
                                        value="{{ old('screen_name') }}" required>
                                    @if ($errors->has('screen_name'))
                                        <span class="error validation">{{ $errors->first('screen_name') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-2">
                                    <label class="form-label">Allowed people <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="capacity_id" name="capacity" value="{{ old('capacity') }}" required>
                                    @if ($errors->has('capacity'))
                                        <span class="error validation">{{ $errors->first('capacity') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-2">
                                    <label class="form-label">Capacity <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="max_people" name="max_people" value="{{ old('max_people') }}" required>
                                    @if ($errors->has('max_people'))
                                        <span class="error validation">{{ $errors->first('max_people') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-4">
                                    <label class="form-label">Select Images <span class="mandatorStar">*</span></label>
                                    <input type="file" class="form-control" id="file_image_id" name="file_image[]"
                                        value="{{ old('file_image') }}" multiple required>
                                    @if ($errors->has('file_image'))
                                        <span class="error validation">{{ $errors->first('file_image') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label for="">Calendar Id</label>
                                    <input type="text" name="calendar_id" class="form-control">
                                    @if ($errors->has('calendar_id'))
                                        <span class="error validation">{{ $errors->first('calendar_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col col-md-6">
                                    <label class="form-label">Full Address <span class="mandatorStar">*</span></label>
                                    <textarea class="form-control" id="address_id" name="address" value="{{ old('address') }}" required rows="5"
                                        cols="50"></textarea>
                                    @if ($errors->has('address'))
                                        <span class="error validation">{{ $errors->first('address') }}</span>
                                    @endif

                                </div>
                                <div class="col col-md-6">
                                    <label class="form-label">Description <span class="mandatorStar">*</span></label>
                                    <textarea class="form-control" id="description" name="description" value="{{ old('description') }}" required
                                        rows="5" cols="50"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="error validation">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2 mb-4 mt-4">
                                <div class="col col-md-12">
                                    <div class="card">
                                        <div class="p-4 pb-0">
                                            <h4>Slot</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>
                                                            slots
                                                        </th>
                                                        {{-- <th>
                                                            <input type="checkbox" id="allDay" name="forAll">
                                                        </th> --}}
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
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Slots</th>
                                                        <th><button class="btn btn-primary slotConst create"
                                                                type="button"><i class="fa fa-plus"></i></button>
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
                                                            <button class="btn btn-primary create" type="button"
                                                                id="addScreenFeatures">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-section-feature">
                                                    <tr id="tr-section">
                                                        <td colspan="6">
                                                            <input type="text" class="form-control"
                                                                name="title[0]" required
                                                                value="{{ old('title[0]') }}" placeholder="Feature">
                                                            @if ($errors->has('title.*'))
                                                                <span
                                                                    class="error validation">{{ $errors->first('title.*') }}</span>
                                                            @endif
                                                        </td>
                                                        <td colspan="3">
                                                            <select name="status[0]" class="form-select">
                                                                <option value="1">Active</option>
                                                                <option value="0">not Active</option>
                                                            </select>
                                                            @if ($errors->has('status.*'))
                                                                <span
                                                                    class="error validation">{{ $errors->first('status.*') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
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
        </script>
        <script>
            $(document).ready(function() {
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
        </script>
        <script>
            $(document).ready(function() {
                // start password hide and show
                var password = document.querySelector('#password_id');
                var visibility = document.querySelector('#togglePassword');

                let is_show = true;
                visibility.addEventListener('click', function() {
                    if (is_show) {
                        password.setAttribute('type', 'text');
                        visibility.innerHTML = 'visibility';
                    } else {
                        password.setAttribute('type', 'password');
                        visibility.innerHTML = 'visibility_off';
                    }
                    is_show = !is_show;
                });


                var confirm_password = document.querySelector('#confirm_password_id');
                var confirm_pass_visible = document.querySelector('#togglePassword2');

                let is_show2 = true;
                confirm_pass_visible.addEventListener('click', function() {
                    if (is_show2) {
                        confirm_password.setAttribute('type', 'text');
                        confirm_pass_visible.innerHTML = 'visibility';
                    } else {
                        confirm_password.setAttribute('type', 'password');
                        confirm_pass_visible.innerHTML = 'visibility_off';
                    }
                    is_show2 = !is_show2;
                });
                // end

                // matching the password
                $('#confirm_password_id').on('change', function() {
                    var missmatch = document.getElementById('missmatch');
                    var password = document.getElementById('password_id').value;
                    var confirm_password = document.getElementById('confirm_password_id').value;
                    if (password == confirm_password) {
                        missmatch.innerHTML = ""
                        return true;
                    } else {
                        missmatch.innerHTML = "password and confirm password missmatch";
                        return false;
                    }
                });
            });


            function onlyNumberKey(evt) {
                // Only ASCII character in that range allowed
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                    return false;
                return true;
            }
            $("#addScreenFeatures").on('click', function() {
                console.log("clicked");
                var option =
                    '<tr id="tr-section"><td colspan="6"><input type="text" class="form-control end_Time_id" name="title[]" required placeholder="feature"></td><td colspan="3"><select name="status[]" class="form-select"><option value="1" selected>Active</option><option value="0">not Active</option></select></td><td><button class="btn btn-danger removeFeatureField" type="button">X</button></td></tr>';
                $(".tbody-section-feature").append(option);
            });

            // remove the features field
            $(document).on('click', '.removeFeatureField', function() {
                $(this).parents('tr').remove();
            });
        </script>
    @endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('backend/js/screen.js') }}"></script>
</x-admin-layout>
