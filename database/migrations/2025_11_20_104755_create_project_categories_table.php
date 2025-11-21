<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_categories');
    }
};
