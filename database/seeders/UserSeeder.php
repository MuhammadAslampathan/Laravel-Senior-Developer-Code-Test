<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tms.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'api_token' => Str::random(64),
            ]
        );
    }
}
