<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zakat;
use App\Models\Penerima;

class MuzakkiController extends Controller
{
    public function dashboard()
    {
        $totalZakat = Zakat::sum('nominal');
        $totalPenerima = Penerima::count();

        return view('muzakki.dashboard', compact('totalZakat', 'totalPenerima'));
    }
}

