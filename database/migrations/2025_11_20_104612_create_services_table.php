<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('category_id')->nullable($value = true);
            $table->string('name');
            $table->text('description')->nullable($value = true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
