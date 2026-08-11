<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Get logged-in user's profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'user' => $user,
        ]);
    }

    /**
     * Update logged-in user's profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|size:10',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'required|in:Single,Married,Divorced',

            'dob' => 'nullable|date',
            'anniversary_date' => 'nullable|date',

            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|size:6',

            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Profile Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_photo')) {

            // Delete old profile photo
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store(
                'profile_photos',
                'public'
            );

            $validated['profile_photo'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | Anniversary handling
        |--------------------------------------------------------------------------
        */

        if ($request->marital_status !== 'Married') {
            $validated['anniversary_date'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Update user
        |--------------------------------------------------------------------------
        */

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.',
            'user' => $user->fresh(),
        ]);
    }
}