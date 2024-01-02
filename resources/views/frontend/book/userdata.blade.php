<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/booking.css') }}">
    @endpush
    @php
        $location_id = request()->get('location_id');
        $screen_id = request()->get('screen_id');
        $selectedDate = request()->get('date');
        $slot_id = request()->get('slot_id');
        $slot_name = '';
        $slot_amount = 0;
        $capacity = request()->capacity;
        $max_people = request()->max_people;
        $additional_amount = request()->additional_amount;
        $selectedSlots = json_decode(request()->selectedSlots);

        foreach ($selectedSlots as $key => $slot) {
            $slot_name .= $slot->slot;
            $slot_amount += $slot->amount;
            if ($key != count($selectedSlots) - 1) {
                $slot_name .= ', ';
            }
        }

        if ($location_id != '') {
            $locationData = App\Models\Location::where('id', $location_id)->first();
        }
        if ($screen_id != '') {
            $screenData = App\Models\Screen::where('id', $screen_id)->first();
        }
        if ($slot_id != '') {
            $slotData = App\Models\Timeslot::whereId($slot_id)->first();
        }
    @endphp
    {{-- {{ dd(request()->all()) }} --}}
    <section class="bg-theme">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto my-5 rd-10 bg-white">
                    <form class="" action="{{ route('user.booking') }}" method="POST">
                        @csrf
                        <input type="hidden" name="location_id" id="location_id" class="location_id"
                            value="{{ $location_id }}">
                        <input type="hidden" name="screen_id" id="screen_id" class="screen_id"
                            value="{{ $screen_id }}">
                        <input type="hidden" name="screen_name" id="screen_name" class="screen_name"
                            value="{{ $screenData->screen_name }}">
                        <input type="hidden" name="date" id="selectedDate" class="selectedDate"
                            value="{{ $selectedDate }}">

                        @foreach ($selectedSlots as $key => $item)
                            <input type="hidden" name="slot_id[]" class="slot_id" value="{{ $item->id }}">
                            <input type="hidden" name="slot_name[]" class="slot_id" value="{{ $item->slot }}">
                            <input type="hidden" name="slot_amount[]" class="slot_amount" value="{{ $item->amount }}">
                        @endforeach

                        <input type="hidden" name="total_slot_amount" id="total_slot_amount"
                            value="{{ $slot_amount }}">
                        <input type="hidden" value="{{ $additional_amount }}" id="additional_amount">
                        <input type="hidden" value="{{ $capacity }}" id="capacity">
                        <input type="hidden" name="grand_amount" id="grand_amount" value="{{ $slot_amount }}">
                        <div class="row pb-4">

                            <div class="col-lg-12 border-bottom">
                                <div class="row">
                                    <div class="col-lg-6 py-3 mb-correction">
                                        <a title="Go back" href="{{ URL::previous() }}"
                                            class="fw-semibold fs-5 text-decoration-none text-dark">
                                            <i class="fas fa-chevron-left me-3"></i>Add Booking Details
                                        </a>
                                    </div>
                                    <div class="col-lg-6 my-auto text-center">
                                        <h2 class="mb-0">{{ $screenData ? $screenData->screen_name : '' }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 border-bottom text-center">

                                <div class="row pt-3 bg-light">
                                    <div class="col-lg-12">
                                        <p class="cal_date">
                                            <span class="pe-3">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($selectedDate)->format('d/M/Y') }}
                                            </span>
                                            <span>|</span>
                                            <span class="ps-3">
                                                <i class="far fa-clock"></i>
                                                {{ $slot_name }}
                                            </span>
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <div class="row px-4 mt-4">
                                <div class="col-lg-6 pb-3">
                                    <label for="Name" class="ps-3 pb-1">Name</label>
                                    <div class="input-group mb-0">
                                        <i class="fal fa-user"></i>
                                        <input type="text" placeholder="Name" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <span
                                            style="color:red; font-size:12px; padding-left:15px; margin-top:5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 pb-3">
                                    <label for="Name" class="ps-3 pb-1">Phone Number</label>
                                    <div class="input-group mb-0">
                                        <i class="fal fa-phone-alt"></i>
                                        <input type="text" maxlength="10" placeholder="Phone Number" name="phone"
                                            onkeypress="return onlyNumberKey(event)" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <span
                                            style="color:red; font-size:12px; padding-left:15px; margin-top:5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 pb-3">
                                    <label for="Name" class="ps-3 pb-1">Email</label>
                                    <div class="input-group mb-0">
                                        <i class="fal fa-envelope"></i>
                                        <input type="text" placeholder="Email" name="email" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <span
                                            style="color:red; font-size:12px; padding-left:15px; margin-top:5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 pb-3">
                                    <label for="Name" class="ps-3 pb-1">No of people</label>
                                    <div class="select-group">
                                        <select id="number" class="number_of_people form-select"
                                            name="number_of_people">
                                            @if ($capacity == $max_people)
                                                <option selected>{{ $capacity }}</option>
                                            @else
                                                <option value="0">Select</option>
                                                @for ($i = 1; $i <= $max_people; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 additional_p">
                                    <label for="yesno">Do You Want Decoration</label>
                                    <div class="row">
                                        <div class="col-auto">
                                            <label class="yes-no">
                                                <input type="radio" class="decorationYesNo" checked name="yesno"
                                                    value="1">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="yes-no">
                                                <input type="radio" class="decorationYesNo" name="yesno"
                                                    value="0">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-bottom pt-3 px-4">
                            <div class="col-lg-6 col-8">
                                <h3>Total</h3>
                                <p>
                                    (inclusive of all taxes)
                                </p>
                            </div>
                            <div class="col-lg-6  col-4 text-end">
                                <h2 id="total_amount">₹ {{ $slot_amount }}</h2>
                            </div>
                        </div>
                        <div class="col-12 mt-4 px-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                    required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I accept the <a href="term-condition.php" target="_blank">cancellation policy</a>
                                    <span class="px-1">and</span>
                                    <a href="term-condition.php" target="_blank"> Terms and Conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="row mb-4 mt-2">
                            <button type="submit" class="addtocart text-center mx-auto">Submit
                                <i class="ms-1 fas fa-ticket-alt"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(".number_of_people").on('change', function() {
                var value = $(this).val();
                var extra_amount = $('#additional_amount').val();
                var slot_amount = $('#total_slot_amount').val();
                var capacity = $('#capacity').val();
                var extra = capacity - value;
                if (extra <= 0) {
                    extra = -(extra);
                } else {
                    extra = 0;
                }
                let total = parseFloat(slot_amount) + parseFloat(extra * extra_amount)
                $('#total_amount').text('₹' + total);
                $('#grand_amount').val(total);
            });

            function onlyNumberKey(evt) {
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                    return false;
                return true;
            }
        </script>
    @endpush
</x-home-layout>
