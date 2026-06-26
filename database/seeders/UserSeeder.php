<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Gestor Admin',
            'email' => 'admin@agua.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Leiturista',
            'email' => 'leiturista@agua.com',
            'password' => Hash::make('password'),
            'role' => 'leiturista',
        ]);
    }
}