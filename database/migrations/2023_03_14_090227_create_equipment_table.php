<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 100);
			$table->foreignId('nomenklatur_id')->nullable()->constrained('nomenklaturs')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('equipment_category_id')->nullable()->constrained('equipment_categories')->restrictOnUpdate()->nullOnDelete();
			$table->string('manufacturer', 255);
			$table->string('type', 255);
			$table->string('serial_number', 255);
			$table->foreignId('vendor_id')->nullable()->constrained('vendors')->restrictOnUpdate()->nullOnDelete();
			$table->boolean('condition');
			$table->boolean('risk_level');
			$table->foreignId('equipment_location_id')->nullable()->constrained('equipment_locations')->restrictOnUpdate()->nullOnDelete();
			$table->string('financing_code', 255);
			$table->string('photo', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};
