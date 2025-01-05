<?php

namespace App\Http\Controllers;

use App\Models\DataIjin;
use App\Models\DataKasbon;
use App\Models\Karyawan;
use App\Models\DataLembur;
use Illuminate\Http\Request;
use App\Models\DataKehadiran;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $pengeluaran_gaji_full  = 0;
        $gaji_kehadiran         = 0;
        $potongan_absen         = 0;
        $lembur                 = 0;
        $potongan_keterlambatan = 0;
        $potongan_ijin          = 0;
        $potongan_kasbon        = 0;
        $thp                    = 0;

        $periode_cutoff = PeriodeCutoff::active()->first();

        if ($periode_cutoff) {
            $total_hari_kerja = $periode_cutoff->hari_kerja;
            $kehadiran_start  = $periode_cutoff->kehadiran_start;
            $kehadiran_end    = $periode_cutoff->kehadiran_end;

            // pengeluaran gaji full
            $karyawans = Karyawan::where('is_active', true);
            if (Auth::user()->hasRole('karyawan')) {
                $karyawans->where('id', Auth::user()->karyawan->id);
            }
            $karyawans = $karyawans->get();
            foreach ($karyawans as $karyawan) {
                $tipe_gaji = $karyawan->tipe_gaji;
                if ($tipe_gaji == 'bulanan') {
                    $pengeluaran_gaji_full += $karyawan->gaji_pokok;
                } else {
                    $pengeluaran_gaji_full += $karyawan->gaji_harian * $total_hari_kerja;
                }
            }

            // pengeluaran gaji kehadiran & potongan keterlambatan & potongan ijin
            foreach ($karyawans as $karyawan) {
                $karyawan_id = $karyawan->id;
                $tipe_gaji   = $karyawan->tipe_gaji;
                $gaji_pokok  = $karyawan->gaji_pokok;
                $gaji_harian = $karyawan->gaji_harian;

                $data_kehadirans = DataKehadiran::where('periode_cutoff_id', $periode_cutoff->id)
                    ->where('karyawan_id', $karyawan_id);

                $count_hari_kerja    = $data_kehadirans->count();
                $sum_menit_terlambat = $data_kehadirans->sum('menit_terlambat');

                $potongan_keterlambatan = $sum_menit_terlambat * (config('app.potongan_terlambat') / 60);

                if ($count_hari_kerja == $total_hari_kerja) {
                    if ($tipe_gaji == 'bulanan') {
                        $gaji_kehadiran += $gaji_pokok;
                    } else {
                        $gaji_kehadiran += round($gaji_harian * $count_hari_kerja, 2);
                    }
                } else {
                    if ($tipe_gaji == 'bulanan') {
                        $gaji_kehadiran += round(($gaji_pokok / $total_hari_kerja) * $count_hari_kerja, 2);
                    } else {
                        $gaji_kehadiran += round($gaji_harian * $count_hari_kerja, 2);
                    }
                }

                // potongan ijin
                $data_ijins = DataIjin::where('is_approved', true)
                    ->where('karyawan_id', $karyawan_id)
                    ->where('from_date', '>=', $kehadiran_start->toDateString())
                    ->where('to_date', '<=', $kehadiran_end->toDateString());

                if ($tipe_gaji == 'bulanan') {
                    $potongan_ijin += $data_ijins->count() * ($gaji_pokok / $total_hari_kerja);
                } else {
                    $potongan_ijin += $data_ijins->count() * $gaji_harian;
                }

                $data_kasbons = DataKasbon::where('karyawan_id', $karyawan_id)
                    ->whereBetween('tanggal', [$kehadiran_start->toDateString(), $kehadiran_end->toDateString()]);

                $potongan_kasbon += $data_kasbons->sum('jumlah');
            }
            $gaji_kehadiran         = round($gaji_kehadiran, 2);
            $potongan_absen         = round($pengeluaran_gaji_full - $gaji_kehadiran, 2);
            $potongan_keterlambatan = round($potongan_keterlambatan, 2);
            $potongan_ijin          = round($potongan_ijin, 2);
            $potongan_kasbon        = round($potongan_kasbon, 2);

            // pengeluaran lembur
            $lemburs = DataLembur::where('periode_cutoff_id', $periode_cutoff->id)->where('is_approved', true);
            if (Auth::user()->hasRole('karyawan')) {
                $lemburs->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $lembur = $lemburs->sum('menit_lembur') * (config('app.lembur_rate') / 60);
        }

        $thp = round($gaji_kehadiran + $lembur - $potongan_absen - $potongan_keterlambatan - $potongan_ijin - $potongan_kasbon, 2);

        $thp_show = number_format($thp, 2, ',', '.');
        $thp_hide = preg_replace('/\d/', '*', $thp_show);

        $lembur_show = number_format($lembur, 2, ',', '.');
        $lembur_hide = preg_replace('/\d/', '*', $lembur_show);

        $potongan_absen_show = number_format($potongan_absen, 2, ',', '.');
        $potongan_absen_hide = preg_replace('/\d/', '*', $potongan_absen_show);

        $potongan_keterlambatan_show = number_format($potongan_keterlambatan, 2, ',', '.');
        $potongan_keterlambatan_hide = preg_replace('/\d/', '*', $potongan_keterlambatan_show);

        $potongan_ijin_show = number_format($potongan_ijin, 2, ',', '.');
        $potongan_ijin_hide = preg_replace('/\d/', '*', $potongan_ijin_show);

        $potongan_kasbon_show = number_format($potongan_kasbon, 2, ',', '.');
        $potongan_kasbon_hide = preg_replace('/\d/', '*', $potongan_kasbon_show);

        $data = [
            'thp_show' => $thp_show,
            'thp_hide' => $thp_hide,

            'lembur_show' => $lembur_show,
            'lembur_hide' => $lembur_hide,

            'potongan_absen_show' => $potongan_absen_show,
            'potongan_absen_hide' => $potongan_absen_hide,

            'potongan_keterlambatan_show' => $potongan_keterlambatan_show,
            'potongan_keterlambatan_hide' => $potongan_keterlambatan_hide,

            'potongan_ijin_show' => $potongan_ijin_show,
            'potongan_ijin_hide' => $potongan_ijin_hide,

            'potongan_kasbon_show' => $potongan_kasbon_show,
            'potongan_kasbon_hide' => $potongan_kasbon_hide,

        ];


        return view('dashboard', $data);
    }
}
