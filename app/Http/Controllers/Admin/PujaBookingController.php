<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PujaBooking;

class PujaBookingController extends Controller
{
    //
    public function index()
    {
        $bookings = PujaBooking::with([
            'user',
            'puja',
        ])
            ->latest()
            ->get();

        return view(
            'admin.puja-bookings.index',
            compact('bookings')
        );
    }

    public function show($id)
    {
        $booking = PujaBooking::with([
            'user',
            'puja',
        ])->findOrFail($id);

        return view(
            'admin.puja-bookings.show',
            compact('booking')
        );
    }
}
