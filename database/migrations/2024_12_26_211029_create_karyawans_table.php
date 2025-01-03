<?php

use App\Models\User;
use App\Models\Departement;
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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Departement::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->date('join_date');
            $table->enum('tipe_gaji', ['bulanan', 'harian']);
            $table->string('gaji_pokok');
            $table->string('gaji_harian');
            $table->string(column: 'whatsapp');
            $table->integer('total_cuti')->default(0);
            $table->integer('sisa_cuti')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
