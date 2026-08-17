@extends('layouts.app')

@section('title', 'Puja Booking Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            Puja Booking Details
        </h3>

        <p class="text-muted mb-0">
            Booking #{{ $booking->id }}
        </p>

    </div>


    <a
        href="{{ route('admin.puja-booking.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left"></i>
        Back to Bookings
    </a>

</div>


<div class="row g-4">


    {{-- =========================
        BOOKING INFORMATION
    ========================== --}}

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-calendar-check text-warning"></i>
                    Booking Information
                </h5>


                <div class="row">

                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Booking ID
                        </p>

                        <p class="fw-semibold mb-0">
                            #{{ $booking->id }}
                        </p>

                    </div>


                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Puja
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $booking->puja?->name ?? '-' }}
                        </p>

                    </div>


                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Booking Date
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $booking->booking_date?->format('d M Y') ?? '-' }}
                        </p>

                    </div>


                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Time Slot
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $booking->time_slot ?? '-' }}
                        </p>

                    </div>


                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Amount
                        </p>

                        <p class="fw-bold text-success mb-0">
                            ₹{{ number_format($booking->amount, 2) }}
                        </p>

                    </div>


                    <div class="col-md-6 mb-4">

                        <p class="text-muted small mb-1">
                            Payment Status
                        </p>

                        @if($booking->payment_status === 'paid')

                            <span class="badge bg-success">
                                Paid
                            </span>

                        @elseif($booking->payment_status === 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                        @elseif($booking->payment_status === 'failed')

                            <span class="badge bg-danger">
                                Failed
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($booking->payment_status ?? 'Unknown') }}
                            </span>

                        @endif

                    </div>


                    <div class="col-md-12 mb-3">

                        <p class="text-muted small mb-1">
                            Transaction ID
                        </p>

                        <p class="fw-semibold mb-0 text-break">
                            {{ $booking->transaction_id ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Devotee information --}}

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person text-warning"></i>
                    Devotee Information
                </h5>


                <div class="row">

                    <div class="col-md-4 mb-4">

                        <p class="text-muted small mb-1">
                            Full Name
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $booking->user?->name ?? 'Guest' }}
                        </p>

                    </div>


                    <div class="col-md-4 mb-4">

                        <p class="text-muted small mb-1">
                            Mobile
                        </p>

                        <p class="fw-semibold mb-0">
                            {{ $booking->user?->mobile ?? '-' }}
                        </p>

                    </div>


                    <div class="col-md-4 mb-4">

                        <p class="text-muted small mb-1">
                            Email
                        </p>

                        <p class="fw-semibold mb-0 text-break">
                            {{ $booking->user?->email ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        SIDEBAR
    ========================== --}}

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Puja Summary
                </h5>


                @if($booking->puja?->photo)

                    <img
                        src="{{ asset('storage/' . $booking->puja->photo) }}"
                        alt="{{ $booking->puja->name }}"
                        class="img-fluid rounded-3 mb-3"
                    >

                @endif


                <h5 class="fw-bold">
                    {{ $booking->puja?->name ?? '-' }}
                </h5>


                @if($booking->puja?->duration)

                    <p class="text-muted mb-2">

                        <i class="bi bi-clock"></i>

                        {{ $booking->puja->duration }}

                    </p>

                @endif


                <hr>


                <div class="d-flex justify-content-between mb-2">

                    <span class="text-muted">
                        Booking Amount
                    </span>

                    <strong>
                        ₹{{ number_format($booking->amount, 2) }}
                    </strong>

                </div>


                <div class="d-flex justify-content-between">

                    <span class="text-muted">
                        Booked On
                    </span>

                    <span>
                        {{ $booking->created_at?->format('d M Y') ?? '-' }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection