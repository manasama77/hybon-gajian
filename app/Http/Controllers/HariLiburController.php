<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $hari_liburs = HariLibur::orderBy('tanggal', 'asc');

        if ($request->has('search') && !is_null($request->search)) {
            $hari_liburs->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $hari_liburs = $hari_liburs->paginate(10)->withQueryString();

        $data = [
            'search'      => $request->search,
            'hari_liburs' => $hari_liburs,
        ];

        return view('pages.hari_libur.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.hari_libur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => ['required', 'date', 'unique:hari_liburs'],
            'keterangan' => ['required', 'string', 'max:255'],
        ]);

        HariLibur::create([
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('setup.hari-libur.index')->with('success', 'Hari Libur created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(HariLibur $hariLibur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HariLibur $hari_libur)
    {
        return view('pages.hari_libur.edit', compact('hari_libur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HariLibur $hari_libur)
    {
        $request->validate([
            'tanggal'    => ['required', 'date', 'unique:hari_liburs,tanggal,' . $hari_libur->id],
            'keterangan' => ['required', 'string', 'max:255'],
        ]);

        $hari_libur->update([
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('setup.hari-libur.index')->with('success', 'Hari libur updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HariLibur $hari_libur)
    {

        try {
            \DB::beginTransaction();

            $hari_libur->delete();

            \DB::commit();

            return redirect()->route('setup.hari-libur.index')->with('success', 'Hari libur deleted successfully !');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('setup.hari-libur.index')->with('error', 'Failed to delete Hari libur: ' . $e->getMessage());
        }
    }
}
