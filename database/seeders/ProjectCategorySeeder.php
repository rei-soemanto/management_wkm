<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('project_categories')->insert([
            ['name' => 'PLC Integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PLC Modification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SCADA Integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SCADA Modification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electrical/Mechanical Installation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electrical/Mechanical Modification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sensor Installation/Modification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reporting Installation/Modification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PIMS Integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OEE Integration', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
