<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col col-md-12 px-4" id="admin-app">
                <booking-app :cities="{{ $cities }}" :existing="{{ json_encode($booking_details) }}" />
            </div>
        </div>
    </div>
</x-admin-layout>
