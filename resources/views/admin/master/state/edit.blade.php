<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            State Edit
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ url('admin/master/state/' . $list->id) }}" method="post">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">
                                            Name
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="state_id" name="state"
                                            value="{{ $list->name }}" aria-describedby="emailHelp" required>
                                        @if ($errors->has('state'))
                                            <span class="error validation">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>

                                    <button class="addtocart" type="submit">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
