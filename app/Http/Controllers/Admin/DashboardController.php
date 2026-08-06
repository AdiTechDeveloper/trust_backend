<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
     public function index()
    {
        // Abhi sirf layout test karne ke liye simple view return kar rahe hain.
        // Next module mein hum yahan actual stats (total members, donations, etc.) pass karenge.
        return view('admin.dashboard');
    }
}
