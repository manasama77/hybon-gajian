<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    protected $fillable = [
        'karyawan_id',
        'periode_cutoff_id',
        'tipe_gaji', // harian / bulanan
        'gaji_pokok',
        'gaji_harian',
        'total_hari_kerja',
        'gaji_kehadiran',
        'total_cuti',
        'total_sakit',
        'total_hari_tidak_kerja',
        'potongan_tidak_kerja',
        'total_hari_ijin',
        'potongan_ijin',
        'jam_terlambat',
        'menit_terlambat',
        'potongan_terlambat',
        'prorate',
        'total_jam_lembur',
        'total_menit_lembur',
        'gaji_lembur',
        'potongan_kasbon',
        'take_home_pay',
        'take_home_pay_rounded',
        'file_pdf',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function periode_cutoff()
    {
        return $this->belongsTo(related: PeriodeCutoff::class);
    }

    public function getGajiPokokIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_pokok, 2, ',', '.');
    }

    public function getGajiHarianIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_harian, 2, ',', '.');
    }

    public function getGajiKehadiranIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_kehadiran, 2, ',', '.');
    }

    public function getPotonganTidakKerjaIdrAttribute()
    {
        return 'Rp. ' . number_format($this->potongan_tidak_kerja, 2, ',', '.');
    }

    public function getPotonganIjinIdrAttribute()
    {
        return 'Rp. ' . number_format($this->potongan_ijin, 2, ',', '.');
    }

    public function getPotonganTerlambatIdrAttribute()
    {
        return 'Rp. ' . number_format($this->potongan_terlambat, 2, ',', '.');
    }

    public function getGajiLemburIdrAttribute()
    {
        return 'Rp. ' . number_format($this->gaji_lembur, 2, ',', '.');
    }

    public function getTakeHomePayIdrAttribute()
    {
        return 'Rp. ' . number_format($this->take_home_pay, 2, ',', '.');
    }

    public function getTakeHomePayRoundedIdrAttribute()
    {
        return 'Rp. ' . number_format($this->take_home_pay_rounded, 2, ',', '.');
    }
}
