<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Profile
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.edit') }}" method="post">
                            @csrf
                            <div class=" row mt-3">
                                <div class="col col-lg-4">
                                    <label class="form-label">Name <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ auth()->user()->name }}" required>
                                    @if ($errors->has('name'))
                                        <span class="error validation">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="col col-lg-4">
                                    <label class="form-label">Phone <span class="mandatorStar">*</span></label>
                                    <input type="text" class="form-control" onkeypress="return onlyNumberKey(event)"
                                        id="price_id" name="phone" value="{{ auth()->user()->phone }}" required />
                                    @if ($errors->has('phone'))
                                        <span class="error validation">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="col col-lg-4">
                                    <label class="form-label">Email <span class="mandatorStar">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ auth()->user()->email }}" required />
                                    @if ($errors->has('email'))
                                        <span class="error validation">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
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
                            <button class="addtocart float-right mt-4" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
</x-admin-layout>
