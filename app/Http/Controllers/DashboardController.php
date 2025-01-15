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
        $lembur                 = 0;
        $thp                    = 0;
        $gaji_kehadiran         = 0;
        $potongan_keterlambatan = 0;
        $potongan_kasbon        = 0;
        $potongan_ijin          = 0;

        $periode_cutoff = PeriodeCutoff::active()->first();

        if ($periode_cutoff) {
            $total_hari_kerja = $periode_cutoff->hari_kerja;
            // start hitung total lembur karyawan
            $data_lemburs = DataLembur::approved()->where('periode_cutoff_id', $periode_cutoff->id);
            if (Auth::user()->hasRole('karyawan')) {
                $data_lemburs->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $data_lemburs = $data_lemburs->sum('menit_lembur');
            $lembur       = round($data_lemburs * (config('app.lembur_rate') / 60), 2);
            // end hitung total lembur karyawan

            // start hitung kehadiran karyawan
            $data_kehadirans = DataKehadiran::with('karyawan')->where('periode_cutoff_id', $periode_cutoff->id);
            if (Auth::user()->hasRole('karyawan')) {
                $data_kehadirans->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $sum_keterlambatan = $data_kehadirans->sum('menit_terlambat');
            $potongan_keterlambatan = round($sum_keterlambatan * (config('app.potongan_terlambat') / 60), 2);
            $data_kehadirans = $data_kehadirans->get();
            foreach ($data_kehadirans as $data_kehadiran) {
                $tipe_gaji = $data_kehadiran->karyawan->tipe_gaji;

                if ($tipe_gaji == 'bulanan') {
                    $gaji_harian     = $data_kehadiran->karyawan->gaji_pokok / $total_hari_kerja;
                    $gaji_kehadiran += $gaji_harian;
                } else {
                    $gaji_kehadiran += $data_kehadiran->karyawan->gaji_harian;
                }
            }
            // end hitung kehadiran karyawan

            // start hitung kasbon
            $data_kasbons = DataKasbon::whereBetween('tanggal', [
                $periode_cutoff->kehadiran_start->format('Y-m-d'),
                $periode_cutoff->kehadiran_end->format('Y-m-d')
            ]);
            if (Auth::user()->hasRole('karyawan')) {
                $data_kasbons->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $potongan_kasbon = $data_kasbons->sum('jumlah');
            // end hitung kasbon

            // start hitung ijin
            $data_ijins = DataIjin::with('karyawan')->where('is_approved', true)
                ->where('from_date', '>=', $periode_cutoff->kehadiran_start->format('Y-m-d'))
                ->where('to_date', '<=', $periode_cutoff->kehadiran_end->format('Y-m-d'))
                ->where('is_approved', true)
                ->where('tipe_ijin', 'ijin potong gaji');
            if (Auth::user()->hasRole('karyawan')) {
                $data_ijins->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $data_ijins = $data_ijins->get();
            foreach ($data_ijins as $data_ijin) {
                $tipe_gaji = $data_ijin->karyawan->tipe_gaji;
                if ($tipe_gaji == 'bulanan') {
                    $gaji_harian    = $data_kehadiran->karyawan->gaji_pokok / $total_hari_kerja;
                    $potongan_ijin += $gaji_harian;
                }
            }
            // end hitung ijin

            $thp = $lembur + $gaji_kehadiran - $potongan_keterlambatan - $potongan_kasbon - $potongan_ijin;
        }

        $lembur_show = number_format($lembur, 2, ',', '.');
        $lembur_hide = preg_replace('/\d/', '*', $lembur_show);

        $gaji_kehadiran_show = number_format($gaji_kehadiran, 2, ',', '.');
        $gaji_kehadiran_hide = preg_replace('/\d/', '*', $gaji_kehadiran_show);

        $potongan_keterlambatan_show = number_format($potongan_keterlambatan, 2, ',', '.');
        $potongan_keterlambatan_hide = preg_replace('/\d/', '*', $potongan_keterlambatan_show);

        $potongan_kasbon_show = number_format($potongan_kasbon, 2, ',', '.');
        $potongan_kasbon_hide = preg_replace('/\d/', '*', $potongan_kasbon_show);

        $potongan_ijin_show = number_format($potongan_ijin, 2, ',', '.');
        $potongan_ijin_hide = preg_replace('/\d/', '*', $potongan_ijin_show);

        $thp_show = number_format($thp, 2, ',', '.');
        $thp_hide = preg_replace('/\d/', '*', $thp_show);

        $data = [
            'lembur_show' => $lembur_show,
            'lembur_hide' => $lembur_hide,

            'gaji_kehadiran_show' => $gaji_kehadiran_show,
            'gaji_kehadiran_hide' => $gaji_kehadiran_hide,

            'potongan_keterlambatan_show' => $potongan_keterlambatan_show,
            'potongan_keterlambatan_hide' => $potongan_keterlambatan_hide,

            'potongan_kasbon_show' => $potongan_kasbon_show,
            'potongan_kasbon_hide' => $potongan_kasbon_hide,

            'potongan_ijin_show' => $potongan_ijin_show,
            'potongan_ijin_hide' => $potongan_ijin_hide,

            'thp_show' => $thp_show,
            'thp_hide' => $thp_hide,
        ];

        return view('dashboard', $data);
    }
}
