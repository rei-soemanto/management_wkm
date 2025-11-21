<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->foreignId('last_update_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('product_project_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_project_id')->constrained('management_projects')->onDelete('cascade');
            $table->foreignId('product_inventory_id')->constrained('product_inventories');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_project_usages');
        Schema::dropIfExists('product_inventories');
    }
};