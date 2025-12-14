<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_project_usages', function (Blueprint $table) {
            $table->integer('quantity_needed')->after('product_inventory_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('product_project_usages', function (Blueprint $table) {
            $table->dropColumn('quantity_needed');
        });
    }
};