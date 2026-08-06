@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Users</h3>
            <p class="text-muted mb-0">All registered users with role: user</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Marital Status</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Joined On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile ?? '-' }}</td>
                            <td>{{ $user->gender ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info-subtle text-info-emphasis">
                                    {{ $user->marital_status ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $user->city ?? '-' }}</td>
                            <td>{{ $user->state ?? '-' }}</td>
                            <td>
                                @if ($user->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#usersTable').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endpush