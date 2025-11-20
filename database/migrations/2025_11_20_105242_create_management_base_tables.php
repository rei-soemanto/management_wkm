<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Clients Table
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pic_name');
            $table->string('email');
            $table->timestamps();
        });

        // 2. Status Table
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Seed Statuses
        DB::table('status')->insert([
            ['name' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Progress', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finished', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelled', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Management Projects Table
        Schema::create('management_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('status');
            $table->foreignId('client_id')->constrained('clients');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_projects');
        Schema::dropIfExists('status');
        Schema::dropIfExists('clients');
    }
};