<?php

namespace Database\Seeders;

use App\Models\Services\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCategory::insert([
            ['name' => 'Maintenance'],
            ['name' => 'Engineering'],
        ]);
    }
}
