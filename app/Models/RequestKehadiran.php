<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestKehadiran extends Model
{
    protected $fillable = [
        'karyawan_id',
        'periode_cutoff_id',
        'tanggal',
        'clock_in',
        'clock_out',
        'jam_terlambat',
        'menit_terlambat',
        'alasan',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'tanggal'         => 'date',
        'jam_terlambat'   => 'integer',
        'menit_terlambat' => 'integer',
        'is_approved'     => 'boolean',
        'approved_at'     => 'datetime',
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
