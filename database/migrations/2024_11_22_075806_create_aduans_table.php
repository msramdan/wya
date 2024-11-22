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
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
			$table->string('email')->unique();
			$table->string('judul');
			$table->text('keterangan');
			$table->dateTime('tanggal');
			$table->enum('type', ['Public', 'Private']);
			$table->enum('is_read', ['Yes', 'No']);
            $table->enum('status', ['Dalam Penanganan', 'Ditolak','Selesai']);
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
        Schema::dropIfExists('aduans');
    }
};
