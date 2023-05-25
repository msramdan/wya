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
        Schema::create('equipment_reduction_price', function (Blueprint $table) {
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnUpdate()->cascadeOnDelete();
            $table->date('periode');
            $table->string('month', 10);
            $table->integer('total_penyusutan');
            $table->integer('nilai_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_reduction_price');
    }
};
