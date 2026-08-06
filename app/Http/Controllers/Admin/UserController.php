<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
       $users = User::where('role', 'user')->latest()->get();


         return view('admin.users.index', compact('users'));
    }
}
