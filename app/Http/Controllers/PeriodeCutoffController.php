<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\DataIjin;
use App\Models\Karyawan;
use App\Models\SlipGaji;
use App\Models\DataKasbon;
use App\Models\DataLembur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DataKehadiran;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Carbon;
use App\Exports\SlipGajiExport;
use App\Models\HariLibur;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\CarbonPeriod;

class PeriodeCutoffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periode_cutoffs = PeriodeCutoff::query();

        if ($request->has('search') && !is_null($request->search)) {
            $periode_cutoffs->where('nama', 'like', "%$request->search%");
        }

        $periode_cutoffs = $periode_cutoffs
            ->orderBy('kehadiran_start', 'desc')
            ->paginate(10)->withQueryString();

        $data = [
            'periode_cutoffs' => $periode_cutoffs,
            'search'          => $request->search
        ];
        return view('pages.periode_cutoff.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'kehadiran_start' => now()->startOfMonth()->format('Y-m-d'),
            'kehadiran_end'   => now()->endOfMonth()->format('Y-m-d'),
            'lembur_start'    => now()->subMonth()->day(21)->format('Y-m-d'),
            'lembur_end'      => now()->day(20)->format('Y-m-d'),
            'hari_kerja'      => 26,
        ];

        return view('pages.periode_cutoff.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kehadiran_start' => ['required', 'date'],
            'kehadiran_end'   => ['required', 'date', 'after:kehadiran_start'],
            'lembur_start'    => ['required', 'date'],
            'lembur_end'      => ['required', 'date', 'after:lembur_start'],
            'is_active'       => ['boolean'],
        ]);

        $hari_kerja = 0;

        $kehadiran_start = Carbon::parse($request->kehadiran_start . ' 00:00:00');
        $kehadiran_end   = Carbon::parse($request->kehadiran_end . ' 23:59:59');
        $periode         = CarbonPeriod::create($kehadiran_start, '1 day', $kehadiran_end);

        foreach ($periode as $date) {
            $check_hari_libur = HariLibur::where('tanggal', $date->toDateString())->first();

            if ($date->isSunday()) {
                continue;
            }

            if ($check_hari_libur) {
                continue;
            }

            $hari_kerja++;
        }

        if ($request->is_active) {
            PeriodeCutoff::query()->update([
                'is_active' => false,
            ]);
        }

        $request->merge([
            'hari_kerja' => $hari_kerja,
        ]);
        PeriodeCutoff::create($request->all());
        return redirect()->route('setup.periode-cutoff.index')->with('success', 'Periode Cutoff berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodeCutoff $periodeCutoff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeriodeCutoff $periodeCutoff)
    {
        $data = [
            'periode_cutoff' => $periodeCutoff,
        ];

        return view('pages.periode_cutoff.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeriodeCutoff $periodeCutoff)
    {
        $request->validate([
            'kehadiran_start' => ['required', 'date'],
            'kehadiran_end'   => ['required', 'date', 'after:kehadiran_start'],
            'lembur_start'    => ['required', 'date'],
            'lembur_end'      => ['required', 'date', 'after:lembur_start'],
            'is_active'       => ['boolean'],
        ]);

        $hari_kerja = 0;

        $kehadiran_start = Carbon::parse($request->kehadiran_start . ' 00:00:00');
        $kehadiran_end   = Carbon::parse($request->kehadiran_end . ' 23:59:59');
        $periode         = CarbonPeriod::create($kehadiran_start, '1 day', $kehadiran_end);

        foreach ($periode as $date) {
            $check_hari_libur = HariLibur::where('tanggal', $date->toDateString())->first();

            if ($date->isSunday()) {
                continue;
            }

            if ($check_hari_libur) {
                continue;
            }

            $hari_kerja++;
        }

        if ($request->is_active) {
            PeriodeCutoff::query()->update([
                'is_active' => false,
            ]);
        }

        $request->merge([
            'hari_kerja' => $hari_kerja,
        ]);
        $periodeCutoff->update($request->all());
        return redirect()->route('setup.periode-cutoff.index')->with('success', 'Periode Cutoff berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeriodeCutoff $periodeCutoff)
    {
        $periodeCutoff->delete();
        return redirect()->route('setup.periode-cutoff.index')->with('success', 'Periode Cutoff berhasil dihapus');
    }

    public function generate_slip_gaji(Request $request)
    {
        try {
            DB::beginTransaction();

            $periode_cutoff_id = (int) $request->id;
            $periode_cutoffs   = PeriodeCutoff::where('is_active', true)->find($periode_cutoff_id);

            if (!$periode_cutoffs) {
                throw new Exception('Periode cutoff tidak ditemukan atau tidak aktif!');
            }

            $kehadiran_start = $periode_cutoffs->kehadiran_start;
            $kehadiran_end   = $periode_cutoffs->kehadiran_end;
            $lembur_start    = Carbon::parse($periode_cutoffs->lembur_start->toDateString() . ' 00:00:00');
            $lembur_end      = Carbon::parse($periode_cutoffs->lembur_end->toDateString() . ' 23:59:59');
            $hari_kerja      = $periode_cutoffs->hari_kerja;

            $karyawans = Karyawan::with('departement')
                ->where('is_active', true)
                ->get();

            foreach ($karyawans as $karyawan) {
                $karyawan_id = $karyawan->id;
                $name        = $karyawan->name;
                $departement = $karyawan->departement->name;
                $tipe_gaji   = $karyawan->tipe_gaji;
                $gaji_pokok  = (float) $karyawan->gaji_pokok;
                $gaji_harian = $karyawan->gaji_harian;

                if ($tipe_gaji === 'bulanan') {
                    $gaji_harian = round($gaji_pokok / $hari_kerja, 2);
                }

                $total_cuti      = 0;
                $total_sakit     = 0;
                $total_hari_ijin = 0;
                $potongan_ijin   = 0;
                $potongan_kasbon = 0;
                $gaji_kehadiran  = 0;
                $arr_kehadiran   = [];
                $arr_lembur      = [];

                $periode_kehadiran = new CarbonPeriod($kehadiran_start, '1 day', $kehadiran_end);
                foreach ($periode_kehadiran as $date) {
                    $tanggal_x    = $date->format('Y-m-d');
                    $hari_libur_x = HariLibur::where('tanggal', $tanggal_x)->first();
                    $data_kehadiran_x = DataKehadiran::where('karyawan_id', $karyawan_id)
                        ->where('periode_cutoff_id', $periode_cutoff_id)
                        ->where('tanggal', $tanggal_x)
                        ->whereNotNull('clock_in')
                        ->first();
                    $data_ijin_x = DataIjin::where('karyawan_id', $karyawan_id)
                        ->where('from_date', '<=', $tanggal_x)
                        ->where('to_date', '>=', $tanggal_x)
                        ->first();


                    if ($date->isSunday()) {
                        array_push($arr_kehadiran, [
                            'tanggal'         => $tanggal_x,
                            'status'          => 'libur',
                            'menit_terlambat' => null,
                        ]);
                    } elseif ($hari_libur_x) {
                        array_push($arr_kehadiran, [
                            'tanggal'         => $tanggal_x,
                            'status'          => $hari_libur_x->keterangan,
                            'menit_terlambat' => null,
                        ]);
                    } elseif ($data_ijin_x) {
                        array_push($arr_kehadiran, [
                            'tanggal'         => $tanggal_x,
                            'status'          => $data_ijin_x->tipe_ijin,
                            'menit_terlambat' => null,
                        ]);
                    } elseif ($data_kehadiran_x) {
                        $menit_terlambat_x = ($data_kehadiran_x->menit_terlambat > 0) ? $data_kehadiran_x->menit_terlambat : null;
                        array_push($arr_kehadiran, [
                            'tanggal'         => $tanggal_x,
                            'status'          => 'hadir',
                            'menit_terlambat' => $menit_terlambat_x
                        ]);
                    } else {
                        array_push($arr_kehadiran, [
                            'tanggal'         => $tanggal_x,
                            'status'          => 'absen',
                            'menit_terlambat' => null,
                        ]);
                    }
                }

                $periode_lembur = new CarbonPeriod($lembur_start, '1 day', $lembur_end);
                foreach ($periode_lembur as $date) {
                    $tanggal_x    = $date->format('Y-m-d');
                    $data_lembur_x = DataLembur::where('karyawan_id', $karyawan_id)
                        ->whereDate('overtime_in', $tanggal_x)
                        ->where('is_approved', true)
                        ->first();


                    if ($data_lembur_x) {
                        array_push($arr_lembur, [
                            'tanggal'         => $tanggal_x,
                            'status'          => $data_lembur_x->menit_lembur . ' menit',
                            'start'           => $data_lembur_x->overtime_in,
                            'end'             => $data_lembur_x->overtime_out,
                        ]);
                    }
                }

                $data_kehadiran = DataKehadiran::where('karyawan_id', $karyawan_id)
                    ->where('periode_cutoff_id', $periode_cutoff_id)
                    ->whereBetween('tanggal', [$kehadiran_start, $kehadiran_end])
                    ->whereNotNull('clock_in')
                    ->whereNotIn('tanggal', function ($query) {
                        $query->select('tanggal')
                            ->from('hari_liburs')
                            ->whereNull('deleted_at');
                    });

                $data_cuti = DataIjin::where('karyawan_id', $karyawan_id)
                    ->where('from_date', '>=', $kehadiran_start)
                    ->where('to_date', '<=', $kehadiran_end)
                    ->where('is_approved', true)
                    ->where('tipe_ijin', 'cuti');

                $data_sakit = DataIjin::where('karyawan_id', $karyawan_id)
                    ->where('from_date', '>=', $kehadiran_start)
                    ->where('to_date', '<=', $kehadiran_end)
                    ->where('is_approved', true)
                    ->where('tipe_ijin', 'sakit dengan surat dokter');

                $total_hari_kerja             = (int) $data_kehadiran->count();
                $total_cuti                   = (int) $data_cuti->sum('total_hari');
                $total_sakit                  = (int) $data_sakit->sum('total_hari');
                $jam_terlambat                = (int) $data_kehadiran->sum('jam_terlambat');
                $menit_terlambat              = (int) $data_kehadiran->sum('menit_terlambat');
                $potongan_terlambat_per_menit = (float) config('app.potongan_terlambat') / 60;
                $potongan_terlambat           = round($potongan_terlambat_per_menit * $menit_terlambat, 2);

                $data_lemburs = DataLembur::where('karyawan_id', $karyawan_id)
                    ->whereDate('overtime_in', '>=', $lembur_start)
                    ->whereDate('overtime_in', '<=', $lembur_end)
                    ->where('is_approved', true)
                    ->get();
                // dd($data_lemburs);

                $total_jam_lembur   = 0;
                $total_menit_lembur = 0;
                foreach ($data_lemburs as $data_lembur) {
                    $overtime_in  = Carbon::parse($data_lembur->overtime_in);
                    $overtime_out = Carbon::parse($data_lembur->overtime_out);
                    if ($overtime_in->gte($lembur_start) && $overtime_out->gte($lembur_end)) {
                        $eod = Carbon::parse($overtime_in->toDateString() . ' 23:59:59');
                        $total_jam_lembur   += ceil($overtime_in->diffInMinutes(date: $eod) / 60);
                        $total_menit_lembur += ceil($overtime_in->diffInMinutes(date: $eod));
                    } else {
                        $total_jam_lembur   += ceil($overtime_in->diffInMinutes(date: $overtime_out) / 60);
                        $total_menit_lembur += ceil($overtime_in->diffInMinutes(date: $overtime_out));
                    }
                }
                $gaji_lembur = round($total_menit_lembur * (config('app.lembur_rate') / 60), 2);

                $data_ijin = DataIjin::where('karyawan_id', $karyawan_id)
                    ->where('from_date', '>=', $kehadiran_start)
                    ->where('to_date', '<=', $kehadiran_end)
                    ->where('is_approved', true)
                    ->where('tipe_ijin', 'ijin potong gaji');

                $total_hari_ijin = (int) $data_ijin->sum('total_hari');
                $potongan_ijin   = round($gaji_harian * $total_hari_ijin, 2);

                $total_hari_tidak_kerja = $hari_kerja - $total_hari_kerja - $total_hari_ijin - $total_cuti - $total_sakit;
                // dd(
                //     "hari kerja: " . $hari_kerja,
                //     "total hari kerja: " . $total_hari_kerja,
                //     "total_hari_ijin: " . $total_hari_ijin,
                //     "total cuti: " . $total_cuti,
                //     "total sakit: " . $total_sakit,
                //     "total hari tidak kerja: " . $total_hari_tidak_kerja
                // );
                $potongan_tidak_kerja   = round($gaji_harian * $total_hari_tidak_kerja, 2);

                $prorate = true;

                if ($tipe_gaji === 'bulanan') {
                    $prorate = ($hari_kerja != $total_hari_kerja) ? true : false;
                }

                $data_kasbon = DataKasbon::where('karyawan_id', $karyawan_id)
                    ->whereBetween('tanggal', [$kehadiran_start->toDateString(), $kehadiran_end->toDateString()])
                    ->sum('jumlah');

                $potongan_kasbon = (float) $data_kasbon;

                $take_home_pay = round($gaji_pokok + $gaji_lembur - $potongan_tidak_kerja - $potongan_terlambat - $potongan_ijin - $potongan_kasbon, 2);
                if ($tipe_gaji === 'harian') {
                    $gaji_kehadiran = round($gaji_harian * $total_hari_kerja, 2);
                    $take_home_pay  = round($gaji_kehadiran + $gaji_lembur - $potongan_terlambat - $potongan_kasbon, 2);
                }

                $take_home_pay_rounded = $take_home_pay;
                $hundreds              = round($take_home_pay, -2);
                $thousands             = round($take_home_pay, -3);

                if (abs($take_home_pay - $hundreds) < abs($take_home_pay - $thousands)) {
                    $take_home_pay_rounded = $hundreds;
                } else {
                    $take_home_pay_rounded = $thousands;
                }

                $nama_file = Str::slug($kehadiran_start->toDateString() . '-' . $kehadiran_end->toDateString() . '-' . $name . '-' . Carbon::now()->format('Y-m-d')) . ".pdf";

                $data_slip_gaji = [
                    [
                        'karyawan_id'       => $karyawan_id,
                        'periode_cutoff_id' => $periode_cutoff_id,
                    ],
                    [
                        'tipe_gaji'              => $tipe_gaji,
                        'gaji_pokok'             => $gaji_pokok,
                        'gaji_harian'            => $gaji_harian,
                        'total_hari_kerja'       => $total_hari_kerja,
                        'gaji_kehadiran'         => $gaji_kehadiran,
                        'total_cuti'             => $total_cuti,
                        'total_sakit'            => $total_sakit,
                        'total_hari_tidak_kerja' => $total_hari_tidak_kerja,
                        'potongan_tidak_kerja'   => $potongan_tidak_kerja,
                        'total_hari_ijin'        => $total_hari_ijin,
                        'potongan_ijin'          => $potongan_ijin,
                        'jam_terlambat'          => $jam_terlambat,
                        'menit_terlambat'        => $menit_terlambat,
                        'potongan_terlambat'     => $potongan_terlambat,
                        'prorate'                => $prorate,
                        'total_jam_lembur'       => $total_jam_lembur,
                        'total_menit_lembur'     => $total_menit_lembur,
                        'gaji_lembur'            => $gaji_lembur,
                        'potongan_kasbon'        => $potongan_kasbon,
                        'take_home_pay'          => $take_home_pay,
                        'take_home_pay_rounded'  => $take_home_pay_rounded,
                        'file_pdf'               => $nama_file,
                    ]
                ];

                $slip_gaji    = SlipGaji::updateOrCreate($data_slip_gaji[0], $data_slip_gaji[1]);
                $slip_gaji_id = $slip_gaji->id;

                $slip = SlipGaji::with([
                    'karyawan',
                    'karyawan.departement',
                    'periode_cutoff',
                ])->find($slip_gaji_id);

                $title = "Slip Gaji $name - $departement - " . $kehadiran_start->translatedFormat('d M y') . " s/d " . $kehadiran_end->translatedFormat('d M y');
                $pdf  = Pdf::loadView('pdf.slip-gaji', [
                    'title'         => $title,
                    'data'          => $slip,
                    'arr_kehadiran' => $arr_kehadiran,
                    'arr_lembur'    => $arr_lembur
                ])->setPaper('a4', 'portrait');
                // return $pdf->stream();
                $pdf->save(public_path('storage/slip_gaji/' . $nama_file));
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Slip gaji berhasil digenerate'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Slip gaji gagal digenerate',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
        }
    }

    public function excel($periode_cutoff_id)
    {
        $periode_cutoff = PeriodeCutoff::find($periode_cutoff_id);
        if (!$periode_cutoff) {
            return redirect()->route('setup.periode-cutoff.index')->with('error', 'Periode Cutoff tidak ditemukan');
        }

        $kehadiran_start = $periode_cutoff->kehadiran_start->format('d M Y');
        $kehadiran_end   = $periode_cutoff->kehadiran_end->format('d M Y');
        $file_name       = $kehadiran_start . ' - ' . $kehadiran_end . " Rekap Gaji Hybon";
        return Excel::download(new SlipGajiExport($periode_cutoff_id), $file_name . '.xlsx');
    }
}
