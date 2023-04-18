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
        Schema::create('wo_process_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wo_process_id');
            $table->string('status_wo_process');
            $table->dateTime('date_time');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('wo_process_id')->references('id')->on('work_order_processes');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wo_process_histories');
    }
};
