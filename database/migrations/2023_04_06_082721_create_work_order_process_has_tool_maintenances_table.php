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
        Schema::create('work_order_process_has_tool_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_process_id');
            $table->text('information');
            $table->enum('status', ['Yes', 'No', 'NA']);
            $table->timestamps();

            $table->foreign('work_order_process_id', 'work_order_process_tool_maintenances_id_foreign')
            ->references('id')
            ->on('work_order_processes')
            ->onDelete('cascade')
            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_process_has_tool_maintenances');
    }
};
