<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Project Roles (e.g., Project Manager, Engineer)
        Schema::create('project_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        DB::table('project_roles')->insert([
            ['name' => 'Project Manager', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technician', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Role Assignments (Pivot with Model)
        Schema::create('management_project_role_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('project_roles');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('management_project_id')->constrained('management_projects')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Progress Logs
        Schema::create('management_project_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('management_project_id')->constrained('management_projects')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('status');
            $table->date('progress_date');
            $table->text('document_path');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_project_progress');
        Schema::dropIfExists('management_project_role_assignments');
        Schema::dropIfExists('project_roles');
    }
};