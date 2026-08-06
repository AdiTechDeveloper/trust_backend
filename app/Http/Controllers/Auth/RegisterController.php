<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Registration Successful',
            'data' => $user,
        ], 201);
    }

    public function users()
    {
        $users = User::latest()->get();

        return response()->json([
            'status' => true,
            'users' => $users,
        ]);
    }
}
