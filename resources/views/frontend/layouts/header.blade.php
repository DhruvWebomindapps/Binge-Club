<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('home') }}" class="brand">
                    <img src="{{ asset('frontend/assets/image/home/logo.svg') }}" class="img-fluid" alt="">
                </a>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                <div class="location">
                    <img src="{{ asset('frontend/assets/image/home/location.svg') }}" alt="">
                    <select class="city-switcher">
                        @php
                            $cities = App\Models\City::where('status', 1)->get();
                        @endphp
                        @foreach ($cities as $city)
                            <option {{ request()->city == $city->id ? 'selected' : '' }} value="{{ $city->id }}">
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- <a href="Proceed-to-checkout.php">
                    <div class="cart-list">
                        <span class="text-white">Cart</span>
                        <img src="{{ asset('frontend/assets/image/home/cart.svg') }}" alt="">
                    </div>
                </a> --}}
            </div>
        </div>
    </div>
</div>
<header class="page-header">
    <div class="container">
        <div class="row px-0">
            <div class="col-lg-12 px-0">
                <div class="wrapper" id="menu-bar">
                    <div class="left-area col-lg-12 col-md-12 order-lg-1 order-2">
                        <a href="{{ route('home') }}" class="brand-mbl">
                            <img src="{{ asset('frontend/assets/image/home/white-logo.svg') }}" class="img-fluid"
                                alt="">
                        </a>
                        <div class="burger" id="burger">
                            <span class="burger-line"></span>
                            <span class="burger-line"></span>
                            <span class="burger-line"></span>
                        </div>

                        <span class="overlay">
                            <div class="close">
                                <i class="fas fa-times text-white"></i>
                            </div>
                        </span>

                        <nav class="navbar" id="navbar">
                            <a href="{{ route('home') }}" class="brand-nav">
                                <img src="{{ asset('frontend/assets/image/home/logo.svg') }}" class="img-fluid"
                                    alt="">
                            </a>

                            <ul class="menu" id="menu">
                                <li class="menu-item">
                                    <a href="{{ route('screen.list') }}" class="menu-link">Book now</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('about-us') }}" class="menu-link">About us</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('blogs') }}" class="menu-link">Blog</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('faq') }}" class="menu-link">FAQ</a>
                                </li>
                            </ul>
                        </nav>

                        <div class="mbl-left">
                            <div class="location">
                                <img src="{{ asset('frontend/assets/image/home/location.svg') }}" alt="">
                                <select class="city-switcher">
                                    @php
                                        $cities = App\Models\City::where('status', 1)->get();
                                        $city = request()->city;
                                    @endphp
                                    @foreach ($cities as $city)
                                        <option {{ request()->city == $city->id ? 'selected' : '' }}
                                            value="{{ $city->id }}">
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <a href="">
                                <div class="cart-list">
                                    <span class="text-white">Cart</span>
                                    <img src="{{ asset('frontend/assets/image/home/cart.svg') }}" alt="">
                                </div>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="current_route" value="{{ route('screen.list') }}">
</header>
@push('scripts')
    <script>
        $('.city-switcher').on('change', function(e) {
            let route_name = $('#current_route').val();
            let url = route_name + `?city=${e.target.value}`;
            window.location.href = url;
        })
    </script>
@endpush
