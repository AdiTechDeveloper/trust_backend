@extends('layouts.app')

@section('title', isset($pooja) ? 'Edit Pooja' : 'Add Pooja')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            {{ isset($pooja) ? 'Edit Pooja' : 'Add New Pooja' }}
        </h3>

        <p class="text-muted mb-0">
            {{ isset($pooja) ? 'Update pooja information' : 'Create a new pooja' }}
        </p>
    </div>

    <a href="{{ route('admin.pooja.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>


<form
    action="{{ isset($pooja)
        ? route('admin.pooja.update', $pooja->id)
        : route('admin.pooja.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @if(isset($pooja))
        @method('PUT')
    @endif


    {{-- BASIC INFORMATION --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Basic Information
            </h5>
        </div>

        <div class="card-body px-4">

            <div class="row g-3">

                {{-- NAME --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Pooja Name <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $pooja->name ?? '') }}"
                        placeholder="Enter pooja name"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- SLUG --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $pooja->slug ?? '') }}"
                        placeholder="maha-shiv-puja"
                    >

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- SHORT DESCRIPTION --}}
                <div class="col-12">

                    <label class="form-label fw-semibold">
                        Short Description
                    </label>

                    <textarea
                        name="short_description"
                        rows="2"
                        class="form-control @error('short_description') is-invalid @enderror"
                        placeholder="Short description about this pooja"
                    >{{ old('short_description', $pooja->short_description ?? '') }}</textarea>

                    @error('short_description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- DESCRIPTION --}}
                <div class="col-12">

                    <label class="form-label fw-semibold">
                        Description <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Detailed description of the pooja"
                    >{{ old('description', $pooja->description ?? '') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>
    </div>


    {{-- PRICE & SCHEDULE --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Price & Schedule
            </h5>
        </div>

        <div class="card-body px-4">

            <div class="row g-3">

                {{-- OLD PRICE --}}
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Original Price <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price', $pooja->price ?? '') }}"
                        placeholder="5100"
                    >

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- OFFER PRICE --}}
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Offer Price
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="offer_price"
                        class="form-control @error('offer_price') is-invalid @enderror"
                        value="{{ old('offer_price', $pooja->offer_price ?? '') }}"
                        placeholder="2100"
                    >

                    @error('offer_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- DURATION --}}
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Duration <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="duration"
                        class="form-control @error('duration') is-invalid @enderror"
                        value="{{ old('duration', $pooja->duration ?? '') }}"
                        placeholder="2 Hours"
                    >

                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- SORT ORDER --}}
                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        class="form-control"
                        value="{{ old('sort_order', $pooja->sort_order ?? 0) }}"
                        min="0"
                    >

                </div>


                {{-- TIMINGS --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Timings
                    </label>

                    <input
                        type="text"
                        name="timings"
                        class="form-control"
                        value="{{ old('timings', $pooja->timings ?? '') }}"
                        placeholder="7:00 AM - 9:00 AM"
                    >

                </div>


                {{-- LOCATION --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Location
                    </label>

                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        value="{{ old('location', $pooja->location ?? '') }}"
                        placeholder="Temple"
                    >

                </div>

            </div>

        </div>
    </div>


    {{-- BENEFITS & SAMAGRI --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Benefits & Samagri
            </h5>
        </div>

        <div class="card-body px-4">

            <div class="row g-4">

                {{-- BENEFITS --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Benefits
                    </label>

                    <div id="benefitsWrapper">

                        @php
                            $benefits = old(
                                'benefits',
                                $pooja->benefits ?? ['']
                            );
                        @endphp

                        @foreach($benefits as $benefit)

                            <div class="input-group mb-2 benefit-row">

                                <input
                                    type="text"
                                    name="benefits[]"
                                    class="form-control"
                                    value="{{ $benefit }}"
                                    placeholder="Enter benefit"
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-danger remove-row"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        @endforeach

                    </div>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        id="addBenefit"
                    >
                        <i class="bi bi-plus"></i> Add Benefit
                    </button>

                </div>


                {{-- SAMAGRI --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Samagri
                    </label>

                    <div id="samagriWrapper">

                        @php
                            $samagri = old(
                                'samagri',
                                $pooja->samagri ?? ['']
                            );
                        @endphp

                        @foreach($samagri as $item)

                            <div class="input-group mb-2 samagri-row">

                                <input
                                    type="text"
                                    name="samagri[]"
                                    class="form-control"
                                    value="{{ $item }}"
                                    placeholder="Enter samagri"
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-danger remove-row"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        @endforeach

                    </div>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        id="addSamagri"
                    >
                        <i class="bi bi-plus"></i> Add Samagri
                    </button>

                </div>

            </div>

        </div>
    </div>


    {{-- PROCESS --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Puja Process
            </h5>
        </div>

        <div class="card-body px-4">

            <textarea
                name="process"
                rows="5"
                class="form-control"
                placeholder="Explain the pooja process..."
            >{{ old('process', $pooja->process ?? '') }}</textarea>

        </div>
    </div>


    {{-- IMAGES --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Images
            </h5>
        </div>

        <div class="card-body px-4">

            <div class="row g-4">

                {{-- MAIN PHOTO --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Main Photo
                    </label>

                    <input
                        type="file"
                        name="photo"
                        class="form-control @error('photo') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    @if(isset($pooja) && $pooja->photo)

                        <div class="mt-3">
                            <img
                                src="{{ asset('storage/' . $pooja->photo) }}"
                                width="150"
                                class="rounded-3 border"
                            >
                        </div>

                    @endif

                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- GALLERY --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Gallery Images
                    </label>

                    <input
                        type="file"
                        name="gallery[]"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                        multiple
                    >

                    <small class="text-muted">
                        You can select multiple images.
                    </small>

                </div>

            </div>

        </div>
    </div>


    {{-- SETTINGS --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                Settings
            </h5>
        </div>

        <div class="card-body px-4">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            name="is_featured"
                            value="1"
                            class="form-check-input"
                            id="isFeatured"
                            {{ old('is_featured', $pooja->is_featured ?? false) ? 'checked' : '' }}
                        >

                        <label class="form-check-label" for="isFeatured">
                            Featured Pooja
                        </label>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            class="form-check-input"
                            id="status"
                            {{ old('status', $pooja->status ?? true) ? 'checked' : '' }}
                        >

                        <label class="form-check-label" for="status">
                            Active
                        </label>

                    </div>

                </div>

            </div>

        </div>
    </div>


    {{-- SUBMIT --}}
    <div class="d-flex justify-content-end gap-2 mb-5">

        <a
            href="{{ route('admin.pooja.index') }}"
            class="btn btn-light border"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn btn-primary px-4"
        >
            <i class="bi bi-check-lg"></i>

            {{ isset($pooja) ? 'Update Pooja' : 'Create Pooja' }}

        </button>

    </div>

</form>

@endsection


@push('scripts')

<script>

    // ADD BENEFIT
    document.getElementById('addBenefit').addEventListener('click', function () {

        const wrapper = document.getElementById('benefitsWrapper');

        const row = document.createElement('div');

        row.className = 'input-group mb-2 benefit-row';

        row.innerHTML = `
            <input
                type="text"
                name="benefits[]"
                class="form-control"
                placeholder="Enter benefit"
            >

            <button
                type="button"
                class="btn btn-outline-danger remove-row"
            >
                <i class="bi bi-trash"></i>
            </button>
        `;

        wrapper.appendChild(row);

    });


    // ADD SAMAGRI
    document.getElementById('addSamagri').addEventListener('click', function () {

        const wrapper = document.getElementById('samagriWrapper');

        const row = document.createElement('div');

        row.className = 'input-group mb-2 samagri-row';

        row.innerHTML = `
            <input
                type="text"
                name="samagri[]"
                class="form-control"
                placeholder="Enter samagri"
            >

            <button
                type="button"
                class="btn btn-outline-danger remove-row"
            >
                <i class="bi bi-trash"></i>
            </button>
        `;

        wrapper.appendChild(row);

    });


    // REMOVE ROW
    document.addEventListener('click', function (e) {

        const button = e.target.closest('.remove-row');

        if (!button) return;

        const row = button.closest('.input-group');

        if (row) {
            row.remove();
        }

    });

</script>

@endpush