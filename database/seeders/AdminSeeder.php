<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@rudreshwartrust.com',
            ],
            [
                'name' => 'Trust Admin',
                'mobile' => '9999999999',
                'gender' => 'Male',
                'marital_status' => 'Single',
                'status' => true,
                'role' => 'admin',
                'password' => Hash::make('Admin@12345'),
            ]
        );
    }
}