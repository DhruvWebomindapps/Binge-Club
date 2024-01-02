<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            State List
                            <a href="{{ url('admin/master/state/create') }}">
                                <button class="btn btn-info create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Name', 'column' => 'name', 'sort' => true], ['label' => 'Status', 'column' => 'status', 'sort' => true], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$lists" :route="url('admin/master/state')">
                            @foreach ($lists as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td>
                                        <a href="{{ url('admin/master/states/status/' . $list->id) }}"
                                            onclick="return confirm('Are you sure? Do you want to change the status of {{ $list->name }}')">
                                            <i class="fas fa-{{ $list->status == 1 ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/master/state/' . $list->id . '/edit') }}">
                                            <i class='far fa-edit'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
