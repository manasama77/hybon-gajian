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
            $table->dropForeign(['periode_cutoff_id']);
            $table->dropColumn('periode_cutoff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_lemburs', function (Blueprint $table) {
            $table->unsignedBigInteger('periode_cutoff_id');
            $table->foreign('periode_cutoff_id')->references('id')->on('periode_cutoffs');
        });
    }
};
