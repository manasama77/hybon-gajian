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
        Schema::create('periode_cutoffs', function (Blueprint $table) {
            $table->id();
            $table->date('kehadiran_start');
            $table->date('kehadiran_end');
            $table->date('lembur_start');
            $table->date('lembur_end');
            $table->integer('hari_kerja')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_cutoffs');
    }
};
