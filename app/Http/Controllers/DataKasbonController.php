<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Karyawan;
use App\Models\DataKasbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $karyawan_id = $request->karyawan_id ?? null;
        $bulan       = $request->bulan ?? null;
        $tahun       = $request->tahun ?? null;

        $data_kasbons = DataKasbon::query();

        if (Auth::user()->hasRole('karyawan')) {
            $data_kasbons->where('karyawan_id', Auth::user()->karyawan->id);
        }

        if ($request->has('karyawan_id') && $request->karyawan_id != null) {
            $data_kasbons->where('karyawan_id', $karyawan_id);
        }

        if ($request->has('bulan') && $request->bulan != null) {
            $data_kasbons->whereMonth('tanggal', $bulan);
        }

        if ($request->has('tahun') && $request->tahun != null) {
            $data_kasbons->whereYear('tanggal', $tahun);
        }

        $data_kasbons = $data_kasbons->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $karyawans = Karyawan::where('is_active', 1)->get();
        $bulans    = $this->list_month();
        $tahuns    = $this->list_year();

        $data = [
            'data_kasbons' => $data_kasbons,
            'karyawans'    => $karyawans,
            'karyawan_id'  => $karyawan_id,
            'bulans'       => $bulans,
            'bulan'        => $bulan,
            'tahuns'       => $tahuns,
            'tahun'        => $tahun,
        ];

        return view('pages.data_kasbon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('data-kasbon.index')->withErrors('Anda tidak memiliki akses !');
        }

        $karyawans = Karyawan::orderBy('name', 'asc')->get();

        $data = [
            'karyawans' => $karyawans,
        ];

        return view('pages.data_kasbon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (!Auth::user()->hasRole('admin')) {
                return redirect()->route('data-kasbon.index')->withErrors('Anda tidak memiliki akses !');
            }

            $request->validate([
                'karyawan_id' => ['required', 'exists:karyawans,id'],
                'tanggal'     => ['required', 'date'],
                'jumlah'      => ['required', 'numeric'],
            ]);

            DataKasbon::create([
                'karyawan_id' => $request->karyawan_id,
                'tanggal'     => $request->tanggal,
                'jumlah'      => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->route('data-kasbon.index')->with('success', 'Data kasbon created successfully !');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DataKasbon $dataKasbon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataKasbon $data_kasbon)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('data-kasbon.index')->withErrors('Anda tidak memiliki akses !');
        }

        $karyawans = Karyawan::orderBy('name', 'asc')->get();

        $data = [
            'data_kasbon' => $data_kasbon,
            'karyawans'   => $karyawans,
        ];

        return view('pages.data_kasbon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataKasbon $dataKasbon)
    {
        try {
            DB::beginTransaction();

            if (!Auth::user()->hasRole('admin')) {
                return redirect()->route('data-kasbon.index')->withErrors('Anda tidak memiliki akses !');
            }

            $request->validate([
                'karyawan_id' => ['required', 'exists:karyawans,id'],
                'tanggal'     => ['required', 'date'],
                'jumlah'      => ['required', 'numeric'],
            ]);

            $dataKasbon->update([
                'karyawan_id' => $request->karyawan_id,
                'tanggal'     => $request->tanggal,
                'jumlah'      => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->route('data-kasbon.index')->with('success', 'Data kasbon updated successfully !');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataKasbon $dataKasbon)
    {
        try {
            DB::beginTransaction();

            if (!Auth::user()->hasRole('admin')) {
                return redirect()->route('data-kasbon.index')->withErrors('Anda tidak memiliki akses !');
            }

            $a = $dataKasbon->delete();

            if (!$a) {
                throw new Exception('Failed to delete data kasbon !');
            }

            DB::commit();
            return redirect()->route('data-kasbon.index')->with('success', 'Data kasbon deleted successfully !');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    protected function list_month()
    {
        $month = [];
        for ($i = 1; $i <= 12; $i++) {
            $month[] = [
                'month_id'   => $i,
                'month_name' => [
                    '1'  => 'Januari',
                    '2'  => 'Februari',
                    '3'  => 'Maret',
                    '4'  => 'April',
                    '5'  => 'Mei',
                    '6'  => 'Juni',
                    '7'  => 'Juli',
                    '8'  => 'Agustus',
                    '9'  => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                ][$i],
            ];
        }

        return $month;
    }

    protected function list_year()
    {
        $year = [];
        for ($i = date('Y'); $i >= date('Y') - 1; $i--) {
            $year[] = [
                'year' => $i
            ];
        }

        return $year;
    }
}
