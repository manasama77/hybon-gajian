<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKehadiran extends Model
{
    protected $fillable = [
        'karyawan_id',
        'periode_cutoff_id',
        'tanggal',
        'clock_in',
        'clock_out',
        'jam_terlambat',
        'menit_terlambat',
        'foto_in',
        'foto_out',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function periode_cutoff()
    {
        return $this->belongsTo(PeriodeCutoff::class);
    }
}
