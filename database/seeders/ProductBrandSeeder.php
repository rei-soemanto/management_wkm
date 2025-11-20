<?php

namespace Database\Seeders;

use App\Models\Products\ProductBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductBrand::insert([
            ['name' => 'TieBox'],
            ['name' => 'ai-Sen'],
            ['name' => 'Acrel'],
        ]);
    }
}
