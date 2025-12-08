<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductBrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_brands')->insert([
            ['name' => 'TieBox', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ai-Sen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Acrel', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
