<x-admin-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col col-md-12">
                <div class="card">
                    <div class="p-4 pb-0">
                        <h4>
                            Other Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class=" row mt-3">
                                <div class="col col-lg-6">
                                    <label class="form-label">Select City <span class="mandatorStar"></span></label>
                                    <select class="form-select" aria-label="Default select example" name="city_id"
                                        id="city_id">
                                        <option value="{{ $otherData->id }}" selected>{{ $otherData->getCity?->name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col col-lg-6">
                                    <label class="form-label">Select Location <span class="mandatorStar"></span></label>
                                    <select class="form-select" aria-label="Default select example" name="location_id"
                                        id="location_id">
                                        <option value="{{ $otherData->id }}" selected>
                                            {{ optional($otherData->getLocation)->name }}
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class=" row mt-3">
                                <div class="col col-lg-6">
                                    <label class="form-label">Name <span class="mandatorStar"></span></label>
                                    <input type="text" class="form-control" id="name_id" name="title"
                                        value="{{ $otherData->title }}" required>
                                    @if ($errors->has('title'))
                                        <span class="error validation">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div class="col col-lg-6">
                                    <label class="form-label">Price <span class="mandatorStar"></span></label>
                                    <input type="text" class="form-control" id="price_id" name="price"
                                        value="{{ $otherData->price }}" required />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <img src="{{ asset('storage/' . $otherData->icon) }}" alt=""
                                        class="mt-4 img-fluid" style="width:100px; height:100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
