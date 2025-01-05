<?php

use App\Models\User;
use App\Models\Karyawan;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Karyawan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PeriodeCutoff::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->integer('jam_terlambat');
            $table->integer('menit_terlambat');
            $table->boolean('is_approved')->nullable()->default(null);
            $table->foreignIdFor(User::class, 'approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_kehadirans');
    }
};
