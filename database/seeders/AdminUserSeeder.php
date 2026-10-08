<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'admin@apnakisaan.in'],
            [
                'name'     => 'हेमंत कच्छी',
                'email'    => 'admin@apnakisaan.in',
                'mobile'   => '6265071588',
                'role'     => 'superadmin',
                'password' => Hash::make('Admin@123456'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Admin Staff
        User::updateOrCreate(
            ['email' => 'staff@apnakisaan.in'],
            [
                'name'     => 'कृषि सलाहकार',
                'email'    => 'staff@apnakisaan.in',
                'mobile'   => '9876543210',
                'role'     => 'admin',
                'password' => Hash::make('Staff@123456'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
    }
}
