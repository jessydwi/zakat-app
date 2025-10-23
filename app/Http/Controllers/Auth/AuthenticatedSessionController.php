<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login berdasarkan role.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'muzaki':
                return redirect()->route('muzaki.dashboard');
            case 'mustahiq':
                return redirect()->route('mustahiq.dashboard');
            default:
                return redirect()->route('login');
        }
    }

    /**
     * Logout dan invalidate session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome'); // kembali ke halaman publik
    }
}
