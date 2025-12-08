<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('service_categories')->insert([
            ['name' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineering', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
