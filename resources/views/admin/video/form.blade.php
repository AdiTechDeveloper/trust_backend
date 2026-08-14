@extends('layouts.app')

@section('title', isset($video) ? 'Edit Video' : 'Add Video')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            {{ isset($video) ? 'Edit Video' : 'Add New Video' }}
        </h3>

        <p class="text-muted mb-0">
            {{ isset($video)
                ? 'Update video information'
                : 'Add a new temple video'
            }}
        </p>
    </div>

    <a
        href="{{ route('admin.video.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left"></i>
        Back
    </a>

</div>


<form
    action="{{ isset($video)
        ? route('admin.video.update', $video->id)
        : route('admin.video.store') }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf

    @if(isset($video))
        @method('PUT')
    @endif


    {{-- =========================
        BASIC INFORMATION
    ========================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Basic Information
            </h5>

        </div>

        <div class="card-body px-4">

            <div class="row g-3">

                {{-- Video Title --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Video Title <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $video->title ?? '') }}"
                        placeholder="Mahashivratri Aarti"
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Slug --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $video->slug ?? '') }}"
                        placeholder="mahashivratri-aarti"
                    >

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        class="form-control @error('category') is-invalid @enderror"
                        value="{{ old('category', $video->category ?? '') }}"
                        placeholder="Aarti, Festival, Temple Event..."
                    >

                    @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Language --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Language
                    </label>

                    <select
                        name="language"
                        class="form-select @error('language') is-invalid @enderror"
                    >

                        <option value="">
                            Select Language
                        </option>

                        @foreach([
                            'Gujarati',
                            'Hindi',
                            'English',
                            'Sanskrit'
                        ] as $language)

                            <option
                                value="{{ $language }}"
                                {{ old('language', $video->language ?? '') === $language ? 'selected' : '' }}
                            >
                                {{ $language }}
                            </option>

                        @endforeach

                    </select>

                    @error('language')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="col-12">

                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Write a description about this video..."
                    >{{ old('description', $video->description ?? '') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        VIDEO INFORMATION
    ========================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Video Information
            </h5>

        </div>

        <div class="card-body px-4">

            <div class="row g-3">

                {{-- Video URL --}}
                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        Video URL <span class="text-danger">*</span>
                    </label>

                    <input
                        type="url"
                        name="video_url"
                        class="form-control @error('video_url') is-invalid @enderror"
                        value="{{ old('video_url', $video->video_url ?? '') }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                    >

                    <small class="text-muted">
                        Paste the YouTube or Vimeo video URL.
                    </small>

                    @error('video_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Duration --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Duration
                    </label>

                    <input
                        type="text"
                        name="duration"
                        class="form-control @error('duration') is-invalid @enderror"
                        value="{{ old('duration', $video->duration ?? '') }}"
                        placeholder="08:32"
                    >

                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Thumbnail --}}
                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        Thumbnail
                    </label>

                    <input
                        type="file"
                        name="thumbnail"
                        class="form-control @error('thumbnail') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted">
                        JPG, JPEG, PNG or WEBP. Maximum 2MB.
                    </small>

                    @error('thumbnail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                    {{-- Current Thumbnail --}}
                    @if(isset($video) && $video->thumbnail)

                        <div class="mt-3">

                            <p class="small text-muted mb-2">
                                Current Thumbnail
                            </p>

                            <img
                                src="{{ asset('storage/' . $video->thumbnail) }}"
                                alt="{{ $video->title }}"
                                width="220"
                                height="125"
                                style="
                                    object-fit:cover;
                                    border-radius:10px;
                                "
                            >

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        SETTINGS
    ========================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-0">
                Settings
            </h5>

        </div>

        <div class="card-body px-4">

            <div class="row g-4">

                {{-- Featured --}}
                <div class="col-md-4">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            name="featured"
                            value="1"
                            class="form-check-input"
                            id="featured"
                            {{ old('featured', $video->featured ?? false) ? 'checked' : '' }}
                        >

                        <label
                            class="form-check-label"
                            for="featured"
                        >
                            Featured Video
                        </label>

                    </div>

                </div>


                {{-- Status --}}
                <div class="col-md-4">

                    <div class="form-check form-switch">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            class="form-check-input"
                            id="status"
                            {{ old('status', $video->status ?? true) ? 'checked' : '' }}
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
                        class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $video->sort_order ?? 0) }}"
                        min="0"
                    >

                    @error('sort_order')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Published At --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Published At
                    </label>

                    <input
                        type="datetime-local"
                        name="published_at"
                        class="form-control @error('published_at') is-invalid @enderror"
                        value="{{ old(
                            'published_at',
                            isset($video) && $video->published_at
                                ? $video->published_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                    >

                    @error('published_at')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        SUBMIT
    ========================== --}}

    <div class="d-flex justify-content-end gap-2 mb-5">

        <a
            href="{{ route('admin.video.index') }}"
            class="btn btn-light border"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn btn-primary px-4"
        >

            <i class="bi bi-check-lg"></i>

            {{ isset($video) ? 'Update Video' : 'Create Video' }}

        </button>

    </div>

</form>

@endsection