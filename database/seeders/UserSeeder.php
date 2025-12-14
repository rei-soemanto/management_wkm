<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'employee',
            'email' => 'employee@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);
    }
}
