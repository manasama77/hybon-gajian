<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataIjin extends Model
{
    // tipe ijin = ['cuti', 'sakit dengan surat dokter', 'ijin potong gaji']
    protected $fillable = [
        'karyawan_id',
        'tipe_ijin',
        'from_date',
        'to_date',
        'total_hari',
        'keterangan',
        'lampiran',
        'is_approved',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'from_date'   => 'date',
        'to_date'     => 'date',
        'approved_at' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(Karyawan::class, 'approved_by');
    }
}
