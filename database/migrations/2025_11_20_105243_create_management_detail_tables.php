<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Project Roles
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
            
            // FIX: Use a shorter custom index name
            $table->unsignedBigInteger('management_project_id');
            $table->foreign('management_project_id', 'mpra_mgmt_project_id_foreign')
                  ->references('id')
                  ->on('management_projects')
                  ->onDelete('cascade');

            $table->timestamps();
        });

        // 3. Progress Logs
        Schema::create('management_project_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            
            // FIX: Use a shorter custom index name here too just in case
            $table->unsignedBigInteger('management_project_id');
            $table->foreign('management_project_id', 'mpp_mgmt_project_id_foreign') // Short name here
                  ->references('id')
                  ->on('management_projects')
                  ->onDelete('cascade');

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