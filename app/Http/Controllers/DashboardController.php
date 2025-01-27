<?php

namespace App\Http\Controllers;

use App\Models\DataIjin;
use App\Models\Karyawan;
use Carbon\CarbonPeriod;
use App\Models\HariLibur;
use App\Models\DataKasbon;
use App\Models\DataLembur;
use App\Models\DataKehadiran;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $menit_lembur           = 0;
        $lembur                 = 0;
        $thp                    = 0;
        $gaji_kehadiran         = 0;
        $potongan_keterlambatan = 0;
        $potongan_kasbon        = 0;
        $potongan_ijin          = 0;
        $total_gaji             = 0;
        $potongan_absen         = 0;
        $proyeksi_pengeluaran   = 0;

        $periode_cutoff = PeriodeCutoff::active()->first();

        if ($periode_cutoff) {
            $periode_cutoff_id = $periode_cutoff->id;
            $total_hari_kerja  = $periode_cutoff->hari_kerja;
            $kehadiran_start   = $periode_cutoff->kehadiran_start;
            $kehadiran_end     = $periode_cutoff->kehadiran_end;
            $lembur_start      = $periode_cutoff->lembur_start;
            $lembur_end        = $periode_cutoff->lembur_end;

            // start hitung total lembur karyawan
            $data_lemburs = DataLembur::approved()
                ->whereDate('overtime_in', '>=', $lembur_start)
                ->whereDate('overtime_in', '<=', $lembur_end);
            if (Auth::user()->hasRole('karyawan')) {
                $data_lemburs->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $data_lemburs = $data_lemburs->get();
            foreach ($data_lemburs as $data_lembur) {
                $overtime_in  = Carbon::parse($data_lembur->overtime_in);
                $overtime_out = Carbon::parse($data_lembur->overtime_out);

                if ($overtime_in->gte($lembur_start) && $overtime_out->gte($lembur_end)) {
                    $eod           = Carbon::parse($overtime_in->toDateString() . ' 23:59:59');
                    $menit_lembur += ceil($overtime_in->diffInMinutes(date: $eod));
                } else {
                    $menit_lembur += ceil($overtime_in->diffInMinutes(date: $overtime_out));
                }
            }
            $lembur = round($menit_lembur * (config('app.lembur_rate') / 60), 2);
            // end hitung total lembur karyawan

            // start hitung kehadiran karyawan
            $data_kehadirans = DataKehadiran::with('karyawan')->where('periode_cutoff_id', $periode_cutoff_id);
            if (Auth::user()->hasRole('karyawan')) {
                $data_kehadirans->where('karyawan_id', Auth::user()->karyawan->id);
            }
            $sum_keterlambatan      = $data_kehadirans->sum('menit_terlambat');
            $potongan_keterlambatan = round($sum_keterlambatan * (config('app.potongan_terlambat') / 60), 2);
            $data_kehadirans        = $data_kehadirans->get();
            foreach ($data_kehadirans as $data_kehadiran) {
                $tipe_gaji = $data_kehadiran->karyawan->tipe_gaji;

                if ($tipe_gaji == 'bulanan') {
                    $gaji_harian     = $data_kehadiran->karyawan->gaji_pokok / $total_hari_kerja;
                    $gaji_kehadiran += $gaji_harian;
                } elseif ($tipe_gaji == 'harian') {
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
                    $gaji_harian    = $data_ijin->karyawan->gaji_pokok / $total_hari_kerja;
                    $potongan_ijin += $gaji_harian * $data_ijin->total_hari;
                }
            }
            // end hitung ijin

            // dd($gaji_kehadiran);

            $thp = $lembur + $gaji_kehadiran - $potongan_keterlambatan - $potongan_kasbon - $potongan_ijin;

            // hitung total gaji start
            if (Auth::user()->hasRole('karyawan')) {
                $karyawan = Karyawan::where('is_active', true)->find(Auth::user()->karyawan->id);
                $tipe_gaji = $karyawan->tipe_gaji;
                if ($tipe_gaji == 'bulanan') {
                    $total_gaji = $karyawan->gaji_pokok;
                } else {
                    $total_gaji = $total_hari_kerja * $karyawan->gaji_harian;
                }
            } else {
                $bulanan_karyawans = Karyawan::where('is_active', true)->get();
                foreach ($bulanan_karyawans as $karyawan) {
                    $tipe_gaji = $karyawan->tipe_gaji;
                    if ($tipe_gaji == 'bulanan') {
                        $total_gaji += $karyawan->gaji_pokok;
                    } else {
                        $total_gaji += $total_hari_kerja * $karyawan->gaji_harian;
                    }
                }
            }
            // hitung total gaji end

            // hitung potongan absen start
            $hari_liburs = HariLibur::select('tanggal')
                ->whereBetween('tanggal', [$kehadiran_start->toDateString(), $kehadiran_end->toDateString()])
                ->get();
            $arr_hari_libur = [];
            foreach ($hari_liburs as $hari_libur) {
                $tanggal = $hari_libur->tanggal->toDateString();
                array_push($arr_hari_libur, $tanggal);
            }

            if (Auth::user()->hasRole('karyawan')) {
                $periods = CarbonPeriod::create($kehadiran_start, $kehadiran_end);
            } else {
                $periods = CarbonPeriod::create($kehadiran_start, Carbon::now());
            }
            // $periods = CarbonPeriod::create($kehadiran_start, Carbon::now());
            foreach ($periods as $period) {
                if ($period->isSunday()) {
                    continue;
                }

                if (in_array($period->toDateString(), $arr_hari_libur)) {
                    continue;
                }

                $karyawans = Karyawan::where('is_active', true);

                if (Auth::user()->hasRole('karyawan')) {
                    $karyawans->where('id', Auth::user()->karyawan->id);
                }

                $karyawans = $karyawans->get();

                foreach ($karyawans as $karyawan) {
                    $karyawan_id         = $karyawan->id;
                    $tipe_gaji           = $karyawan->tipe_gaji;
                    $gaji_pokok          = $karyawan->gaji_pokok;
                    $gaji_harian         = $karyawan->gaji_harian;
                    $gaji_harian_bulanan = round($gaji_pokok / $total_hari_kerja, 2);

                    $check = DataKehadiran::where('karyawan_id', $karyawan_id)
                        ->where('periode_cutoff_id', $periode_cutoff_id)
                        ->where('tanggal', $period->toDateString())
                        ->first();

                    if ($check) {
                        continue;
                    }

                    $check = DataIjin::where('karyawan_id', $karyawan_id)
                        ->where('from_date', '<=', $period->toDateString())
                        ->where('to_date', '>=', $period->toDateString())
                        ->where('is_approved', true)
                        ->first();

                    if ($check) {
                        continue;
                    }

                    if ($tipe_gaji == 'bulanan') {
                        $potongan_absen += $gaji_harian_bulanan;
                    } else {
                        $potongan_absen += $gaji_harian;
                    }
                }
            }
            // hitung potongan absen end

            // proyeksi start
            $proyeksi_pengeluaran = $total_gaji + $lembur - $potongan_absen - $potongan_keterlambatan - $potongan_ijin - $potongan_kasbon;
            // proyeksi end
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

        $total_gaji_show = number_format($total_gaji, 2, ',', '.');
        $total_gaji_hide = preg_replace('/\d/', '*', $total_gaji_show);

        $potongan_absen_show = number_format($potongan_absen, 2, ',', '.');
        $potongan_absen_hide = preg_replace('/\d/', '*', $potongan_absen_show);

        $proyeksi_pengeluaran_show = number_format($proyeksi_pengeluaran, 2, ',', '.');
        $proyeksi_pengeluaran_hide = preg_replace('/\d/', '*', $proyeksi_pengeluaran_show);

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

            'total_gaji_show' => $total_gaji_show,
            'total_gaji_hide' => $total_gaji_hide,

            'potongan_absen_show' => $potongan_absen_show,
            'potongan_absen_hide' => $potongan_absen_hide,

            'proyeksi_pengeluaran_show' => $proyeksi_pengeluaran_show,
            'proyeksi_pengeluaran_hide' => $proyeksi_pengeluaran_hide,
        ];

        return view('dashboard', $data);
    }
}
