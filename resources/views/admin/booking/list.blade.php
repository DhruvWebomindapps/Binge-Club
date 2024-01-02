<x-admin-layout>
    <div class="container-fluid">
        <div class="row px-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Booking List
                            <a href="{{ url('admin/booking/create') }}">
                                <button class="  create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col col-md-3">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            name="search" id="searchBox" aria-describedby="searchHelp" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" id="fromDate" class="form-control fromDate "
                                        placeholder="Search by booking number">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" id="toDate" class="form-control toDate"
                                        placeholder="Search by booking number">
                                </div>
                                <div class="col-2">
                                    <select name="screen" id="screen">
                                        <option value="">Select Screen</option>
                                        @foreach ($screens as $screen)
                                            <option {{ request()->place == $screen->id ? 'selected' : '' }}
                                                value="{{ $screen->id }}">{{ $screen->screen_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select name="location" id="location">
                                        <option value="">Select location</option>
                                        @foreach ($locations as $location)
                                            <option {{ request()->place == $location->id ? 'selected' : '' }}
                                                value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ url('/admin/booking') }}" class="btn btn-danger">
                                        reset
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="row">

                            {{-- <div class="col-2">
                                <button class="btn btn-success w-100" id="today">Today's Booking</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary w-100" id="upcomming">Upcoming Booking</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-danger w-100" id="cancelled">Cancelled Booking</button>
                            </div> --}}
                        </div>
                        <input type="hidden" id="current_route" value="{{ url('/admin/booking') }}">
                        <div class="row">
                            <div class="col-md-12 dataTableDiv">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>S.N0.</th>
                                            <th class="sorting" data-sort="true" data-column="name">Name</th>
                                            {{-- <th class="sorting" data-sort="true" data-column="location_name">Location</th> --}}
                                            <th>Phone</th>
                                            <th>Screen</th>
                                            <th class="sorting" data-sort="true" data-column="book_date">Date</th>
                                            <th>Time Slot</th>
                                            <th>Total</th>
                                            <th>Advance</th>
                                            <th>Balance</th>
                                            <th>Booking Type</th>
                                            <th class="sorting" data-sort="true" data-column="status">Payment Status
                                            </th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($booking_list as $key => $b_list)
                                            <tr class="{{ $b_list->status == 'pending' ? 'maroon' : '' }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $b_list->getUser ? $b_list->name : '' }}</td>
                                                <td>{{ $b_list->getUser ? $b_list->phone : '' }}</td>
                                                {{-- <td>{{ $b_list->getLocation ? $b_list->getLocation->name : '' }}</td> --}}
                                                {{-- <td>{{ $b_list->location_name }}</td> --}}
                                                <td>{{ $b_list->getScreen ? $b_list->getScreen->screen_name : '' }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($b_list->book_date)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach ($b_list->slots as $slot)
                                                            <li>{{ $slot->slot_name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $b_list ? $b_list->grand_total_amount : '' }}</td>
                                                <td>{{ $b_list ? $b_list->advance : '' }}</td>
                                                <td>{{ $b_list ? $b_list->balance : '' }}</td>
                                                <td>{{ $b_list->is_online_booking ? 'Online' : 'Offline' }}</td>
                                                <td>{{ $b_list->status }}</td>
                                                <td>{{ $b_list->booking_status }}</td>
                                                <td class="action-btn">
                                                    <a href="{{ url('admin/booking/' . $b_list->id) }}"><i
                                                            class='fas fa-eye'></i></a>
                                                    <a href="{{ url('admin/booking/' . $b_list->id . '/edit') }}"><i
                                                            class='far fa-edit booking-edit'></i></a>
                                                    <a href="{{ url('admin/booking/delete/' . $b_list->id) }}"
                                                        onclick="return confirm('Are you sure? you want to delete')"><i
                                                            class='far fa-trash-alt' style="color:red"></i></a>
                                                    @role('supper-admin')
                                                    @endrole
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-2">
                                    {!! $booking_list->withQueryString()->links('pagination::bootstrap-5') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var table = {
                search: '',
                orderedColumn: "",
                orderBy: 'asc',
                toDate: "",
                fromDate: "",
                bookingType: "",
                location: "",
                screen: "",
            }
            $(document).ready(function() {
                let search = new URLSearchParams(window.location.search).get("search");
                let toDate = new URLSearchParams(window.location.search).get("toDate");
                let fromDate = new URLSearchParams(window.location.search).get("fromDate");
                let orderedColumn = new URLSearchParams(window.location.search).get("orderedColumn");
                let orderBy = new URLSearchParams(window.location.search).get("orderBy");
                let bookingType = new URLSearchParams(window.location.search).get("bookingType");
                let location = new URLSearchParams(window.location.search).get("location");
                let screen = new URLSearchParams(window.screen.search).get("screen");
                table.search = search ? search : '';
                $('#searchBox').val(search ? search : '');
                table.location = location ? location : '';
                $('#location').val(location ? location : '');
                table.screen = screen ? screen : '';
                $('#screen').val(screen ? screen : '');
                table.fromDate = fromDate ? fromDate : '';
                $('#fromDate').val(fromDate ? fromDate : '');
                table.toDate = toDate ? toDate : '';
                $('#toDate').val(toDate ? toDate : '');
                table.orderedColumn = orderedColumn ? orderedColumn : '';
                table.orderBy = orderBy ? orderBy : '';
                table.bookingType = bookingType ? bookingType : '';
            });

            $(document).on('click', '.sorting', function() {
                var isSort = $(this).data('sort');
                var column = $(this).data('column');
                if (isSort) {
                    let orderBy = new URLSearchParams(window.location.search).get("orderBy");
                    if (!orderBy) {
                        table.orderBy = 'asc';
                    } else if (orderBy == 'asc') {
                        table.orderBy = 'desc'
                    } else {
                        table.orderBy = 'asc';
                    }
                    table.orderedColumn = column;
                    getRecords();
                }
            });
            $(document).on('click', '#timesort', function() {
                let orderBy = new URLSearchParams(window.location.search).get("orderBy");
                if (!orderBy) {
                    table.orderBy = 'asc';
                } else if (orderBy == 'asc') {
                    table.orderBy = 'desc'
                } else {
                    table.orderBy = 'asc';
                }
                table.orderedColumn = 'timeslot';
                let route_name = $('#current_route').val();
                let url = route_name + `?${$.param( table )}`;
                window.location.href = url;
            });

            $('#searchForm').submit(function(e) {
                e.preventDefault();
                table.search = $('#searchBox').val();
                getRecords();
            });
            $('#searchBox').on('change', function(e) {
                e.preventDefault();
                table.search = $(this).val();
                getRecords();
            })
            console.log("from time");
            $('#fromDate').on('change', function(e) {
                e.preventDefault();
                table.fromDate = $(this).val();
                getRecords();
            })
            $('#toDate').on('change', function(e) {
                e.preventDefault();
                table.toDate = $(this).val();
                getRecords();
            })
            $('#location').on('change', function(e) {
                e.preventDefault();
                table.location = $(this).val();
                getRecords();
            })
            $('#screen').on('change', function(e) {
                e.preventDefault();
                table.screen = $(this).val();
                getRecords();
            })
            $('#today').on('click', function(e) {
                e.preventDefault();
                console.log("jkj");
                table.bookingType = "today";
                getRecords();
            })
            $('#upcomming').on('click', function(e) {
                e.preventDefault();
                table.bookingType = "upcomming";
                getRecords();
            })
            $('#cancelled').on('click', function(e) {
                e.preventDefault();
                table.bookingType = "cancelled";
                getRecords();
            })

            function getRecords() {
                let route_name = $('#current_route').val();
                let url = route_name + `?${$.param( table )}`;
                window.location.href = url;
            }
        </script>
    @endpush
</x-admin-layout>
