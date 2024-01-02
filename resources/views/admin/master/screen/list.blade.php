<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Screen List
                            <a href="{{ url('admin/master/screen/create') }}">
                                <button class="btn btn-info create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Location', 'column' => '', 'sort' => false], ['label' => 'Screen', 'column' => 'screen_name', 'sort' => true], ['label' => 'Priority', 'column' => 'priority', 'sort' => true], ['label' => 'Status', 'column' => 'status', 'sort' => true], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$screen_lists" :route="url('admin/master/screen')" :locations="$locations">
                            @foreach ($screen_lists as $sc_list)
                                <tr>
                                    <td>{{ $sc_list->id }}</td>
                                    <td>{{ $sc_list->getLOcation->name }}</td>
                                    <td>{{ $sc_list->screen_name }}</td>
                                    <td><input style="width: 55px !important;" id="priority'.{{ $sc_list->id }}.'"
                                            onchange="changePriority({{ $sc_list->id }})" type="number" name=""
                                            value="{{ $sc_list->priority }}"></td>
                                    <td>
                                        <a href="{{ url('admin/master/screen/status/' . $sc_list->id) }}"
                                            onclick="return confirm('Are you sure? Do you want to change the status of {{ $sc_list->name }}')">
                                            <i
                                                class="fas fa-{{ $sc_list->status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/master/screen/' . $sc_list->id . '/edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {{-- <a href="{{ url('admin/master/screen/delete/' . $sc_list->id) }}"
                                                onclick="return confirm('are you sure ? you want to delete')">
                                                <i class="fa fa-trash " style="color:red"></i>
                                            </a> --}}
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
                    url: "{{ route('update.screen.priority') }}",
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
        </script>
    @endpush
</x-admin-layout>
