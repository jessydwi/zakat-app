<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Muzakki;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'muzakki', // opsional jika kamu masih pakai kolom 'role'
        ]);

        // Beri role via Spatie
        $user->assignRole('muzakki');

        // Buat relasi ke tabel muzakki
        $user->muzakki()->create([
            'nama' => $validated['name'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
        ]);

        // Trigger event dan login
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('muzakki.dashboard');
    }
}
