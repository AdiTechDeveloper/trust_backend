@extends('layouts.app')

@section('title', 'Pooja List')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Pooja List</h3>
            <p class="text-muted mb-0">
                Manage all poojas available in the temple.
            </p>
        </div>

        <a href="{{ route('admin.pooja.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Add Pooja
        </a>

    </div>


    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="poojasTable" style="width:100%;">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Pooja Name</th>
                            <th>Price</th>
                            <th>Offer Price</th>
                            <th>Duration</th>
                            <th>Timings</th>
                            <th>Location</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($pooja as $pooja)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Photo --}}
                                <td>

                                    @if ($pooja->photo)
                                        <img src="{{ asset('storage/' . $pooja->photo) }}" alt="{{ $pooja->name }}"
                                            width="60" height="60"
                                            style="
                                            object-fit: cover;
                                            border-radius: 10px;
                                        ">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="
                                            width:60px;
                                            height:60px;
                                            border-radius:10px;
                                        ">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif

                                </td>


                                {{-- Name --}}
                                <td>

                                    <strong>
                                        {{ $pooja->name }}
                                    </strong>

                                    @if ($pooja->short_description)
                                        <small class="d-block text-muted">
                                            {{ Str::limit($pooja->short_description, 50) }}
                                        </small>
                                    @endif

                                </td>


                                {{-- Original Price --}}
                                <td>

                                    <span class="text-muted text-decoration-line-through">
                                        ₹{{ number_format($pooja->price, 2) }}
                                    </span>

                                </td>


                                {{-- Offer Price --}}
                                <td>

                                    @if ($pooja->offer_price)
                                        <strong class="text-success">
                                            ₹{{ number_format($pooja->offer_price, 2) }}
                                        </strong>
                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- Duration --}}
                                <td>
                                    {{ $pooja->duration ?? '-' }}
                                </td>


                                {{-- Timings --}}
                                <td>
                                    {{ $pooja->timings ?? '-' }}
                                </td>


                                {{-- Location --}}
                                <td>
                                    {{ $pooja->location ?? '-' }}
                                </td>


                                {{-- Featured --}}
                                <td>

                                    @if ($pooja->is_featured)
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

                                    @if ($pooja->status)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('admin.pooja.show', $pooja->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Preview">
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('admin.pooja.edit', $pooja->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('admin.pooja.destroy', $pooja->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this pooja?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>

                                    <h6 class="text-muted">
                                        No poojas found.
                                    </h6>

                                    <p class="text-muted mb-3">
                                        Start by adding your first pooja.
                                    </p>

                                    <a href="{{ route('admin.pooja.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Add Pooja
                                    </a>

                                </td>

                            </tr>
                        @endforelse

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

            $('#poojasTable').DataTable({

                pageLength: 10,

                responsive: true,

                ordering: true,

                searching: true,

                lengthChange: true,

                order: [
                    [2, 'asc']
                ]

            });

        });
    </script>
@endpush