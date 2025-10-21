<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\TransaksiZakat;

class AdminController extends Controller
{
    public function index()
    {
        $totalZakat = TransaksiZakat::sum('nominal');
        $jumlahMuzakki = Muzakki::count();
        $jumlahMustahik = Mustahik::count();

        return view('admin.dashboard', compact('totalZakat', 'jumlahMuzakki', 'jumlahMustahik'));
    }
}

