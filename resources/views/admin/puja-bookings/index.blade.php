@extends('layouts.app')

@section('title', 'Puja Bookings')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Puja Bookings</h3>

        <p class="text-muted mb-0">
            Manage all puja bookings received from devotees.
        </p>
    </div>

</div>


@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

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
                id="bookingsTable"
                style="width:100%;"
            >

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Booking ID</th>
                        <th>Devotee</th>
                        <th>Mobile</th>
                        <th>Puja</th>
                        <th>Booking Date</th>
                        <th>Time Slot</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Booked On</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($bookings as $booking)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>
                                <strong>
                                    #{{ $booking->id }}
                                </strong>
                            </td>


                            <td>

                                <strong>
                                    {{ $booking->user?->name ?? 'Guest' }}
                                </strong>

                                @if($booking->user?->email)

                                    <small class="d-block text-muted">
                                        {{ $booking->user->email }}
                                    </small>

                                @endif

                            </td>


                            <td>
                                {{ $booking->user?->mobile ?? '-' }}
                            </td>


                            <td>
                                {{ $booking->puja?->name ?? '-' }}
                            </td>


                            <td>
                                {{ $booking->booking_date?->format('d M Y') ?? '-' }}
                            </td>


                            <td>
                                {{ $booking->time_slot ?? '-' }}
                            </td>


                            <td>

                                <strong>
                                    ₹{{ number_format($booking->amount, 2) }}
                                </strong>

                            </td>


                            <td>

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

                            </td>


                            <td>
                                {{ $booking->created_at?->format('d M Y, h:i A') ?? '-' }}
                            </td>


                            <td>

                                <a
                                    href="{{ route('admin.puja-booking.show', $booking->id) }}"
                                    class="btn btn-sm btn-outline-info"
                                    title="View Booking"
                                >
                                    <i class="bi bi-eye"></i>
                                </a>

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

        $('#bookingsTable').DataTable({

            pageLength: 10,

            responsive: true,

            ordering: true,

            searching: true,

            lengthChange: true,

            order: [[9, 'desc']]

        });

    });

</script>

@endpush