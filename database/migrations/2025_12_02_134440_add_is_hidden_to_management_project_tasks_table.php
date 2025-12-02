<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('management_project_tasks', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false)->after('due_date');
        });
    }

    public function down(): void
    {
        Schema::table('management_project_tasks', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
};