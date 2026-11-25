<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                // Hash::make funciona em qualquer versão (o cast "hashed" só existe no Laravel >= 10.14).
                'password' => Hash::make('123456'),
            ]
        );
    }
}
