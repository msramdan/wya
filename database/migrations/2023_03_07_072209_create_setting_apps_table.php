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
        Schema::create('setting_apps', function (Blueprint $table) {
            $table->id();
            $table->string('aplication_name', 200);
			$table->string('logo', 255);
			$table->string('favicon', 255);
			$table->string('phone', 15);
			$table->string('email', 200);
			$table->text('address');
            $table->boolean('notif_wa');
			$table->string('url_wa_gateway', 200);
			$table->string('session_wa_gateway', 200);
			$table->boolean('bot_telegram');
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
        Schema::dropIfExists('setting_apps');
    }
};
