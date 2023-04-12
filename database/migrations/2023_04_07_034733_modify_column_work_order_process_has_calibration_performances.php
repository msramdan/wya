<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_order_process_has_calibration_performances', function (Blueprint $table) {
            $table->string('setting')->change();
            $table->string('measurable')->change();
            $table->string('reference_value')->change();
            $table->boolean('is_good')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_process_has_calibration_performances', function (Blueprint $table) {
            //
        });
    }
};
