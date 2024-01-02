<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/thank-you.css') }}">
    @endpush
    <section class="ptb thankYou-msg">
        <div class="container">
            <div class="row"> </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center p-4 ">
                    <img src="{{ asset('frontend/image/confirm.png') }}" height="60px" alt="">
                    <h2 class="mt-4 text-black dash">Your booking is confirmed</h2>
                    <p class="fs-5">
                        Your booking has been successfully made, and we've sent the relevant information to the
                        email id
                        you provided.
                    </p>
                    <a href="{{ url('invoice_download/' . request()->booking_id) }}" class="invoice-btn mt-5"><i
                            class="fas fa-download"></i> &nbsp;Download invoice
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
