<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Semua user diarahkan ke halaman beranda yang sama
            return redirect()->route('beranda');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Sandi saat ini wajib diisi.',
            'new_password.required' => 'Sandi baru wajib diisi.',
            'new_password.min' => 'Sandi baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi sandi baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Cek apakah sandi lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Sandi lama tidak sesuai.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Sandi berhasil diperbarui!');
    }
}
