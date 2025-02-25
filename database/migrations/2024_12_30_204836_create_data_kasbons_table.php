<?php

use App\Models\Karyawan;
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
        Schema::create('data_kasbons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Karyawan::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kasbons');
    }
};
