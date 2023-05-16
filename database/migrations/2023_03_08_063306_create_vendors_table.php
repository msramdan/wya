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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('code_vendor', 20);
            $table->string('name_vendor', 200);
            $table->foreignId('category_vendor_id')->nullable()->constrained('category_vendors')->restrictOnUpdate()->nullOnDelete();
            $table->string('email', 100);
            $table->foreignId('provinsi_id')->nullable()->constrained('provinces')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kabkot_id')->nullable()->constrained('kabkots')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->restrictOnUpdate()->nullOnDelete();
            $table->string('zip_kode', 5);
            $table->text('address');
            $table->string('longitude', 100);
            $table->string('latitude', 100);
            $table->boolean('hospital_id')->nullable()->constrained('hospitals')->restrictOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('vendors');
    }
};
