<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 將既有日期先轉成年份數字，避免型別轉換失敗
        DB::statement("UPDATE devices SET warranty_end = YEAR(warranty_end) WHERE warranty_end IS NOT NULL");

        // MySQL: change warranty_end from DATE to small unsigned int (years)
        DB::statement('ALTER TABLE devices MODIFY warranty_end SMALLINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 回復為 DATE 型別（資料將保留為當前數字轉為日期時會失真，這裡直接設為 NULL）
        DB::statement('ALTER TABLE devices MODIFY warranty_end DATE NULL');
        DB::statement('UPDATE devices SET warranty_end = NULL');
    }
};
