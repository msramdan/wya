<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_order_processes', function (Blueprint $table) {
            $table->string('mesh_voltage')->default(0)->after('final_humidity');
            $table->string('ups')->default(0)->after('mesh_voltage');
            $table->string('grounding')->default(0)->after('ups');
            $table->string('leakage_electric')->default(0)->after('grounding');
            $table->text('electrical_safety_note')->nullable()->after('leakage_electric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_processes', function (Blueprint $table) {
            //
        });
    }
};
