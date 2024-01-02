<x-admin-layout>
    <div class="container-fluid px-5">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="">
                    <div class="card-header">
                        <h4>Booking Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 booking_details">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Name</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Email</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Phone</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Location Name</label>
                                            <input type="text" class="form-control bg-white" id="location_id"
                                                value="{{ $booking->getLocation->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Screen Name</label>
                                            <input type="text" class="form-control bg-white" id="screen_id"
                                                value="{{ $booking->getScreen->screen_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Booking Date</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ \Carbon\Carbon::parse($booking->book_date)->format('d-m-Y') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Number of people</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->number_of_people }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Additional Price</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->additional_amount }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->status }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Payment Type</label>
                                            <input type="text" class="form-control bg-white"
                                                value="{{ $booking->payment_type }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Note</label>
                                            <textarea rows="3" class="form-control bg-white" readonly>{{ $booking->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    @foreach ($booking->items as $item)
                                        <div class="mt-3" id="cakeTab">
                                            <h5>{{ $item->type }}</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="cakeLists">
                                                        @php
                                                            if ($item->type == 'Occasions') {
                                                                $icon = '';
                                                            } else {
                                                                $icon = \DB::table(strtolower($item->type))
                                                                    ->where('id', $item->type_id)
                                                                    ->first()?->icon;
                                                            }
                                                        @endphp
                                                        <div class="mx-auto cake-list">
                                                            <div class="cake mx-auto ">
                                                                <img src="{{ asset('storage/' . $icon) }}"
                                                                    class="aaddonnImage" />
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <h5>{{ $item->title }}</h5>
                                                            <h6>₹{{ $item->price }}</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 bg-white rounded p-4 me-3 mt-4">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item Type</th>
                                                    <th>Items Name</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="summaryBody" class="summaryBody">
                                                <tr>
                                                    <td colspan="">
                                                        Time Slot
                                                    </td>
                                                    <td colspan="">
                                                        <ul>
                                                            @foreach ($booking->slots as $slot)
                                                                <li>{{ $slot->slot_name }}</li>
                                                            @endforeach
                                                        </ul>

                                                    </td>
                                                    <td colspan="">
                                                        <ul>
                                                            @foreach ($booking->slots as $slot)
                                                                <li>{{ $slot->amount }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @foreach ($booking->items as $item)
                                                    <tr>
                                                        <td colspan="">
                                                            {{ $item->type }}
                                                        </td>
                                                        <td colspan="">
                                                            {{ $item->title }}
                                                        </td>
                                                        <td colspan="">
                                                            {{ $item->price }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td><strong>Total Amount</strong></td>
                                                    <td></td>
                                                    <td>{{ $booking->grand_total_amount }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Advance</td>
                                                    <td></td>
                                                    <td>{{ $booking->advance }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Balance</td>
                                                    <td></td>
                                                    <td>{{ $booking->balance }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .package {
            margin: auto;
        }

        .package-img,
        .cake {
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }

        .package-img img,
        .cake img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }

        .decoration-list.selected,
        .gift-list.selected,
        .package.selected,
        .cake-list.selected {
            height: 132px;
            width: 132px;
            border: 3px solid #ff5714;
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .imageDivpackage.selected::before,
        .gift-list.selected::before,
        .decoration-list.selected::before,
        .cake-list.selected::before {
            content: "";
            height: 28px;
            width: 28px;
            background-color: #ff5714;
            border-radius: 50%;
            font-family: "Font Awesome 5 pro";
            font-weight: 600;
            position: absolute;
            top: -4px !important;
            right: 4px !important;
        }

        .imageDivpackage.selected::after,
        .gift-list.selected::after,
        .decoration-list.selected::after,
        .cake-list.selected::after {
            top: 0px !important;
            right: 12px !important;
        }
    </style>
</x-admin-layout>
