@extends('layouts.app')

@section('title', 'Gallery Details')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Gallery Details
            </h3>

            <p class="text-muted mb-0">
                View gallery image information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i>
                Edit
            </a>

            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- =========================
         IMAGE
    ========================== --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="w-100 overflow-hidden rounded-4 bg-light d-flex align-items-center justify-content-center"
                        style="min-height: 450px;">

                        {{-- <p>
                            Stored image path:
                            {{ $gallery->image }}
                        </p> --}}

                        {{-- <p>
                            Image URL:
                            {{ asset('storage/' . $gallery->image) }}
                        </p> --}}

                        @if ($gallery->image)
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}"
                                class="img-fluid"
                                style="
            max-width: 100%;
            max-height: 650px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 12px;
        ">
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-image fs-1 d-block mb-2"></i>
                                <p class="mb-0">No image available.</p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
         DETAILS
    ========================== --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Gallery Information
                    </h5>


                    {{-- Title --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Title
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $gallery->title }}
                        </p>

                    </div>


                    {{-- Category --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Category
                        </p>

                        <span class="badge bg-info-subtle text-info-emphasis">
                            {{ $gallery->category }}
                        </span>

                    </div>


                    {{-- Featured --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Featured
                        </p>

                        @if ($gallery->featured)
                            <span class="badge bg-warning text-dark">
                                Featured
                            </span>
                        @else
                            <span class="badge bg-light text-dark">
                                No
                            </span>
                        @endif

                    </div>


                    {{-- Status --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Status
                        </p>

                        @if ($gallery->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Inactive
                            </span>
                        @endif

                    </div>


                    {{-- Sort Order --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Sort Order
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $gallery->sort_order }}
                        </p>

                    </div>


                    {{-- Created --}}
                    <div class="mb-4">

                        <p class="text-muted small mb-1">
                            Created On
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $gallery->created_at?->format('d M Y, h:i A') ?? '-' }}
                        </p>

                    </div>


                    {{-- Updated --}}
                    <div>

                        <p class="text-muted small mb-1">
                            Last Updated
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $gallery->updated_at?->format('d M Y, h:i A') ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Delete --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">

                <div class="card-body p-4">

                    <h6 class="fw-bold mb-2">
                        Delete Gallery Image
                    </h6>

                    <p class="text-muted small">
                        Deleting this item will also remove its image
                        from storage.
                    </p>

                    <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this gallery image?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash"></i>
                            Delete Image
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
