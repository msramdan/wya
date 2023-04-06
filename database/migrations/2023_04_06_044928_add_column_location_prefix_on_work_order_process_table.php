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
            $table->string('initial_temperature')->default(0)->after('work_executor_vendor_id');
            $table->string('initial_humidity')->default(0)->after('initial_temperature');
            $table->string('final_temperature')->default(0)->after('initial_humidity');
            $table->string('final_humidity')->default(0)->after('final_temperature');
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
