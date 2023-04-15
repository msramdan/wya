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
            $table->unsignedBigInteger('work_executor_technician_id')->nullable()->after('work_executor_vendor_id');

            $table->foreign('work_executor_technician_id')->references('id')->on('employees');
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
