<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nette\Schema\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show admin profile (API / JSON)
     */
    public function show(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user(),
        ]);
    }

    /**
     * Show admin profile blade view
     */
    public function profile(Request $request)
    {
        return view('admin.edit', [
            'admin' => $request->user(),
        ]);
    }

    /**
     * Update admin profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validate all the fields including image and new profile fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,'.$user->id,
            'mobile' => 'required|string|max:15|unique:users,mobile,'.$user->id,
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'pincode' => 'nullable|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Handle Profile Image Upload if provided
        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($user->profile_photo && Storage::exists('public/'.$user->profile_photo)) {
                Storage::delete('public/'.$user->profile_photo);
            }
        // Store new image path directly into the 'profile_photo' database column
             $user->profile_photo = $request->file('image')->store('admin_profiles', 'public');
    }
        

        // Update other fields
        $user->update($request->only(['name', 'mobile', 'city', 'state', 'address', 'pincode']));
        $user->save(); // Save the object


        // 4. Return response (supports both AJAX/JSON or standard web redirects)
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Admin profile updated successfully.',
                'user' => $user->fresh(),
            ]);
        }

        return redirect()->back()->with('success', 'Admin profile updated successfully.');
    }

    public function editpassword(){
        return view('admin.change-password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if(!Hash::check($request->current_password , $user->password)){
                throw ValidationException::withMessage([
                    'current_password' => ['The Provided old password does not match our records.']
                ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.password.edit')->with('success','Password changed successfully.');
    }
}
