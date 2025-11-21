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
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('product_brands')->insert([
            ['name' => 'TieBox', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ai-Sen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Acrel', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_brands');
    }
};
