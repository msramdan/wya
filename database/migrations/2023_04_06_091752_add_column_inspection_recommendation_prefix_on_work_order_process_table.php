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
        Schema::table('work_order_processes', function (Blueprint $table) {
            $table->boolean('tools_can_be_used_well')->default(false)->after('replacement_of_part_service_price');
            $table->boolean('tool_cannot_be_used')->default(false)->after('tools_can_be_used_well');
            $table->boolean('tool_need_repair')->default(false)->after('tool_cannot_be_used');
            $table->boolean('tool_can_be_used_need_replacement_accessories')->default(false)->after('tool_need_repair');
            $table->boolean('tool_need_calibration')->default(false)->after('tool_can_be_used_need_replacement_accessories');
            $table->boolean('tool_need_bleaching')->default(false)->after('tool_need_calibration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_processes', function (Blueprint $table) {
            //
        });
    }
};
