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
        Schema::table('equipment', function (Blueprint $table) {
            $table->date('tgl_pembelian')->nullable();
            $table->string('metode', 100)->nullable();
            $table->integer('nilai_perolehan')->nullable();
            $table->integer('nilai_residu')->nullable();
            $table->integer('masa_manfaat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            //
        });
    }
};
