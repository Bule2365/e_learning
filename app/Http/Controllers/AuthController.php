<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required',
        ]);

        if (Auth::attempt(['id' => $request->id, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Ambil role user yang sedang login
            $role = Auth::user()->role;

            // Arahkan ke dashboard yang sesuai berdasarkan role
            if ($role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role == 'guru') {
                return redirect()->route('guru.dashboard');
            } elseif ($role == 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
        }

        return back()->withErrors([
            'loginError' => 'ID atau Password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
