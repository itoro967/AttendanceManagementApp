<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.jp',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => true,
            'remember_token' => Str::random(10)
        ]);
    }
}
