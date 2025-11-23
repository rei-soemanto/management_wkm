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
                
                if (Schema::hasColumn($tableName, 'last_updated_by')) {
                    $table->renameColumn('last_updated_by', 'last_update_by');
                } 
                elseif (!Schema::hasColumn($tableName, 'last_update_by')) {
                    $table->foreignId('last_update_by')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'last_update_by')) {
                    $table->renameColumn('last_update_by', 'last_updated_by');
                }
            });
        }
    }
};