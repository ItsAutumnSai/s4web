<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all(); // Mengambil semua data dari tabel mahasiswas
        return response()->json($mahasiswas); // Mengembalikan dalam format JSON
    }

    public function store(Request $request)
    {
        // Validasi input yang dikirim dari client (API)
        $request->validate([
            'nim' => 'required|unique:mahasiswas',
            'nama' => 'required',
            'prodi' => 'required'
        ]);

        // Menyimpan data ke database
        $mahasiswa = Mahasiswa::create($request->all());

        // Mengembalikan data yang baru dibuat dengan status HTTP 201 (Created)
        return response()->json($mahasiswa, 201);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id); // Mencari mahasiswa berdasarkan ID

        // Jika tidak ditemukan, kirimkan pesan error 404
        if (is_null($mahasiswa)) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Jika ditemukan, kembalikan data mahasiswa dalam format JSON
        return response()->json($mahasiswa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,'.$id,
            'nama' => 'required',
            'prodi' => 'required'
        ]);

        $mahasiswa = Mahasiswa::find($id); // Mencari mahasiswa berdasarkan ID

        // Jika data tidak ditemukan, kembalikan pesan error
        if (is_null($mahasiswa)) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Jika ditemukan, update data dengan input dari client
        $mahasiswa->update($request->all());

        // Kembalikan data yang telah diperbarui
        return response()->json($mahasiswa);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id); // Cari mahasiswa berdasarkan ID

        // Jika tidak ditemukan, kirim pesan error
        if (is_null($mahasiswa)) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Jika ditemukan, hapus data dari database
        $mahasiswa->delete();

        // Kirim respon sukses
        return response()->json(['message' => 'Mahasiswa berhasil dihapus']);
    }
}
