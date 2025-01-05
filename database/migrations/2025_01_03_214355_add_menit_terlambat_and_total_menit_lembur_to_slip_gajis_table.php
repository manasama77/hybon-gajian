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
        Schema::table('slip_gajis', function (Blueprint $table) {
            $table->integer('menit_terlambat')->default(0)->after('jam_terlambat');
            $table->integer('total_menit_lembur')->default(0)->after('total_jam_lembur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slip_gajis', function (Blueprint $table) {
            $table->dropColumn('menit_terlambat');
            $table->dropColumn('total_menit_lembur');
        });
    }
};
