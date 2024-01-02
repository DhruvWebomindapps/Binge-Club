<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Location Edit
                        </h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="true" id="isEdit">
                        <form action="{{ url('admin/master/location/' . $location->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" value="{{ $location->user_id }}" name="user_id">
                            <div class=" row">
                                <div class="col-lg-6">
                                    <label for="exampleInputEmail1" class="form-label">Select State <span
                                            class="mandatorStar">*</span></label>
                                    <select class="form-select" name="state_id" id="state_id"
                                        aria-label="Default select example" required>
                                        {{-- <option value="">Select state</option> --}}
                                        @foreach ($state_lists as $list)
                                            <option value="{{ $list->id }}"
                                                @if ($list->id == $location->state_id) selected @endif>{{ $list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="error validation">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label for="exampleInputEmail1" class="form-label">Select City <span
                                            class="mandatorStar">*</span></label>
                                    <select class="form-select" name="city_id" id="city_id"
                                        aria-label="Default select example" required>
                                        @foreach ($city_lists as $ct_list)
                                            <option value="{{ $ct_list->id }}"
                                                @if ($ct_list->id == $location->city_id) selected @endif>{{ $ct_list->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="error validation">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6 ">
                                    <label for="exampleInputEmail1" class="form-label">Location Name <span
                                            class="mandatorStar">*</span></label>
                                    <input type="text" value="{{ $location->name }}" class="form-control"
                                        id="locationName_id" name="locationName" required>
                                    @if ($errors->has('locationName'))
                                        <span class="error validation">{{ $errors->first('locationName') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6 ">
                                    <label class="form-label">Admin Name <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="adminName_id" name="admin_name"
                                        value="{{ $location->admin_name }}" aria-describedby="emailHelp" required>
                                    @if ($errors->has('admin_name'))
                                        <span class="error validation">{{ $errors->first('admin_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-ms-6">
                                    <label class="form-label">Admin Phone N0. <span
                                            class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control"
                                        id="adminPhone_id"value="{{ $location->admin_phone }}" name="admin_phone"
                                        aria-describedby="emailHelp" required maxlength="10"
                                        onkeypress="return onlyNumberKey(event)">
                                    @if ($errors->has('admin_phone'))
                                        <span class="error validation">{{ $errors->first('admin_phone') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-6">
                                    <label class="form-label">Admin Email Address <span
                                            class="mandatorStar">*</span></label>
                                    <input type="email" class="form-control" value="{{ $location->admin_email }}"
                                        id="admin_email_id" name="admin_email" aria-describedby="emailHelp" required>
                                    @if ($errors->has('admin_email'))
                                        <span class="error validation">{{ $errors->first('admin_email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-ms-6">
                                    <label class="form-label"> Password <span class="mandatorStar">*</span></label>
                                    <i class="material-icons btn" id="togglePassword">visibility_off</i>
                                    <input type="password" class="form-control" id="password_id" name="password"
                                        value="{{ old('password') }}">
                                    @if ($errors->has('password'))
                                        <span class="error validation">{{ $errors->first('password') }}</span>
                                    @endif
                                    <span class="error validation" id="missmatch"></span>
                                </div>
                                <div class="col col-ms-6">
                                    <label class="form-label">Confirm Password <span
                                            class="mandatorStar">*</span></label>
                                    <i class="material-icons btn" id="togglePassword2">visibility_off</i>
                                    <input type="password" class="form-control" id="confirm_password_id"
                                        name="confirm_password" value="{{ old('confirm_password') }}">
                                    @if ($errors->has('confirm_password'))
                                        <span class="error validation">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col col-md-4">
                                    <label for="exampleInputEmail1" class="form-label"> Image </label>
                                    <input class="form-control" type="file" name="file_image"
                                        value="{{ old('file_image') }}" id="formFile" />
                                    @if ($errors->has('file_image'))
                                        <span class="error validation">{{ $errors->first('file_image') }}</span>
                                    @endif
                                    <img class="mt-2" src="{{ asset('/storage/' . $location->icon_img) }}"
                                        width="100px" height="50px" />
                                </div>
                                <div class="col col-md-4">
                                    <label class="form-label">Land Mark <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="landmark_id" name="landmark"
                                        value="{{ $location->landmark }}" required>
                                    @if ($errors->has('landmark'))
                                        <span class="error validation">{{ $errors->first('landmark') }}</span>
                                    @endif
                                </div>
                                <div class="col col-md-4">
                                    <label class="form-label">Pincode <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" id="picode_id" name="pincode"
                                        value="{{ $location->pincode }}" required maxlength="6"
                                        onkeypress="return onlyNumberKey(event)">
                                    @if ($errors->has('pincode'))
                                        <span class="error validation">{{ $errors->first('pincode') }}</span>
                                    @endif
                                </div>
                                <div class="col col-12 mt-2">
                                    <label class="form-label">Full Address
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <textarea name="address" id="address_id" cols="15" rows="5">{!! $location->address !!}</textarea>
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
                        console.log(data);
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
        </script>
    @endpush
</x-admin-layout>
