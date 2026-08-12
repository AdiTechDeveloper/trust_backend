<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\CommunityFamilyMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            if (! empty($data['family_members'])) {
                foreach ($data['family_members'] as $family) {
                    CommunityFamilyMember::create([
                        'user_id' => $user->id,
                        'name' => $family['name'],
                        'relation' => $family['relation'],
                        'dob' => $family['dob'],
                        'anniversary_date' => $family['anniversary_date'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Registration successful.',
                'data' => $user->load('familyMembers'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong during registration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function users()
    {
        $users = User::with('familyMembers')->latest()->get();

        return response()->json([
            'status' => true,
            'users' => $users,
        ]);
    }
}
