<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Cake Create
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('blog.create') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class=" row mt-3">
                                    <div class="col col-lg-6">
                                        <label class="form-label">Title <span class="mandatorStar">*</span></label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title') }}" required>
                                        @if ($errors->has('title'))
                                            <span class="error validation">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Select Image
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <input type="file" class="form-control" name="image" required />
                                        @if ($errors->has('icon'))
                                            <span class="error validation">{{ $errors->first('icon') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Description
                                            <span class="mandatorStar">*</span>
                                        </label>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                        @if ($errors->has('description'))
                                            <span class="error validation">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="addtocart float-right" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
