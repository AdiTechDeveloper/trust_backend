@extends('layouts.app')

@section('title', 'Videos')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Videos</h3>
            <p class="text-muted mb-0">
                Manage temple videos, events, aartis and spiritual content.
            </p>
        </div>

        <a href="{{ route('admin.video.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Add Video
        </a>

    </div>


    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="videosTable" style="width:100%;">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Duration</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($videos as $video)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    @if ($video->thumbnail)
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}"
                                            width="90" height="55" style="object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="
                            width:90px;
                            height:55px;
                            border-radius:8px;
                        ">
                                            <i class="bi bi-play-btn fs-4 text-muted"></i>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $video->title }}</strong>

                                    @if ($video->description)
                                        <small class="d-block text-muted">
                                            {{ Str::limit($video->description, 50) }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    {{ $video->category ?? '-' }}
                                </td>

                                <td>
                                    {{ $video->language ?? '-' }}
                                </td>

                                <td>
                                    {{ $video->duration ?? '-' }}
                                </td>

                                <td>
                                    @if ($video->featured)
                                        <span class="badge bg-warning text-dark">
                                            Featured
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">
                                            No
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($video->status)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $video->published_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.video.show', $video->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.video.edit', $video->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this video?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection


@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush


@push('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#videosTable').DataTable({

                pageLength: 10,

                responsive: true,

                ordering: true,

                searching: true,

                lengthChange: true,

                order: [
                    [2, 'asc']
                ],

                language: {
                    emptyTable: "No videos found."
                }

            });

        });
    </script>
@endpush
