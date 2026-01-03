<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // 2 Admin (Role ID: 1)
            ['name' => 'Admin Utama', 'email' => 'admin@gmail.com', 'role_id' => 1],
            ['name' => 'Admin Sekunder', 'email' => 'admin2@gmail.com', 'role_id' => 1],

            // 3 Manager (Role ID: 2)
            ['name' => 'Manager Satu', 'email' => 'manager1@gmail.com', 'role_id' => 2],
            ['name' => 'Manager Dua', 'email' => 'manager2@gmail.com', 'role_id' => 2],
            ['name' => 'Manager Tiga', 'email' => 'manager3@gmail.com', 'role_id' => 2],

            // 4 Employee (Role ID: 3)
            ['name' => 'Employee Satu', 'email' => 'emp1@gmail.com', 'role_id' => 3],
            ['name' => 'Employee Dua', 'email' => 'emp2@gmail.com', 'role_id' => 3],
            ['name' => 'Employee Tiga', 'email' => 'emp3@gmail.com', 'role_id' => 3],
            ['name' => 'Employee Empat', 'email' => 'emp4@gmail.com', 'role_id' => 3],

            // 1 User (Role ID: 4)
            ['name' => 'Regular User', 'email' => 'user@gmail.com', 'role_id' => 4],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'), // Lebih aman daripada bcrypt()
                'role_id' => $userData['role_id'],
            ]);
        }
    }
}