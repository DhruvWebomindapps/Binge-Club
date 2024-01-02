<x-home-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('frontend/css/booking.css') }}">
    @endpush
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 my-auto contact-detail">
                    <div class="p-4">
                        <h1>Get In touch with us</h1>
                        <p class="mb-4">
                            If you have any questions, feedback, or inquiries, please don’t hesitate to reach out to us.
                            We
                            value your input and strive to provide you with the best possible assistance.
                        </p>
                        <h4 class="mt-4">Call Us</h4>
                        <ul>
                            <li>
                                <i class="fal fa-phone-alt"></i>
                                <a href="tel:+91-8618923311">+91-8618923311</a>
                            </li>

                        </ul>

                        <h4 class="mt-4">Mail Us</h4>
                        <ul>

                            <li>
                                <i class="fal fa-envelope"></i>
                                <a href="mailto:contact@bingeclub.in">contact@bingeclub.in</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-lg-6">
                    <form action="{{ route('enquiry') }}" method="post">
                        @csrf
                        <div class="row bg-white rounded py-lg-5 p-4 mt-4">
                            <div class="col-lg-6">
                                <label for="Name" class="ps-3 pb-1">Name</label>
                                <div class="input-group">
                                    <i class="fal fa-user"></i>
                                    <input type="text" placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="Name" class="ps-3 pb-1">Phone Number</label>
                                <div class="input-group">
                                    <i class="fal fa-phone-alt"></i>
                                    <input type="text" placeholder="Phone Number" name="phone" maxlength="10">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="Name" class="ps-3 pb-1">Email</label>
                                <div class="input-group">
                                    <i class="fal fa-envelope"></i>
                                    <input type="email" placeholder="Email" name="email">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="Name" class="ps-3 pb-1">Your Message</label>
                                <textarea name="comment" rows="4"></textarea>
                            </div>

                            <div class="row mt-2">
                                <button type="submit" class="addtocart text-center mx-auto">Submit
                                    <i class="ms-1 fas fa-ticket-alt"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
