<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Switch to TEXT to allow long maintenance descriptions
        DB::statement('ALTER TABLE `car` MODIFY `maintenance_method` TEXT NULL');
    }

    public function down(): void
    {
        // Revert to VARCHAR(255) if needed
        DB::statement('ALTER TABLE `car` MODIFY `maintenance_method` VARCHAR(255) NULL');
    }
};
