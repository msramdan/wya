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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 200);
            $table->string('sparepart_name', 200);
            $table->string('merk', 200);
            $table->string('sparepart_type', 200);
            $table->foreignId('unit_id')->nullable()->constrained('unit_items')->restrictOnUpdate()->nullOnDelete();
            $table->integer('estimated_price');
            $table->integer('stock')->nullable();
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
        Schema::dropIfExists('spareparts');
    }
};
