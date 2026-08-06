@extends('layouts.app')

@section('title', 'Member Details')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Member Details</h3>
            <p class="text-muted mb-0">Full profile of {{ $communityMember->name }}</p>
        </div>
        <a href="{{ route('admin.community-members.index') }}" class="btn btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- ===== Member Info Card ===== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row">

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Full Name</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->name }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Mobile</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->mobile }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Gender</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->gender ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Date of Birth</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->dob?->format('d M Y') ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Marital Status</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->marital_status }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Anniversary</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->anniversary_date?->format('d M Y') ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Designation</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->designation ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Company</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->company_name ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">City</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->city ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">State</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->state ?? '-' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="text-muted mb-1 small">Address</p>
                    <p class="fw-semibold mb-0">{{ $communityMember->address ?? '-' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-1 small">Status</p>
                    <p class="mb-0">
                        @if ($communityMember->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== Family / Friends Members Card ===== --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-people-fill text-warning"></i> Family / Friend Members
            </h5>

            @if ($communityMember->familyMembers->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted mb-0">No family/friend members added yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>DOB</th>
                                <th>Anniversary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($communityMember->familyMembers as $family)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $family->name }}
                                        @if ($family->dob->format('m-d') === now()->format('m-d'))
                                            <span class="badge bg-warning text-dark ms-1">🎂 Today</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis">
                                            {{ $family->relation }}
                                        </span>
                                    </td>
                                    <td>{{ $family->dob->format('d M Y') }}</td>
                                    <td>{{ $family->anniversary_date?->format('d M Y') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

@endsection