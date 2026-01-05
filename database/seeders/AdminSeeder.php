<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => env('ADMIN_PHONE')],
            [
            'first_name'    => 'Admin',
            'last_name'     => '',
            'approval_status' => 'approved',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'role' => 'admin',
            ]
        );
    }
}
