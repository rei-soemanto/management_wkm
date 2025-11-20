<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Don't forget to import DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create the Roles table FIRST
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'Admin', 'Employee'
            $table->timestamps();
        });

        // 2. Seed the default roles immediately so ID 1 and 2 exist
        DB::table('user_roles')->insert([
            ['name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Employee', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Create the Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // --- REVISED ROLE COLUMN ---
            // Replaces: $table->string('role')->default('user');
            // We set default to '2' (Employee) assuming the seed above ran correctly.
            $table->foreignId('role_id')->default(2)->constrained('user_roles');
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_roles'); // Drop roles as well
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};