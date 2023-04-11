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
        Schema::create('work_order_process_has_wo_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_process_id');
            $table->string('document_name');
            $table->text('description')->nullable();
            $table->string('file');
            $table->timestamps();

            $table->foreign('work_order_process_id', 'work_order_process_wo_doc_id_foreign')->references('id')->on('work_order_processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_process_has_wo_documents');
    }
};
