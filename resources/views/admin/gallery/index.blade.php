@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Gallery</h3>

        <p class="text-muted mb-0">
            Manage temple photos, events and special moments.
        </p>
    </div>

    <a
        href="{{ route('admin.gallery.create') }}"
        class="btn btn-primary"
    >
        <i class="bi bi-plus-lg"></i>
        Add Image
    </a>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div
        class="alert alert-success alert-dismissible fade show mb-4"
        role="alert"
    >

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


{{-- Validation Errors --}}
@if($errors->any())

    <div
        class="alert alert-danger alert-dismissible fade show mb-4"
        role="alert"
    >

        <strong>Please fix the following:</strong>

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


<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="table table-hover align-middle"
                id="galleryTable"
                style="width:100%;"
            >

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($galleries as $gallery)

                        <tr>

                            {{-- Number --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- Image --}}
                            <td>

                                @if($gallery->image)

                                    <img
                                        src="{{ asset('storage/' . $gallery->image) }}"
                                        alt="{{ $gallery->title }}"
                                        width="90"
                                        height="65"
                                        style="
                                            object-fit:cover;
                                            border-radius:10px;
                                        "
                                    >

                                @else

                                    <div
                                        class="bg-light d-flex align-items-center justify-content-center"
                                        style="
                                            width:90px;
                                            height:65px;
                                            border-radius:10px;
                                        "
                                    >
                                        <i class="bi bi-image fs-4 text-muted"></i>
                                    </div>

                                @endif

                            </td>


                            {{-- Title --}}
                            <td>
                                <strong>
                                    {{ $gallery->title }}
                                </strong>
                            </td>


                            {{-- Category --}}
                            <td>
                                <span class="badge bg-info-subtle text-info-emphasis">
                                    {{ $gallery->category }}
                                </span>
                            </td>


                            {{-- Featured --}}
                            <td>

                                @if($gallery->featured)

                                    <span class="badge bg-warning text-dark">
                                        Featured
                                    </span>

                                @else

                                    <span class="badge bg-light text-dark">
                                        No
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($gallery->status)

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Sort Order --}}
                            <td>
                                {{ $gallery->sort_order }}
                            </td>


                            {{-- Created --}}
                            <td>
                                {{ $gallery->created_at?->format('d M Y') ?? '-' }}
                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="d-flex gap-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('admin.gallery.show', $gallery->id) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="View"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.gallery.edit', $gallery->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.gallery.destroy', $gallery->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this gallery image?');"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete"
                                        >
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

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
>

@endpush


@push('scripts')

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

    $(document).ready(function () {

        $('#galleryTable').DataTable({

            pageLength: 10,

            responsive: true,

            ordering: true,

            searching: true,

            lengthChange: true,

            order: [[6, 'asc']]

        });

    });

</script>

@endpush