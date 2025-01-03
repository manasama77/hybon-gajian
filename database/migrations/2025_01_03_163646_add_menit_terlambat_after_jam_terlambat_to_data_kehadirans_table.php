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
        Schema::table('data_kehadirans', function (Blueprint $table) {
            $table->integer('menit_terlambat')->after('jam_terlambat')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_kehadirans', function (Blueprint $table) {
            $table->dropColumn('menit_terlambat');
        });
    }
};
