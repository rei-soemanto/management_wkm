<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables to update.
     */
    protected $tables = ['products', 'services', 'projects'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                
                // 1. Check if the OLD column exists (from your SQL dump)
                if (Schema::hasColumn($tableName, 'last_updated_by')) {
                    // Rename it to match the new ERD ('last_update_by')
                    $table->renameColumn('last_updated_by', 'last_update_by');
                } 
                // 2. Check if the NEW column doesn't exist yet
                elseif (!Schema::hasColumn($tableName, 'last_update_by')) {
                    // Create it fresh
                    $table->foreignId('last_update_by')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Rename back to the old SQL dump style if rolling back
                if (Schema::hasColumn($tableName, 'last_update_by')) {
                    $table->renameColumn('last_update_by', 'last_updated_by');
                }
            });
        }
    }
};