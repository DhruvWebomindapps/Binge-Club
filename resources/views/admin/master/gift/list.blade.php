<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Gift List
                            <a href="{{ url('admin/master/gift/create') }}">
                                <button class="btn btn-info create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Icon', 'column' => 'icon', 'sort' => false], ['label' => 'Name', 'column' => 'title', 'sort' => true], ['label' => 'Price', 'column' => 'price', 'sort' => true], ['label' => 'Priority', 'column' => 'priority', 'sort' => true], ['label' => 'Status', 'column' => 'status', 'sort' => true], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$lists" :route="url('admin/master/gift')" :locations="$locations">
                            @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $list->icon) }}" alt=""
                                            style="width:60px; height:60px;">
                                    </td>
                                    <td>{{ $list->title }}</td>
                                    <td>
                                        <input style="width: 85px !important;" id="priority'.{{ $list->id }}.'"
                                            onchange="changePrice({{ $list->id }})" type="number" name=""
                                            value="{{ $list->price }}">
                                    </td>
                                    <td>
                                        <input style="width: 55px !important;" id="priority'.{{ $list->id }}.'"
                                            onchange="changePriority({{ $list->id }})" type="number" name=""
                                            value="{{ $list->priority }}">
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/master/gift/changeStatus/' . $list->id) }}"
                                            onclick="return confirm('Are you sure? Do you want to change the status of {{ $list->name }}')">
                                            <i
                                                class="fas fa-{{ $list->status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </a>
                                    </td>
                                    <td class="action-btn">
                                        <a href="{{ url('admin/master/gift/' . $list->id) }}">
                                            <i class='fas fa-eye'></i>
                                        </a>
                                        <a href="{{ url('admin/master/gift/' . $list->id . '/edit') }}">
                                            <i class='far fa-edit'></i>
                                        </a>
                                        @role('super-admin')
                                        <a href="{{ url('admin/master/gift/delete/' . $list->id) }}"
                                            onclick="return confirm('Are you sure? you want to delete')">
                                            <i class='far fa-trash-alt' style="color:red"></i>
                                        </a>
                                        @endrole
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var table = {
                search: '',
                place: '',
                orderedColumn: "",
                orderBy: 'asc',
            }
            $(document).ready(function() {
                let search = new URLSearchParams(window.location.search).get("search");
                let orderedColumn = new URLSearchParams(window.location.search).get("orderedColumn");
                let orderBy = new URLSearchParams(window.location.search).get("orderBy");

                table.search = search ? search : '';
                $('#searchBox').val(search ? search : '');
                table.orderedColumn = orderedColumn ? orderedColumn : '';
                table.orderBy = orderBy ? orderBy : '';
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
            $('#location').on('change', function(e) {
                e.preventDefault();
                table.place = $(this).val();
                getRecords();
            })

            function getRecords() {
                let route_name = $('#current_route').val();
                let url = route_name + `?${$.param( table )}`;
                window.location.href = url;
            }

            function changePriority(id) {
                value = event.target.value;
                jQuery.ajax({
                    type: "GET",
                    url: "{{ route('update.gift.priority') }}",
                    datatype: "text",
                    data: {
                        id: id,
                        value: value
                    },
                    success: function(response) {
                        alert("Priority Updated Successfully....!");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }

            function changePrice(id) {
                value = event.target.value;
                jQuery.ajax({
                    type: "GET",
                    url: "{{ route('update.gift.price') }}",
                    datatype: "text",
                    data: {
                        id: id,
                        value: value
                    },
                    success: function(response) {
                        alert("Price Updated Successfully....!");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            }
        </script>
    @endpush
</x-admin-layout>
