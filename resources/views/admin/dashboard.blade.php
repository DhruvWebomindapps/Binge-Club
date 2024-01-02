<x-admin-layout>
    <div class="container-fluid">
        <div class="px-4">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3">
                    <div class="panel bg-1">
                        <a href="#!" class="contentAnchor">
                            <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                            <div class="panel-body">
                                <div class="panel-content">
                                    <h3 class="no-margin">{{ $total_amount }}</h3>
                                    <p>Total Revenue</p>
                                </div>
                                <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                            </div>
                        </a>
                    </div>
                </div>
                @role('super-admin')
                    <div class="col-lg-3">
                        <div class="panel bg-1">
                            <a href="{{ url('/admin/master/city') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $cities }}</h3>
                                        <p>Total City</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel bg-2">
                            <a href="{{ url('/admin/master/location') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $locations }}</h3>
                                        <p>Total Locations</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel bg-3">
                            <a href="{{ url('/admin/master/screen') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $screens }}</h3>
                                        <p>Total Screens</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                @endrole
                <div class="col-lg-3">
                    <div class="panel bg-4">
                        <a href="{{ url('/admin/booking') }}" class="contentAnchor">
                            <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                            <div class="panel-body">
                                <div class="panel-content">
                                    <h3 class="no-margin">{{ $bookings }}</h3>
                                    <p>Total Bookings</p>
                                </div>
                                <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                            </div>
                        </a>
                    </div>
                </div>
                @role('super-admin')
                    <div class="col-lg-3">
                        <div class="panel bg-5">
                            <a href="{{ url('/admin/master/package') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $packages }}</h3>
                                        <p>Total Packages</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel bg-3">
                            <a href="{{ url('/admin/master/cake') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $cakes }}</h3>
                                        <p>Total Cakes</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel bg-5">
                            <a href="{{ url('/admin/master/gift') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $gifts }}</h3>
                                        <p>Total Gifts</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel bg-2">
                            <a href="{{ url('/admin/master/decoration') }}" class="contentAnchor">
                                <img src="{{ asset('backend/img/dashboard-design-1.svg') }}" alt="">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <h3 class="no-margin">{{ $decorations }}</h3>
                                        <p>Total Decoration</p>
                                    </div>
                                    <a class="heading-elements-toggle"><i class="icon-menu"></i></a>
                                </div>
                            </a>

                        </div>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</x-admin-layout>
