<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Muzakki;
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
        ]);

        try {
            // Simpan user
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
                'is_active' => true,
                'password' => bcrypt($request->password),
            ]);

            // Simpan muzakki jika role = muzaki
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

            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user/muzakki: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        // Ambil relasi muzakki langsung dari model
        $muzaki = $user->muzakki;

        return view('admin.users.edit', compact('user', 'muzaki'));
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
        ]);

        // Update data user
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        // Update atau buat data muzakki jika role adalah muzaki
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
        } else {
            // Jika role bukan muzaki, hapus data muzakki
            Muzakki::where('user_id', $user->id)->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

       public function show($id)
{
    $user = User::findOrFail($id);
    $muzaki = $user->muzakki;

    $totalZakatMasuk = 0;
    $totalDistribusi = 0;

    if ($user->role === 'muzaki' && $muzaki) {
        // Pastikan relasi transaksi berjalan
        $totalZakatMasuk = TransaksiZakat::where('muzakki_id', $muzaki->id)
            ->where('status', 'terbayar')
            ->sum('nominal');

        // Distribusi: hanya jika mustahik_id menunjuk ke muzakki
        $totalDistribusi = DistribusiZakat::where('mustahik_id', $muzaki->id)->sum('jumlah');
    }

    return view('admin.users.show', compact(
        'user',
        'muzaki',
        'totalZakatMasuk',
        'totalDistribusi'
    ));
}

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->muzakki?->delete(); // jika ada relasi
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus user: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->withErrors(['error' => 'Gagal menghapus user.']);
        }
    }


}
