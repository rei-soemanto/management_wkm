<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductBrandSeeder::class,
            ProductCategorySeeder::class,
            ServiceCategorySeeder::class,
            ProjectCategorySeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class
        ]);
    }
}
