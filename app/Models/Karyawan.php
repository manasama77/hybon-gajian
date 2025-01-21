<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'departement_id',
        'name',
        'join_date',
        'tipe_gaji', // bulanan / harian
        'gaji_pokok',
        'gaji_harian',
        'whatsapp',
        'total_cuti',
        'sisa_cuti',
        'is_active',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function getGajiPokokIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    public function getGajiHarianIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_harian, 0, ',', '.');
    }

    public function getStatusKaryawanAttribute()
    {
        if ($this->is_active) {
            return 'AKTIF';
        }

        return 'TIDAK AKTIF';
    }

    public function getWhatsappLinkAttribute()
    {
        $whatsapp = $this->whatsapp;

        $whatsapp = str_replace(['-', ' ', '+'], '', $whatsapp);
        $whatsapp = str_replace('0', '62', $whatsapp);

        return 'https://wa.me/' . $whatsapp;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function data_kehadiran()
    {
        return $this->hasMany(DataKehadiran::class);
    }

    public function data_lembur()
    {
        return $this->hasMany(DataLembur::class);
    }

    public function data_ijin()
    {
        return $this->hasMany(DataIjin::class);
    }

    public function data_kasbon()
    {
        return $this->hasMany(DataKasbon::class);
    }

    public function request_kehadiran()
    {
        return $this->hasMany(RequestKehadiran::class);
    }
}
