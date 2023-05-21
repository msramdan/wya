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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnUpdate()->restrictOnDelete();
            $table->boolean('type_wo');
            $table->date('filed_date');
            $table->boolean('category_wo');
            $table->date('schedule_date');
            $table->text('note');
            $table->foreignId('created_by')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->boolean('status_wo');
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
        Schema::dropIfExists('work_orders');
    }
};
