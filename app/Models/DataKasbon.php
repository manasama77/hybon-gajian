<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKasbon extends Model
{
    protected $fillable = ['karyawan_id', 'tanggal', 'jumlah'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
