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
        return view('admin.dashboard');
    }
}

