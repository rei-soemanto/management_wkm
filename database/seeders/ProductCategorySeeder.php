<?php

namespace Database\Seeders;

use App\Models\Products\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::insert([
            ['name' => 'PDC'],
            ['name' => 'mini PDC'],
            ['name' => 'PDN'],
            ['name' => 'PDIO'],
            ['name' => 'PDS'],
        ]);
    }
}
