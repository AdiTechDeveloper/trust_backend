@extends('layouts.app')

@section('title', 'Video Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Video Details
        </h3>

        <p class="text-muted mb-0">
            View video information.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('admin.video.edit', $video->id) }}"
            class="btn btn-primary"
        >
            <i class="bi bi-pencil"></i>
            Edit
        </a>

        <a
            href="{{ route('admin.video.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

</div>


<div class="row g-4">

    {{-- VIDEO --}}
   {{-- VIDEO --}}
<div class="col-lg-8">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            @if($video->video_url)

                @php
                    $videoUrl = $video->video_url;

                    // Convert YouTube watch URL
                    if (str_contains($videoUrl, 'watch?v=')) {
                        $videoId = explode('watch?v=', $videoUrl)[1];
                        $videoId = explode('&', $videoId)[0];
                    }

                    // Convert youtu.be URL
                    elseif (str_contains($videoUrl, 'youtu.be/')) {
                        $videoId = explode('youtu.be/', $videoUrl)[1];
                        $videoId = explode('?', $videoId)[0];
                    }

                    // Already an embed URL
                    elseif (str_contains($videoUrl, 'youtube.com/embed/')) {
                        $videoId = explode('youtube.com/embed/', $videoUrl)[1];
                        $videoId = explode('?', $videoId)[0];
                    }

                    else {
                        $videoId = null;
                    }
                @endphp

                @if($videoId)

                    <div class="ratio ratio-16x9">

                        <iframe
                            src="https://www.youtube.com/embed/{{ $videoId }}"
                            title="{{ $video->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>

                    </div>

                @else

                    <div class="alert alert-warning">
                        Invalid YouTube URL.
                    </div>

                @endif

            @else

                <div class="text-center text-muted py-5">

                    <i class="bi bi-camera-video fs-1 d-block mb-2"></i>

                    <p class="mb-0">
                        No video available.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

    {{-- DETAILS --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Video Information
                </h5>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Title
                    </p>

                    <p class="fw-semibold mb-0">
                        {{ $video->title }}
                    </p>

                </div>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Category
                    </p>

                    <span class="badge bg-info-subtle text-info-emphasis">
                        {{ $video->category ?? '-' }}
                    </span>

                </div>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Status
                    </p>

                    @if($video->status)

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Inactive
                        </span>

                    @endif

                </div>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Featured
                    </p>

                    @if($video->featured)

                        <span class="badge bg-warning text-dark">
                            Featured
                        </span>

                    @else

                        <span class="badge bg-light text-dark">
                            No
                        </span>

                    @endif

                </div>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Sort Order
                    </p>

                    <p class="fw-semibold mb-0">
                        {{ $video->sort_order ?? 0 }}
                    </p>

                </div>


                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Created On
                    </p>

                    <p class="fw-semibold mb-0">
                        {{ $video->created_at?->format('d M Y, h:i A') ?? '-' }}
                    </p>

                </div>


                <div>

                    <p class="text-muted small mb-1">
                        Last Updated
                    </p>

                    <p class="fw-semibold mb-0">
                        {{ $video->updated_at?->format('d M Y, h:i A') ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- DELETE --}}
        <div class="card border-0 shadow-sm rounded-4 mt-4">

            <div class="card-body p-4">

                <h6 class="fw-bold mb-2">
                    Delete Video
                </h6>

                <p class="text-muted small">
                    This action cannot be undone.
                </p>

                <form
                    action="{{ route('admin.video.destroy', $video->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this video?');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger w-100"
                    >
                        <i class="bi bi-trash"></i>
                        Delete Video
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection