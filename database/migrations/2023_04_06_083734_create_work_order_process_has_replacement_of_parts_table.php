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
        Schema::create('work_order_process_has_replacement_of_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_process_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->double('price');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('work_order_process_id', 'work_order_process_rplc_prts_id_foreign')->references('id')->on('work_order_processes');
            $table->foreign('sparepart_id', 'foreign_sparepart_id_rplcmnt_prts')->references('id')->on('spareparts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_process_has_replacement_of_parts');
    }
};
