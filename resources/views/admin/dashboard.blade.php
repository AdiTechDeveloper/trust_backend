@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        <h1 class="fw-bold text-dark">Welcome</h1>
        <p class="text-muted">Here is a quick overview of your temple management system.</p>
    </div>

    <!-- 1. Statistics Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Members Card -->
        <div class="col-xl-2 col-md-6">
            <div class="card bg-primary text-white shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold">Total Members</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalMembers ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Poojas Card -->
        <div class="col-xl-2 col-md-6">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold">Active Poojas</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalPoojas ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-flower1 fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-xl-2 col-md-6">
            <div class="card bg-warning text-dark shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold">Puja Bookings</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalBookings ?? 0 }}</h2>
                        {{-- <small class="text-dark">({{ $pendingBookings ?? 0 }} Pending)</small> --}}
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Videos Card -->
        <div class="col-xl-2 col-md-6">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold">Total Videos</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalVideos ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-camera-video fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

         <!-- Gallery -->
        <div class="col-xl-2 col-md-6">
            <div class="card bg-secondary text-white shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold">Total Gallery </h6>
                        <h2 class="mb-0 fw-bold">{{ $totalGallery ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-images fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Recent Bookings Table Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-clock-history me-2"></i>Recent Puja Bookings</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Devotee Name</th>
                            <th>Puja Name</th>
                            <th>Puja Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings ?? [] as $index => $booking)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>{{ $booking->puja->name ?? 'N/A' }}</td>
                                <td>{{ $booking->booking_date->format('d M Y, h:i A') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->payment_status == 'confirmed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection