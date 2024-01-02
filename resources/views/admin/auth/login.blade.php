<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin-login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .login-form-page{
        width:100%;
        height:100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-form-page .content-wrapper{
        margin-top:-80px;
    }

    .bg-theme {
        background-color: #80000020;
    }
    .login-card {
        border-radius: 8px;
        transition: .25s;
        padding: 40px 50px 20px 50px;
        border: none;
        background-color: #fff;
    }

    .login-card:hover {
        transition: .25s;
    }

    .login-form-logo {
        display: flex;
        justify-content: center;
        margin-bottom: 15px;
    }

    .login-form-logo a {
        text-align: center;
    }

    .login-form-logo img {
        width: 40%;
        height: auto;
    }

    .login-card h3 {
        font-size: 28px;
        font-weight: 700;
        text-align:center;
    }


    .login-btn-group {
        display: flex;
        justify-content: space-between;
    }

    .facebook-btn-login,
    .google-btn-login {

        border: 2px solid #3e3e3e;
        padding: 14px 15px 10px 15px;
        border-radius: 8px;
        font-size: 13px;

    }

    .google-btn-login img {
        width: 15px;
    }

    .facebook-btn-login img {
        width: 15px;
    }

    .or-text {
        text-align: center;
        padding: 30px 0px 0px 0px;
        margin-right: 20px;
    }

    .login-form-section .form-group {
        padding: 0px 0px 10px 0px;
    }

    .login-form-section form label {
        font-size: 14px;
        padding:0px 10px;
    }

    .login-form-section form input {
        background-color: #E0E0E0;
        border: none;
        transition: .25s;
        border-radius: 30px;
        margin-top: 10px;
        padding: 12px 12px 12px 20px;
        font-size: 14px;
    }

    .login-form-section form input:focus {
        box-shadow: none;
        background-color: #E0E0E0;
    }

    .login-form-section form .form-check-label {
        font-size: 14px;
        margin: 10px 0px 0px 4px;
    }

    .login-form-section form .forgot-text {
        font-size: 14px;
        color: #000;
    }

    .login-page-btn {
        width: 100%;
        background:linear-gradient( 92deg, #ff0059 -2.4%, #ff144c 9.34%, #ff472c 42.87%, #ff6c14 72.14%, #ff8305 95.69%, #ff8b00 110.57% );
        margin-top: 15px;
        padding:10px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        border: none;
    }

    .login-bottom-part a {
        color: #FFAC0D;
    }

    .login-bottom-part {
        text-align: center;
        margin-top: 20px;
    }

    .fa-eye,.fa-eye-slash {
        position: absolute;
        top: 55%;
        right: 4%;
        cursor: pointer;
        color: #292929;
    }

    .password-input {
        position: relative;
    }

    /* mobile responsive */

    @media only screen and (max-width: 600px) {

        .login-form-logo img {
            width: 40%;
            height: auto;
        }

        .login-card {
            padding: 30px 25px 30px 25px;
        }

        .login-btn-group {
            row-gap: 20px;
        }

        .login-btn-group button {
            width: 100%;
        }

        .remember-forgot-text .form-check .form-check-label {
            font-size: 13px;
        }

        .remember-forgot-text .forgot-text {
            font-size: 13px !important;
        }

    }

    /* #password_eye {
        position: relative;
        top: -30px;
        left: 400px;
    } */
</style>

<body class="bg-theme">
    <section class="login-form-page">
        <div class="container content-wrapper">
            <div class="row mt-5">
                <div class="col-lg-5 mx-auto">

                    <div class="login-form-logo mb-4">
                        <img src="{{ asset('frontend/assets/image/home/logo.svg') }}" alt="logo"
                            class="img-fluid">
                    </div>
                    <div class="login-card">
                        <!--  -->
                        <div class="mb-4">
                            <h3>Login</h3>
                        </div>
                        <!--  -->


                        <div class="login-form-section">
                            <form action="{{ route('login') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input class="form-control text-input-filed" name="email" type="tel" id="name"
                                        value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <li style="color:red;">{{ $errors->first('email') }}</li>
                                    @endif
                                </div>

                                <div class="form-group password-input">
                                    <label for="password">Password:</label>
                                    <input class="form-control inpSp" type="password" name="password" id="password"
                                        value="{{ old('password') }}">
                                    <i class="fas fa-eye" id="password_eye"></i>
                                    @if ($errors->has('password'))
                                        <li style="color:red;">{{ $errors->first('password') }}</li>
                                    @endif
                                </div>

                                <div class="remember-forgot-text">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                {{-- <input class="form-check-input" name="remeberme" type="checkbox"
                                                    value="" id="invalidCheck"> --}}
                                                {{-- <label class="form-check-label" for="invalidCheck">
                                                    Remember Me
                                                </label> --}}
                                            </div>
                                        </div>

                                        <div class="col-6 text-end mt-2">
                                            <a href="{{ route('password.request') }}" class="forgot-text">Forgot
                                                Password</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="login-page-btn" type="submit">Login</button>

                            </form>

                            <div class="login-bottom-part">

                                {{-- <span>create account <a href="{{ url('register') }}">Sign up</a></span> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#password_eye").on('click', function() {
                var input = $("#password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $(this).addClass('fa-eye-slash').removeClass('fa-eye');
                } else {
                    input.attr("type", "password");
                    $(this).addClass('fa-eye').removeClass('fa-eye-slash');
                }
            });
        })
    </script>
</body>

</html>
