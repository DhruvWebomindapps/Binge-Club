<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Customer List
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Name', 'column' => 'name', 'sort' => true], ['label' => 'Phone', 'column' => 'phone', 'sort' => true], ['label' => 'Email', 'column' => 'email', 'sort' => true], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$lists" :route="url('admin/customers')">
                            @foreach ($lists as $key => $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td class="text-capitalize">{{ $list->name }}</td>
                                    <td>{{ $list->phone }}</td>
                                    <td>{{ $list->email }}</td>
                                    <td>
                                        <a href="{{ url('/admin/customers/customer/' . $list->id) }}"
                                            style="color:blue;"><i class="fas fa-eye"></i></a>
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
