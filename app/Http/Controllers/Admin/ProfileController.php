<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show admin profile
     */
    public function show(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user(),
        ]);
    }

    public function profile(Request $request)
    {
        return view('admin.profile', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Update admin profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:10|unique:users,mobile,' . $user->id,
        ]);

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Admin profile updated successfully.',
            'user' => $user->fresh(),
        ]);
    }
}
