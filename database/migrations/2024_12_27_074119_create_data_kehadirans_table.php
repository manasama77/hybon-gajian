<?php

use App\Models\Karyawan;
use App\Models\PeriodeCutoff;
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
        Schema::create('data_kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Karyawan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PeriodeCutoff::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('clock_in');
            $table->time('clock_out')->nullable();
            $table->integer('jam_terlambat')->default(0);
            $table->string('foto_in');
            $table->string('foto_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kehadirans');
    }
};
