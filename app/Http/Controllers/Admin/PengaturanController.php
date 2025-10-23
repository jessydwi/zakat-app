<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\KetentuanZakat;

class PengaturanController extends Controller
{

    public function index() {
        $setting = Setting::firstOrCreate([]);
        $data = KetentuanZakat::orderBy('jenis_zakat')->get()->groupBy('jenis_zakat');
        return view('admin.pengaturan.index', compact('setting', 'data'));
    }

    public function update(Request $request) {
        $setting = Setting::first();
        $data = $request->except('logo');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $setting->update($data);
        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
