<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Karyawan;
use App\Models\DataKasbon;
use DB;
use Illuminate\Http\Request;

class DataKasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data_kasbons = DataKasbon::query();

        if ($request->has('search') && !is_null($request->search)) {
            $data_kasbons->whereHas('karyawan', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $data_kasbons = $data_kasbons->paginate(10);

        $data = [
            'search'       => $request->search,
            'data_kasbons' => $data_kasbons,
        ];

        return view('data_kasbon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::orderBy('name', 'asc')->get();

        $data = [
            'karyawans' => $karyawans,
        ];

        return view('data_kasbon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
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
        $karyawans = Karyawan::orderBy('name', 'asc')->get();

        $data = [
            'data_kasbon' => $data_kasbon,
            'karyawans'   => $karyawans,
        ];

        return view('data_kasbon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataKasbon $dataKasbon)
    {
        try {
            DB::beginTransaction();
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
}
