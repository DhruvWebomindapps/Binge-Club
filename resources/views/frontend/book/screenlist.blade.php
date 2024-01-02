<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/booking-theater.css') }}">
    @endpush
    <input type="hidden" id="current_route" value="{{ route('screen.list') }}">
    <input type="hidden" id="city" value="{{ request()->city }}">
    <section class="pt-3 bg-theme">
        <div class="container">
            <div class="row border-bottom pb-3">
                <div class="col-lg-6 my-auto">
                    <h4>Book Theater</h4>
                </div>
                <div class="col-lg-4 ms-auto col-sm-6 custom_dropDown">
                    <label for="">Theatre location</label>
                    <select class="single" id="location">
                        <option disabled><strong>Popular locations</strong></option>
                        @foreach ($locations as $location)
                            <option {{ request()->location == $location->id ? 'selected' : '' }}
                                value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5 bg-theme">
        <div class="container">
            @if (count($screens) > 0)
                <div class="row">
                    <div class="col-lg-12 pb-2 pt-2">
                        <h2>Choose your Theater</h2>
                    </div>
                    @foreach ($screens as $screen)
                        @php
                            $checkConstrainExist = \App\Models\ScreenConstrain::where('date', date('Y-m-d'))
                                ->where('screen_id', $screen->id)
                                ->first();

                            $checkSlotExist = \App\Models\ScreenDay::where('day', 'monday')
                                ->where('screen_id', $screen->id)
                                ->first();

                            $slots = [];

                            if ($checkConstrainExist) {
                                $slots = $checkConstrainExist->slots;
                            } elseif ($checkSlotExist) {
                                $slots = $checkSlotExist->slots;
                            }
                            $param = [
                                'screen_id' => $screen->id,
                                'date' => date('Y-m-d'),
                            ];
                            $timeSlotController = new \App\Http\Controllers\TimeSlotController();
                            $isActiveTrueCount = $timeSlotController->getSlotsCount($param);

                        @endphp
                        <div class="col-lg-4 mb-3">
                            <a href="{{ route('screen.details', $screen->id) }}">
                                <div class="theater_card">
                                    <div class="screen_img">
                                        @if ($screen)
                                            <div class="owl-carousel owl-theme screenImg">
                                                @foreach ($screen->getScreenImages as $screenImg)
                                                    <div class="item">
                                                        <img src="{{ asset('storage/' . $screenImg->screen_icon) }}"
                                                            class="img-fluid" alt="" style="height: 200px;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-lg-12">
                                            <h3 class="seat_info">{{ $screen->screen_name }}</h3>
                                        </div>
                                        <div class="col-lg-4 col-5">
                                            <p class="slot_price">₹
                                                @if (count($slots) > 0)
                                                    {{ $slots[0]->amount }}
                                                @else
                                                    0
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-lg-8 col-7 my-auto">
                                            <p class="capacity text-dark">
                                                <i class="far fa-users me-1"></i>
                                                {{ $screen->capacity }}-{{ $screen->max_people }} people
                                            </p>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="mt-1">
                                                <div class="book-now1">
                                                    Book Slot
                                                    <div class="arrow-wrapper">
                                                        <div class="arrow"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="">Theater Not Found</p>
            @endif
        </div>
    </section>
    @push('scripts')
        <script>
            function matchCustom(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined') {
                    return null;
                }
                if (data.text.indexOf(params.term) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += ' (matched)';
                    return modifiedData;
                }
                return null;
            }
            $(document).ready(function() {
                $('.single').select2({
                    placeholder: "Select Location",
                    allowClear: true,
                    matcher: matchCustom
                });
            });

            function getScreen() {
                console.log(event.target.value);
            }
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
                        items: 7
                    },
                    1000: {
                        items: 7
                    }
                }
            })
            $('.screenImg').owlCarousel({
                loop: true,
                margin: 0,
                nav: false,
                dots: false,
                autoplay: true,

                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            })
        </script>
        <script>
            $("#location").on('change', function() {
                var location = $(this).val();
                let route_name = $('#current_route').val();
                let url = route_name;
                let city = $('#city').val();
                if (city) {
                    url += `?city=${city}`
                    url += `&location=${location}`;
                } else {
                    url += `?location=${location}`;
                }
                console.log(route_name, url);
                window.location.href = url;
            });
        </script>
    @endpush
</x-home-layout>
