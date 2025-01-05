<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeCutoff extends Model
{
    protected $fillable = [
        'kehadiran_start',
        'kehadiran_end',
        'lembur_start',
        'lembur_end',
        'hari_kerja',
        'is_active',
    ];

    protected $casts = [
        'kehadiran_start' => 'date',
        'kehadiran_end'   => 'date',
        'lembur_start'    => 'date',
        'lembur_end'      => 'date',
        'is_active'       => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function getStatusAttribute()
    {
        $value = $this->is_active;
        return $value ? '✅' : '❌';
    }

    public function data_kehadiran()
    {
        return $this->hasMany(DataKehadiran::class);
    }

    public function data_lembur()
    {
        return $this->hasMany(DataLembur::class);
    }

    public function request_kehadiran()
    {
        return $this->hasMany(RequestKehadiran::class);
    }
}
