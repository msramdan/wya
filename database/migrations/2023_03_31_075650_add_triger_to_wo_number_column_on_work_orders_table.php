<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
                CREATE
                    TRIGGER wo_number_work_order BEFORE INSERT 
                    ON work_orders
                    FOR EACH ROW BEGIN
                            DECLARE amount_wo BIGINT;
                                                SELECT COUNT(*) FROM work_orders WHERE DATE_FORMAT(created_at, '%Y%m%d') = DATE_FORMAT(CURDATE(), '%Y%m%d') INTO amount_wo;

                        SET NEW.wo_number = CONCAT('WO-', DATE_FORMAT(CURDATE(), '%Y%m%d'), '-', LPAD(amount_wo + 1, 4, '0'));
                END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};
