<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Karyawan;
use App\Models\DataLembur;
use Illuminate\Http\Request;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DataLemburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data_lemburs = DataLembur::query();

        if (Auth::user()->hasRole('karyawan')) {
            $data_lemburs->where('karyawan_id', Auth::user()->karyawan->id);
        }

        $data_lemburs = $data_lemburs->orderBy('overtime_in', 'desc')->paginate(10);

        $data = [
            'data_lemburs' => $data_lemburs,
        ];

        return view('data_lembur.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periode_cutoffs = PeriodeCutoff::active()->latest()->get();
        $karyawans       = Karyawan::query();

        if (Auth::user()->hasRole('karyawan')) {
            $karyawans->where('id', Auth::user()->karyawan->id);
        }

        $karyawans = $karyawans->get();

        $min_date = $periode_cutoffs->first()->lembur_start->format('Y-m-d');
        $max_date = $periode_cutoffs->first()->lembur_end->format('Y-m-d');

        $data = [
            'periode_cutoffs' => $periode_cutoffs,
            'karyawans'       => $karyawans,
            'min_date'        => $min_date,
            'max_date'        => $max_date,
        ];

        return view('data_lembur.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'karyawan_id'       => ['required', 'exists:karyawans,id'],
                'periode_cutoff_id' => ['required', 'exists:periode_cutoffs,id'],
                'overtime_in_date'  => ['required', 'date'],
                'overtime_in_time'  => ['required', 'date_format:H:i'],
                'overtime_out_date' => ['required', 'date', 'after_or_equal:overtime_in_date'],
                'overtime_out_time' => ['required', 'date_format:H:i'],
            ]);

            $overtime_in_x  = $request->overtime_in_date . ' ' . $request->overtime_in_time;
            $overtime_out_x = $request->overtime_out_date . ' ' . $request->overtime_out_time;
            $overtime_in    = Carbon::parse($overtime_in_x);
            $overtime_out   = Carbon::parse($overtime_out_x);

            $check = DataLembur::where('karyawan_id', operator: $request->karyawan_id)
                ->whereDate('overtime_in', $overtime_in->toDateString())
                ->first();

            if ($check) {
                throw new Exception('Data kamu sudah mengisi data lembur hari ini.');
            }

            $jam_lembur   = ceil(num: $overtime_in->diffInMinutes(date: $overtime_out) / 60);
            $menit_lembur = ceil($overtime_in->diffInMinutes(date: $overtime_out));

            DataLembur::createOrFirst([
                'karyawan_id'       => $request->karyawan_id,
                'periode_cutoff_id' => $request->periode_cutoff_id,
                'overtime_in'       => $overtime_in->toDateTimeString(),
                'overtime_out'      => $overtime_out->toDateTimeString(),
                'jam_lembur'        => $jam_lembur,
                'menit_lembur'      => $menit_lembur,
                'is_approved'       => null,
                'approved_by'       => null,
                'approved_at'       => null,
            ]);

            DB::commit();
            return redirect()->route('data-lembur.index')->with('success', 'Data lembur berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage() . ' ' . $e->getLine())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $path = $request->path;
        return '<img src="' . asset('storage/' . $path) . '" />';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataLembur $dataLembur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataLembur $dataLembur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataLembur $dataLembur)
    {
        //
    }

    public function approve_reject(Request $request)
    {
        try {
            $request->validate([
                'id'   => ['required', 'exists:data_lemburs,id'],
                'tipe' => ['required', 'in:approve,reject'],
            ]);

            $data_lembur = DataLembur::findOrFail($request->id);
            $is_approved = false;
            $message     = 'Data lembur ditolak.';

            if ($request->tipe == "approve") {
                $is_approved = true;
                $message     = 'Data lembur berhasil diapprove.';
            }

            $data_lembur->update([
                'is_approved' => $is_approved,
                'approved_by' => Auth::id(),
                'approved_at' => Carbon::now(),
            ]);

            return response()->json(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
