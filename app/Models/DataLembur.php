<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLembur extends Model
{
    protected $fillable = [
        'karyawan_id',
        'periode_cutoff_id',
        'overtime_in',
        'overtime_out',
        'jam_lembur',
        'menit_lembur',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'overtime_in'  => 'datetime',
        'overtime_out' => 'datetime',
        'approved_at'  => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function periode_cutoff()
    {
        return $this->belongsTo(PeriodeCutoff::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeNotApproved($query)
    {
        return $query->where('is_approved', false);
    }
}
