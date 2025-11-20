<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {

        User::create(
            [
                'name' => 'Rei Soemanto',
                'email' => 'reresoemanto@gmail.com',
                'password' => '@Cc2061355',
                'role_id' => 1,
                'email_verified_at' => now(),
            ]
        );
    }
}