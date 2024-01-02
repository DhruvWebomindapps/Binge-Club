<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/checkout.css') }}">
    @endpush
    <style>
        .knowmorbtn {
            background: linear-gradient(92deg, #FF0059 -2.4%, #FF144C 9.34%, #FF472C 42.87%, #FF6C14 72.14%, #FF8305 95.69%, #FF8B00 110.57%);
        }
    </style>
    <section class="ptb pco bg-theme">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order_status">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2><b>Add Ons</b></h2>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                aria-controls="pills-home" aria-selected="true">Cake</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-Bouquet-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-Bouquet" type="button" role="tab"
                                                aria-controls="pills-Bouquet" aria-selected="false">Bouquet</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-contact" type="button" role="tab"
                                                aria-controls="pills-contact" aria-selected="false">Gifts</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-profile" type="button" role="tab"
                                                aria-controls="pills-profile" aria-selected="false">Decorations</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-Snacks-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-Snacks" type="button" role="tab"
                                                aria-controls="pills-Snacks" aria-selected="false">Snacks</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-Other-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-Other" type="button" role="tab"
                                                aria-controls="pills-Other" aria-selected="false">Others</button>
                                        </li>
                                        {{-- <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-refund-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-refund" type="button" role="tab"
                                                aria-controls="pills-refund" aria-selected="false">Summary</button>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        @foreach ($location->cakes as $item)
                                            <div class="col-lg-3 col-6 mb-4">
                                                {{--  selected --}}
                                                <div class="food-category item" data-type="cakes"
                                                    data-id="{{ $item->id }}"data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 mt-4 mx-auto">
                                            <div class="input-group_1">
                                                <i class="fal fa-user"></i>
                                                <input type="text" placeholder="Name" id="nick_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-Bouquet" role="tabpanel"
                                    aria-labelledby="pills-Bouquet-tab">
                                    <div class="row">
                                        @foreach ($location->bouquets as $item)
                                            <div class="col-lg-3 col-6">
                                                <div class="food-category item" data-type="bouquets"
                                                    data-id="{{ $item->id }}"data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="row">
                                        @foreach ($location->gifts as $item)
                                            <div class="col-lg-3 col-6">
                                                <div class="food-category item" data-type="gifts"
                                                    data-id="{{ $item->id }}"data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="row">
                                        @foreach ($location->decorations as $item)
                                            <div class="col-lg-4 col-6">
                                                <div class="food-category item" data-type="decorations"
                                                    data-id="{{ $item->id }}"data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                        <button
                                                            class="knowmorbtn btn btn-sm text-white mt-2">Know
                                                            more</button>
                                                        <p class="item-desc mt-1" style="display: none;">
                                                            {{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-Snacks" role="tabpanel"
                                    aria-labelledby="pills-Snacks-tab">
                                    <div class="row">
                                        @foreach ($location->snacks as $item)
                                            <div class="col-lg-3 col-6">
                                                <div class="food-category item" data-type="snacks"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-Other" role="tabpanel"
                                    aria-labelledby="pills-Other-tab">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <h4>Do you want any of the special addOns in your list</h4>
                                            <p>We will send google form link via mail, there you can upload your videos
                                                and images.</p>
                                        </div>
                                        @foreach ($location->others as $item)
                                            <div class="col-lg-3 col-6">
                                                <div class="food-category item" data-type="others"
                                                    data-id="{{ $item->id }}"data-name="{{ $item->title }}"
                                                    data-price="{{ $item->price }}">
                                                    <div class="food-img">
                                                        <img src="{{ asset('storage/' . $item->icon) }}"
                                                            class="img-fluid" alt="">
                                                    </div>
                                                    <div class="food-desc">
                                                        <p class="fd-title">{{ $item->title }}</p>
                                                        <p class="fw-semibold mb-0">₹{{ $item->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- <div class="row">
                                        <button class="nextButton book-now1 mx-auto mt-4">
                                            Next
                                            <div class="arrow-wrapper">
                                                <div class="arrow"></div>
                                            </div>
                                        </button>
                                    </div> --}}
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="item-card">
                                <h5 class="mt-4">Selected Items</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item Type</th>
                                            <th>Items Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected_items">
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                No Items Selected
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-summary">
                        <input type="hidden" id="grand_total" value="{{ $booking->grand_total_amount }}">
                        <input type="hidden" id="slot_price" value="{{ $booking->time_slot_amount }}">
                        <h5>Order Summary</h5>
                        <div>
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Slot Price</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold">₹{{ $booking->time_slot_amount }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Additional People Amount</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold">₹{{ $booking->additional_amount }}</p>
                                </div>
                            </div>
                        </div>
                        <div id="cakes-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Cakes</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="cake_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div id="bouquets-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Bouquets</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="bouquet_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div id="gifts-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Gifts</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="gift_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div id="decorations-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Decorations</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="decoration_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div id="snacks-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Snacks</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="snack_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div id="others-col" style="display: none">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Others</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold" id="other_total">₹0</p>
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <p>Total</p>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="grand-total">₹{{ $booking->grand_total_amount }}</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="total_amount" value="{{ $booking->grand_total_amount }}">
                        <button id="submit_btn" class="book-btn border-0">
                            Pay <span class="grand-total">₹{{ $booking->grand_total_amount }} </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('frontend/js/checkout.js') }}"></script>
        <script>
            $('#submit_btn').on('click', function() {
                let total = $('input[name="total_amount"]').val();
                let booking_id = $('input[name="booking_id"]').val();
                let nick_name = $('#nick_name').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{ route('booking.addons', $booking->id) }}",
                    data: {
                        booking_id: booking_id,
                        total_amount: total,
                        items: allitems,
                        nick_name: nick_name,
                    },
                    success: function(response) {
                        if (response.success) {
                            let paymentUrl = window.location.origin + "/initiate-payment/" + booking_id;
                            window.location.href = paymentUrl;
                        } else {
                            alert("something went wrong");
                        }
                    }
                });
            });
            $('.knowmorbtn').on('click', function() {
                var itemDesc = $(this).closest('.food-category').find('.item-desc');
                if (itemDesc.css('display') === 'none') {
                    $(this).text('Know less');
                    itemDesc.css('display', 'block');
                } else {
                    $(this).text('Know more');
                    itemDesc.css('display', 'none');
                }
            });
        </script>
    @endpush
</x-home-layout>
