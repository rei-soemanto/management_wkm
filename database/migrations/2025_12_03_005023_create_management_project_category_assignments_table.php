<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_project_category_assignments', function (Blueprint $table) {
            $table->foreignId('management_project_id');
            $table->foreignId('project_category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_project_category_assignments');
    }
};