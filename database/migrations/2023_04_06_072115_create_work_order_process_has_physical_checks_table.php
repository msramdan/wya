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
        Schema::create('work_order_process_has_physical_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_process_id');
            $table->string('physical_check');
            $table->enum('physical_health', ['good', 'minor damage', 'major damage'])->nullable();
            $table->enum('physical_cleanliness', ['clean', 'dirty'])->nullable();
            $table->timestamps();

            $table->foreign('work_order_process_id', 'work_order_process_id_foreign')
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
        Schema::dropIfExists('work_order_process_has_physical_checks');
    }
};
