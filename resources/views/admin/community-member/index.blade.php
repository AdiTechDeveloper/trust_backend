@extends('layouts.app')

@section('title', 'Community Members')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Community Members</h3>
            <p class="text-muted mb-0">View all registered community members</p>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle" id="membersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Marital Status</th>
                        <th>Anniversary</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $member->name }}
                                @if ($member->dob && $member->dob->format('m-d') === now()->format('m-d'))
                                    <span class="badge bg-warning text-dark ms-1">🎂 Today</span>
                                @endif
                            </td>
                            <td>{{ $member->mobile }}</td>
                            <td>{{ $member->gender ?? '-' }}</td>
                            <td>{{ $member->dob?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info-emphasis">
                                    {{ $member->marital_status }}
                                </span>
                            </td>
                            <td>{{ $member->anniversary_date?->format('d M Y') ?? '-' }}</td>
                            <td>{{ $member->city ?? '-' }}</td>
                            <td>{{ $member->state ?? '-' }}</td>
                            <td>
                                @if ($member->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $member->created_at->format('d M Y') }}</td>
                           <td class="text-center">
                                <a href="{{ route('admin.community-members.show', $member) }}"
                                   class="btn btn-sm btn-icon-action" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-icon-action text-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                No community members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection

@push('scripts')
    {{-- DataTables CDN --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#membersTable').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endpush