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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('phone', 15);
            $table->string('email', 150);
            $table->text('address', 255);
            $table->string('logo');
            $table->boolean('notif_wa');
            $table->string('url_wa_gateway', 150)->nullable();
            $table->string('session_wa_gateway', 150)->nullable();
            $table->float('paper_qr_code', 8, 4);
            $table->boolean('bot_telegram');
            $table->json('work_order_has_access_approval_users_id')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
};
