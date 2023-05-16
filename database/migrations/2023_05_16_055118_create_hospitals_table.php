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
			$table->string('url_wa_gateway', 150);
			$table->string('session_wa_gateway', 150);
			$table->boolean('paper_qr_code');
			$table->boolean('bot_telegram');
			$table->text('work_order_has_access_approval_users_id');
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
