<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Muzakki;
use App\Models\Amil;
use App\Models\TransaksiZakat;
use App\Models\DistribusiZakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::latest()->paginate(10);
        return view('admin.users.index', compact('userList'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,muzaki,mustahiq',
            'password' => 'required|min:6',
            'no_hp' => 'required_if:role,muzaki',
            'alamat' => 'required_if:role,muzaki',
            'pekerjaan' => 'required_if:role,muzaki',
            'jabatan' => 'required_if:role,admin',
            'wilayah_tugas' => 'required_if:role,admin',
        ]);

        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'is_active' => true,
                'password' => bcrypt($request->password),
            ]);

            if ($request->role === 'muzaki') {
                Muzakki::create([
                    'user_id'   => $user->id,
                    'nama'      => $request->nama,
                    'email'     => $request->email,
                    'no_hp'     => $request->no_hp,
                    'alamat'    => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                ]);
            }

            if ($request->role === 'admin') {
                Amil::create([
                    'user_id'       => $user->id,
                    'jabatan'       => $request->jabatan,
                    'wilayah_tugas' => $request->wilayah_tugas,
                ]);
            }

            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $muzaki = $user->muzakki;
        $amil   = $user->amil;

        return view('admin.users.edit', compact('user', 'muzaki', 'amil'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'nama' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,muzaki,mustahiq',
        'no_hp' => 'required_if:role,muzaki',
        'alamat' => 'required_if:role,muzaki',
        'pekerjaan' => 'required_if:role,muzaki',
        'jabatan' => 'required_if:role,admin',
        'wilayah_tugas' => 'required_if:role,admin',
        // validasi password baru opsional
        'new_password' => 'nullable|min:6|confirmed',
    ]);

    $data = [
        'nama' => $request->nama,
        'email' => $request->email,
        'role' => $request->role,
        'is_active' => $request->has('is_active'),
    ];

    // Jika ada password baru, update juga
    if ($request->filled('new_password')) {
        $data['password'] = bcrypt($request->new_password);
    }

    $user->update($data);

    // logika role tetap sama...
    if ($request->role === 'muzaki') {
        Muzakki::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama'      => $request->nama,
                'email'     => $request->email,
                'no_hp'     => $request->no_hp,
                'alamat'    => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
            ]
        );
        Amil::where('user_id', $user->id)->delete();
    } elseif ($request->role === 'admin') {
        Amil::updateOrCreate(
            ['user_id' => $user->id],
            [
                'jabatan'       => $request->jabatan,
                'wilayah_tugas' => $request->wilayah_tugas,
            ]
        );
        Muzakki::where('user_id', $user->id)->delete();
    } else {
        Muzakki::where('user_id', $user->id)->delete();
        Amil::where('user_id', $user->id)->delete();
    }

    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
}


    public function show($id)
    {
        $user = User::findOrFail($id);
        $muzaki = $user->muzakki;
        $amil   = $user->amil;

        $totalZakatMasuk = 0;
        $totalDistribusi = 0;

        if ($user->role === 'muzaki' && $muzaki) {
            $totalZakatMasuk = TransaksiZakat::where('muzakki_id', $muzaki->id)
                ->where('status', 'terbayar')
                ->sum('nominal');

            $totalDistribusi = DistribusiZakat::where('mustahik_id', $muzaki->id)
                ->sum('jumlah');
        }

        return view('admin.users.show', compact(
            'user',
            'muzaki',
            'amil',
            'totalZakatMasuk',
            'totalDistribusi'
        ));
    }

    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);

        // hapus relasi dulu
        $user->transaksiZakat()->delete();
        $user->distribusiZakat()->delete();
        $user->notifikasi()->delete();
        $user->muzakki()?->delete();
        $user->amil()?->delete();

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    } catch (\Exception $e) {
        Log::error('Gagal menghapus user: ' . $e->getMessage());
        return redirect()->route('admin.users.index')->withErrors(['error' => 'Gagal menghapus user: ' . $e->getMessage()]);
    }
}

    public function deactivate($id)
{
    $user = User::findOrFail($id);
    $user->status = 'nonaktif';
    $user->save();

    return back()->with('success', 'User berhasil dinonaktifkan.');
}

public function activate($id)
{
    $user = User::findOrFail($id);
    $user->status = 'aktif';
    $user->save();

    return back()->with('success', 'User berhasil diaktifkan.');
}

}
