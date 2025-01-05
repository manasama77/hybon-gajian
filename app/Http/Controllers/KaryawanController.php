<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $karyawans = Karyawan::query();

        if ($request->has('search') && !is_null($request->search)) {
            $karyawans->where('name', 'like', '%' . $request->search . '%');
        }

        $karyawans = $karyawans
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $data = [
            'search'    => $request->search,
            'karyawans' => $karyawans,
        ];


        return view('pages.karyawan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();

        return view('pages.karyawan.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'email'          => ['required', 'email', 'unique:users,email', 'max:255'],
                'password'       => ['required', 'string', 'min:8', 'confirmed'],
                'departement_id' => ['required', 'exists:departements,id'],
                'name'           => ['required', 'string', 'max:255'],
                'tipe_gaji'      => ['required', 'in:bulanan,harian'],
                'gaji_pokok'     => ['required', 'numeric'],
                'gaji_harian'    => ['required', 'numeric'],
                'join_date'      => ['required', 'date'],
                'total_cuti'     => ['nullable', 'numeric'],
                'sisa_cuti'      => ['nullable', 'numeric'],
                'whatsapp'       => ['required', 'string', 'max:255'],
            ]);

            $user = User::createOrFirst([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('karyawan');

            $gaji_pokok  = 0;
            $gaji_harian = $request->gaji_harian;

            if ($request->tipe_gaji == 'bulanan') {
                $gaji_pokok  = $request->gaji_pokok;
                $gaji_harian = 0;
            }

            Karyawan::createOrFirst([
                'user_id'        => $user->id,
                'departement_id' => $request->departement_id,
                'name'           => $request->name,
                'join_date'      => $request->join_date,
                'tipe_gaji'      => $request->tipe_gaji,
                'gaji_pokok'     => $gaji_pokok,
                'gaji_harian'    => $gaji_harian,
                'whatsapp'       => $request->whatsapp,
                'total_cuti'     => $request->total_cuti ?? 0,
                'sisa_cuti'      => $request->sisa_cuti ?? 0,
                'is_active'      => true,
            ]);

            DB::commit();
            return redirect()->route('setup.karyawan.index')->with('success', 'Karyawan created successfully !');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('setup.karyawan.index')->withError($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($path)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $departements = Departement::all();
        return view('pages.karyawan.edit', compact('karyawan', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'email'          => ['required', 'email', 'unique:users,email,' . $karyawan->user_id, 'max:255'],
            'departement_id' => ['required', 'exists:departements,id'],
            'name'           => ['required', 'string', 'max:255'],
            'tipe_gaji'      => ['required', 'in:bulanan,harian'],
            'gaji_pokok'     => ['required', 'numeric'],
            'gaji_harian'    => ['required', 'numeric'],
            'join_date'      => ['required', 'date'],
            'total_cuti'     => ['nullable', 'numeric'],
            'sisa_cuti'      => ['nullable', 'numeric'],
            'whatsapp'       => ['required', 'string', 'max:255'],
            'is_active'      => ['required', 'boolean'],
        ]);

        $karyawan->update([
            'departement_id' => $request->departement_id,
            'name'           => $request->name,
            'tipe_gaji'      => $request->tipe_gaji,
            'gaji_pokok'     => $request->gaji_pokok,
            'gaji_harian'    => $request->gaji_harian,
            'join_date'      => $request->join_date,
            'total_cuti'     => $request->total_cuti ?? 0,
            'sisa_cuti'      => $request->sisa_cuti ?? 0,
            'whatsapp'       => $request->whatsapp,
            'is_active'      => $request->is_active,
        ]);

        $karyawan->user->update([
            'email' => $request->email,
            'name'  => $request->name,
        ]);

        return redirect()->route('setup.karyawan.index')->with('success', 'Karyawan updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        $karyawan->user->removeRole('karyawan');
        $karyawan->user->delete();
        return redirect()->route('setup.karyawan.index')->with('success', 'Karyawan deleted successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reset_password(Karyawan $karyawan)
    {
        $departements = Departement::all();
        return view('pages.karyawan.reset_password', compact('karyawan', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function reset_password_process(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $karyawan->user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('setup.karyawan.index')->with('success', 'Reset password successfully !');
    }
}
