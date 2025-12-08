<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            ['name' => 'PDC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mini PDC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDIO', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
