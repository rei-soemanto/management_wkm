<?php

namespace Database\Seeders;

use App\Models\Projects\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectCategory::insert([
            ['name' => 'PLC Integration'],
            ['name' => 'PLC Modification'],
            ['name' => 'SCADA Integration'],
            ['name' => 'SCADA Modification'],
            ['name' => 'Electrical/Mechanical Installation'],
            ['name' => 'Electrical/Mechanical Modification'],
            ['name' => 'Sensor Installation/Modification'],
            ['name' => 'Reporting Installation/Modification'],
            ['name' => 'PIMS Integration'],
            ['name' => 'OEE Integration'],
        ]);
    }
}
