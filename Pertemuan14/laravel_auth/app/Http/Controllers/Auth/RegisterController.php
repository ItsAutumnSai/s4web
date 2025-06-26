<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;       
use App\Models\User;                       
use Illuminate\Auth\Events\Registered;     // Digunakan untuk memicu event setelah registrasi berhasil
use Illuminate\Http\Request;               // Untuk menangani data yang dikirim dari form (seperti nama, email, password)
use Illuminate\Support\Facades\Auth;       // Untuk proses login secara otomatis
use Illuminate\Support\Facades\Hash;       // Untuk mengenkripsi (mengacak) password
use Illuminate\Validation\Rules;           // Untuk aturan validasi password

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register'); // Menampilkan file view auth/register.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],                          
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
        ]);

        // Membuat user baru di database dengan data yang sudah divalidasi
        $user = User::create([
            'name' => $request->name,                                   // Ambil nama dari form
            'email' => $request->email,                                 // Ambil email dari form
            'password' => Hash::make($request->password),               // Hash password agar tidak tersimpan dalam bentuk asli (demi keamanan)
        ]);

        // Memicu event bahwa user baru telah berhasil mendaftar
        event(new Registered($user));

        // Langsung login user tersebut setelah mendaftar
        Auth::login($user);

        // REdirect Ke Dashboard
        return redirect()->route('dashboard');
    }
}
