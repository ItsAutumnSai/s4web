<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;            // Untuk menangani data dari form login
use Illuminate\Support\Facades\Auth;    // Fitur Laravel untuk proses login, logout, dan autentikasi

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login'); // Menampilkan file view auth/login.blade.php
    }

    public function store(Request $request)
    {
        // Validasi input pengguna: email dan password harus diisi dan sesuai format
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Jika berhasil, dan checkbox "ingat saya" dicentang, maka sesi akan tetap aktif
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard'); // Redirect ke Dashboard
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout(); // Hapus status login

        $request->session()->invalidate();        // Kosongkan semua data session
        $request->session()->regenerateToken();   // Ganti token CSRF agar lebih aman

        return redirect('/'); // REdirect ke welcome
    }
}
