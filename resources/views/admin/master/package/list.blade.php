<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Package List
                            <a href="{{ url('admin/master/package/create') }}">
                                <button class="btn btn-info create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Icon', 'column' => 'icon', 'sort' => false], ['label' => 'Name', 'column' => 'title', 'sort' => true], ['label' => 'Price', 'column' => 'price', 'sort' => true], ['label' => 'Priority', 'column' => 'priority', 'sort' => true], ['label' => 'Status', 'column' => 'status', 'sort' => true], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$package_lists" :route="url('admin/master/package')" :locations="$locations">
                            @foreach ($package_lists as $p_list)
                                <tr>
                                    <td>{{ $p_list->id }}</td>
                                    <td>
                                        @php
                                            $pkgImg = $p_list->getPackageImage->first();
                                        @endphp
                                        <img src="{{ asset('storage/' . $pkgImg->package_image) }}" alt=""
                                            style="width:60px; height:60px;">
                                    </td>
                                    <td>{{ $p_list->title }}</td>
                                    <td>
                                        <input style="width: 85px !important;" id="priority'.{{ $p_list->id }}.'"
                                            onchange="changePrice({{ $p_list->id }})" type="number" name=""
                                            value="{{ $p_list->price }}">
                                    </td>
                                    <td>
                                        <input style="width: 55px !important;" id="priority'.{{ $p_list->id }}.'"
                                            onchange="changePriority({{ $p_list->id }})" type="number" name=""
                                            value="{{ $p_list->priority }}">
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/master/package/status/' . $p_list->id) }}"
                                            onclick="return confirm('Are you sure? Do you want to change the status of {{ $p_list->name }}')">
                                            <i
                                                class="fas fa-{{ $p_list->status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/master/package/' . $p_list->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ url('admin/master/package/' . $p_list->id . '/edit') }}"><i
                                                class="fas fa-edit"></i></a>
                                        @role('super-admin')
                                            <a href="{{ url('admin/master/package/delete/' . $p_list->id) }}"
                                                onclick="return confirm('are you sure? Do you want to delete')"><i
                                                    class="fas fa-trash" style="color:red;"></i></a>
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
            function changePriority(id) {
                value = event.target.value;
                jQuery.ajax({
                    type: "GET",
                    url: "{{ route('update.package.priority') }}",
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
                    url: "{{ route('update.package.price') }}",
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
