<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            City Edit
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/master/city/' . $list->id) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class=" row">
                                <div class="col col-ms-6">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Select State
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <select class="form-select" name="state_id" aria-label="Default select example"
                                        required>
                                        <option value="">Select State</option>
                                        @foreach ($state_lists as $state_list)
                                            <option value="{{ $state_list->id }}"
                                                @if ($list->state_id == $state_list->id) selected @endif>
                                                {{ $state_list->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="error validation">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </div>
                                <div class="col col-ms-6">
                                    <label for="exampleInputEmail1" class="form-label">
                                        City Name
                                        <span class="mandatorStar">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="city_id" name="city"
                                        value="{{ $list->name }}" aria-describedby="emailHelp" required>
                                    @if ($errors->has('city'))
                                        <span class="error validation">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>
                            <br />
                            <button class="addtocart float-right" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
