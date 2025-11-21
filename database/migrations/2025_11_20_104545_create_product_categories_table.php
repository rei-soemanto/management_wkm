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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('product_categories')->insert([
            ['name' => 'PDC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mini PDC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDIO', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PDS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
