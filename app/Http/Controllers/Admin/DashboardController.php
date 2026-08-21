<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class DashboardController extends Controller
// {
//     //
//      public function index()
//     {
//         return view('admin.dashboard');
//     }
// }

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\pooja; // Change model name based on your project
use App\Models\PujaBooking; // Change model name based on your project
use App\Models\User; // Change model name based on your project
use App\Models\Video; // Change model name based on your project

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = User::where('role', 'user')->count();
        $totalPoojas = pooja::count();
        $totalBookings = PujaBooking::count();
        // $pendingBookings = PujaBooking::where('status', 'pending')->count();
        $totalVideos = Video::count();
        $totalGallery = Gallery::count();

        // Fetch recent bookings for the table
        $recentBookings = PujaBooking::with('user', 'puja')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalPoojas',
            'totalBookings',
            'totalGallery',
            // 'pendingBookings',
            'totalVideos',
            'recentBookings'

        ));
    }
}
