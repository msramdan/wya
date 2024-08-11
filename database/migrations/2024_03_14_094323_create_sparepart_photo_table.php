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
        Schema::create('sparepart_photo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sparepart_id')->nullable()->constrained('spareparts')->restrictOnUpdate()->nullOnDelete();
            $table->string('name_photo', 200);
            $table->string('photo', 200);
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
        Schema::dropIfExists('sparepart_photo');
    }
};
