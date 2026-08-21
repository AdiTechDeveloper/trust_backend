@extends('layouts.app')

@section('title', isset($gallery) ? 'Edit Gallery Image' : 'Add Gallery Image')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            {{ isset($gallery) ? 'Edit Gallery Image' : 'Add Gallery Image' }}
        </h3>

        <p class="text-muted mb-0">
            {{ isset($gallery)
                ? 'Update gallery image details.'
                : 'Upload a new image to the temple gallery.'
            }}
        </p>
    </div>

    <a
        href="{{ route('admin.gallery.index') }}"
        class="btn btn-outline-secondary rounded-3"
    >
        <i class="bi bi-arrow-left"></i>
        Back to Gallery
    </a>

</div>


{{-- Validation Errors --}}
@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


<form
    action="{{ isset($gallery)
        ? route('admin.gallery.update', $gallery->id)
        : route('admin.gallery.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @if(isset($gallery))
        @method('PUT')
    @endif


    {{-- =========================================
         BASIC INFORMATION
    ========================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Gallery Information
            </h5>

        </div>

        <div class="card-body p-4">

            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Title <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $gallery->title ?? '') }}"
                        placeholder="Mahashivratri Celebration"
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Category <span class="text-danger">*</span>
                    </label>

                    <select
                        name="category"
                        class="form-select @error('category') is-invalid @enderror"
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach([
                            'Temple',
                            'Events',
                            'Aarti',
                            'Festivals',
                            'Puja',
                            'Gau Seva',
                            'Annadaan',
                            'Other'
                        ] as $category)

                            <option
                                value="{{ $category }}"
                                {{ old('category', $gallery->category ?? '') === $category ? 'selected' : '' }}
                            >
                                {{ $category }}
                            </option>

                        @endforeach

                    </select>

                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================
         IMAGE
    ========================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Gallery Image
            </h5>

        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Upload --}}
                <div class="col-md-7">

                    <label class="form-label fw-semibold">
                        Image
                        @if(!isset($gallery))
                            <span class="text-danger">*</span>
                        @endif
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted d-block mt-2">
                        JPG, JPEG, PNG or WEBP. Maximum size: 5 MB.
                    </small>

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Current Image --}}
                @if(isset($gallery) && $gallery->image)

                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Current Image
                        </label>

                        <div>

                            <img
                                src="{{ asset('storage/' . $gallery->image) }}"
                                alt="{{ $gallery->title }}"
                                class="img-fluid rounded-3"
                                style="
                                    width:220px;
                                    height:140px;
                                    object-fit:cover;
                                "
                            >

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================
         SETTINGS
    ========================================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Settings
            </h5>

        </div>

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Featured --}}
                <div class="col-md-4">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="featured"
                            id="featured"
                            value="1"
                            {{ old('featured', $gallery->featured ?? false) ? 'checked' : '' }}
                        >

                        <label
                            class="form-check-label"
                            for="featured"
                        >
                            Featured Image
                        </label>

                    </div>

                </div>


                {{-- Status --}}
                <div class="col-md-4">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="status"
                            id="status"
                            value="1"
                            {{ old('status', $gallery->status ?? true) ? 'checked' : '' }}
                        >

                        <label
                            class="form-check-label"
                            for="status"
                        >
                            Active
                        </label>

                    </div>

                </div>


                {{-- Sort Order --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Sort Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        min="0"
                        class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $gallery->sort_order ?? 0) }}"
                    >

                    @error('sort_order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================
         ACTIONS
    ========================================== --}}
    <div class="d-flex justify-content-end gap-2 mb-5">

        <a
            href="{{ route('admin.gallery.index') }}"
            class="btn btn-light border"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn btn-primary px-4"
        >

            <i class="bi bi-check-lg"></i>

            {{ isset($gallery) ? 'Update Image' : 'Upload Image' }}

        </button>

    </div>

</form>

@endsection 