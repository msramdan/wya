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
        Schema::create('work_order_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->date('schedule_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('schedule_wo', ['Harian', 'Mingguan', 'Bulanan', '2 Bulanan', '3 Bulanan', '4 Bulanan', '6 Bulanan', 'Tahunan'])->nullable();
            $table->enum('status', ['ready-to-start', 'on-progress', 'finished']);
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_processes');
    }
};
