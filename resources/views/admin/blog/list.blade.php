<x-admin-layout>
    <div class="container-fluid">
        <div class="row px-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Blog List
                            <a href="{{ route('blog.create') }}">
                                <button class="  create"><i class="fa fa-plus"></i></button>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $columns = [['label' => 'Id', 'column' => 'id', 'sort' => true], ['label' => 'Image', 'column' => 'image', 'sort' => false], ['label' => 'Title', 'column' => 'title', 'sort' => false], ['label' => 'Action', 'column' => 'Action', 'sort' => false]];
                        @endphp
                        <x-table :columns="$columns" :data="$blogs" :route="route('allblogs')">
                            @foreach ($blogs as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $list->image) }}" alt=""
                                            style="width:60px; height:60px;">
                                    </td>
                                    <td>{{ $list->title }}</td>
                                    <td class="action-btn">
                                        <a href="{{ route('blog.edit', $list->id) }}">
                                            <i class='far fa-edit'></i>
                                        </a>
                                        @role('super-admin')
                                            <a href="{{ route('blog.delete', $list->id) }}"
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
    @endpush
</x-admin-layout>
