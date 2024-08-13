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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('no_peminjaman', 100);
			$table->foreignId('equipment_id')->nullable()->constrained('equipment')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('hospital_id')->nullable()->constrained('hospitals')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('lokasi_asal_id')->nullable()->constrained('equipment_locations')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('lokasi_peminjam_id')->nullable()->constrained('equipment_locations')->restrictOnUpdate()->nullOnDelete();
			$table->dateTime('waktu_pinjam');
			$table->dateTime('waktu_dikembalikan')->nullable();
			$table->text('alasan_peminjaman');
			$table->enum('status_peminjaman', ['Sudah dikembalikan', 'Belum dikembalikan']);
			$table->text('catatan_pengembalian')->nullable();
			$table->foreignId('pic_penanggungjawab')->nullable()->constrained('employees')->restrictOnUpdate()->nullOnDelete();
            $table->text('bukti_pengembalian')->nullable();
			$table->foreignId('user_created')->nullable()->constrained('users')->restrictOnUpdate()->nullOnDelete();
			$table->foreignId('user_updated')->nullable()->constrained('users')->restrictOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('loans');
    }
};
