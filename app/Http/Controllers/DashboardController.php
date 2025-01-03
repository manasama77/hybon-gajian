<?php

namespace App\Http\Controllers;

use App\Models\DataKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // $data_kalender = [];

        // $data_kehadirans = DataKehadiran::orderBy('tanggal', 'asc');
        // if (Auth::user()->role == 'karyawan') {
        //     $data_kehadirans->where('karyawan_id', Auth::user()->karyawan->id);
        // }
        // $data_kehadirans = $data_kehadirans->get();

        // foreach ($data_kehadirans as $data_kehadiran) {
        //     $title = '';
        // }


        return view('dashboard');
    }
}
