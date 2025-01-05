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
        Schema::table('data_lemburs', function (Blueprint $table) {
            $table->integer('menit_lembur')->after('jam_lembur')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_lemburs', function (Blueprint $table) {
            $table->dropColumn('menit_lembur');
        });
    }
};