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
        Schema::create('work_order_photo_before', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->nullable()->constrained('work_orders')->restrictOnUpdate()->nullOnDelete();
            $table->string('name_photo', 200);
            $table->string('photo', 200);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_order_photo_before');
    }
};
