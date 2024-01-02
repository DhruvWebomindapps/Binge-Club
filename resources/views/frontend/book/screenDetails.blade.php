<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/booking.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/packages.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/frontendStyle.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/calander.css') }}">
    @endpush
    <input type="hidden" id="selectedDate" class="selectedDate date_id" value="{{ date('Y-m-d') }}">
    <input type="hidden" id="screen_id" class="screen_id" value="{{ $screen->id }}">
    <input type="date" id="startDate" class="d-none date_id">
    <section class="pt-3 bg-theme">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-2 mb-correction">
                    <a title="Go back" href="{{ URL::previous() }}"
                        class="fw-semibold fs-5 text-decoration-none text-dark">
                        <i class="fas fa-chevron-left me-3"></i>Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 Decoration-tab-package">
                    @if (count($screen->getScreenImages) != 0)
                        <div class="custom-owl mb-4">
                            <div id="sync1" class="owl-carousel owl-theme">
                                @foreach ($screen->getScreenImages as $screenImg)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $screenImg->screen_icon) }}" class="img-fluid"
                                            alt="">
                                    </div>
                                @endforeach
                            </div>

                            <div id="sync2" class="owl-carousel owl-theme">
                                @foreach ($screen->getScreenImages as $screenImg)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $screenImg->screen_icon) }}" class="img-fluid"
                                            alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <h4>{{ $screen->screen_name }}</h4>
                    <p>{{ $screen ? $screen->description : '' }}</p>

                    <div class="row facility mt-4">
                        <div class="col-lg-12">
                            <div class="features">
                                @if (count($screen->getFeatures) != 0)
                                    @foreach ($screen->getFeatures as $key => $screenFeature)
                                        <p>{{ $screenFeature->title }}</p>
                                    @endforeach
                                @else
                                    <span>No any feature</span><br />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6  mb-4 mt-4 mt-lg-0">

                    <div class="row mb-4 custum-call">
                        <div class="callender">
                            <div class="dropdowns d-none">
                                <select id="yearSelect"></select>
                                <select id="monthSelect"></select>
                            </div>
                            <div class="row justify-content-center position-relative">
                                <div class="col-lg-12 mb-2">
                                    <div class="button-position position-relative">
                                        <button id="prevButton">
                                            <i class=" left-right-cal fas fa-chevron-left"></i>
                                        </button>
                                        <button id="nextButton">
                                            <i class="left-right-cal fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <div class="calendar" id="dateCalendar">
                                        <!-- Calendar items will be generated by JavaScript -->
                                    </div>
                                    <div class="col-lg-10 mb-4 mx-auto book_calender">
                                        <ul class=" pl-correction">
                                            <li class="">
                                                <i class="fas fa-square DisableColor"></i>
                                                &nbsp;
                                                Unavailable
                                            </li>
                                            <li class="">
                                                <i class="fas fa-square AvailableColor"></i>&nbsp;
                                                Available
                                            </li>
                                            <li>
                                                <i class="fas fa-square SelectedColor"></i>&nbsp;
                                                Selected
                                            </li>
                                        </ul>
                                    </div>
                                    <span id="date_error" style="color:red;"></span>
                                    <div class="reason-card mb-3">
                                        <p class="text-start text-black mt-4" style="font-weight:500; font: size 16px;">
                                            Pick a slot
                                        </p>
                                        <div class="row" id="slots">
                                            {{-- <div class="reason-box">
                                                <input type="checkbox" id="time" name="time"
                                                    value="Hidden Wall Bed">
                                                <label for="time">11:00 AM - 02:00 PM</label>
                                                <p>₹1000</p>
                                            </div> --}}
                                        </div>
                                        <span class="slot_error" style="color:red;"></span>
                                    </div>
                                    <form action="{{ route('getuserData') }}" method="GET" id="bookNowForm">
                                        <input type="hidden" name="location_id" value="{{ $screen->location_id }}">
                                        <input type="hidden" name="screen_id" id="screen_id"
                                            value="{{ $screen->id }}">
                                        <input type="hidden" name="date" id="screen_date"
                                            value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="slot_id" id="slot_id">
                                        <input type="hidden" name="slot_name" id="slot_name">
                                        <input type="hidden" name="slot_amount" id="slot_amount">
                                        <input type="hidden" name="additional_amount" id="additional_amount">
                                        <input type="hidden" name="capacity" id="capacity"
                                            value="{{ $screen->capacity }}" />
                                        <input type="hidden" name="max_people" id="max_people"
                                            value="{{ $screen->max_people }}" />
                                        <input type="hidden" name="selectedSlots" id="selectedSlots">
                                        <button type="button" id="submit_btn" class="addtocart mx-auto">Book Now
                                            <i class="ms-1 fas fa-ticket-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('.custom-dwm').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                dots: false,
                autoplay: true,
                navText: ["<div class='nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>",
                    "<div class='nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"
                ],
                responsive: {
                    0: {
                        items: 4
                    },
                    600: {
                        items: 4
                    },
                    768: {
                        items: 5
                    },
                    1000: {
                        items: 7
                    }
                }
            })
            $(document).ready(function() {
                var sync1 = $("#sync1");
                var sync2 = $("#sync2");
                var slidesPerPage = 4;
                var syncedSecondary = true;

                sync1
                    .owlCarousel({
                        items: 1,
                        slideSpeed: 2000,
                        nav: true,
                        autoplay: false,
                        dots: false,
                        loop: true,
                        responsiveRefreshRate: 200,
                        navText: ["<div class='nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>",
                            "<div class='nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"
                        ],
                    })
                    .on("changed.owl.carousel", syncPosition);

                sync2
                    .on("initialized.owl.carousel", function() {
                        sync2.find(".owl-item").eq(0).addClass("current");
                    })
                    .owlCarousel({
                        items: slidesPerPage,
                        dots: false,
                        nav: false,
                        smartSpeed: 200,
                        slideSpeed: 500,
                        slideBy: slidesPerPage,
                        responsiveRefreshRate: 100
                    })
                    .on("changed.owl.carousel", syncPosition2);

                function syncPosition(el) {

                    var count = el.item.count - 1;
                    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

                    if (current < 0) {
                        current = count;
                    }
                    if (current > count) {
                        current = 0;
                    }

                    //end block

                    sync2
                        .find(".owl-item")
                        .removeClass("current")
                        .eq(current)
                        .addClass("current");
                    var onscreen = sync2.find(".owl-item.active").length - 1;
                    var start = sync2.find(".owl-item.active").first().index();
                    var end = sync2.find(".owl-item.active").last().index();

                    if (current > end) {
                        sync2.data("owl.carousel").to(current, 100, true);
                    }
                    if (current < start) {
                        sync2.data("owl.carousel").to(current - onscreen, 100, true);
                    }
                }

                function syncPosition2(el) {
                    if (syncedSecondary) {
                        var number = el.item.index;
                        sync1.data("owl.carousel").to(number, 100, true);
                    }
                }

                sync2.on("click", ".owl-item", function(e) {
                    e.preventDefault();
                    var number = $(this).index();
                    sync1.data("owl.carousel").to(number, 300, true);
                });
            });
        </script>
        <script src="{{ asset('frontend/js/calander.js') }}"></script>
        <script src="{{ asset('frontend/js/booking.js') }}"></script>
        <script>
            $("#submit_btn").on('click', function() {
                var slot_id = $('#slot_id').val();
                var date = $('#screen_date').val();
                let amount = $('#slot_amount').val();

                $(".slot_error").html("");

                if (slot_id != '' && date != '') {
                    if (amount > 0 || amount != "0") {
                        $(".slot_error").empty();
                        $('#bookNowForm').submit();
                    } else {
                        $(".slot_error").append("Amount should be greater than 0");
                    }
                } else {
                    $(".slot_error").html("");
                    $(".slot_error").append("Please Select Time Slot");
                }
            });
        </script>
    @endpush
</x-home-layout>