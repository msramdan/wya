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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('nid_employee', 50);
            $table->foreignId('employee_type_id')->nullable()->constrained('employee_types')->restrictOnUpdate()->nullOnDelete();
            $table->boolean('employee_status');
            $table->foreignId('departement_id')->nullable()->constrained('departments')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('positions')->restrictOnUpdate()->nullOnDelete();
            $table->string('email', 100);
            $table->string('phone', 15);
            $table->foreignId('provinsi_id')->nullable()->constrained('provinces')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kabkot_id')->nullable()->constrained('kabkots')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->restrictOnUpdate()->nullOnDelete();
            $table->string('zip_kode', 10);
            $table->text('address');
            $table->string('longitude', 200);
            $table->string('latitude', 200);
            $table->date('join_date');
            $table->string('photo', 200);
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
        Schema::dropIfExists('employees');
    }
};
