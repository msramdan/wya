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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('schedule_date');
            $table->date('end_date')->nullable()->after('start_date');
            $table->enum('schedule_wo', ['Harian', 'Mingguan', 'Bulanan', '2 Bulanan', '3 Bulanan', '4 Bulanan', '6 Bulanan', 'Tahunan'])->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};
