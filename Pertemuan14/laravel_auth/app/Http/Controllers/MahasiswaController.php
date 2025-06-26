<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller // nama kelas kontroller harus sama dengan nama file
{
    public function index() // nama fungsi yang tampil secara default
    {
        return view('mahasiswa.index'); // memanggil views
    }

    public function getData() // fungi untuk pengambilan data JSON
    {
        $mahasiswas = Mahasiswa::latest()->get(); //Mengambil data dari Models secara DSC
        return response()->json(['data' => $mahasiswas]); // Hasil dibuat data JSON
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {
        $request->validate([// sesuaikan nama kolom yang mau diisi
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'prodi' => 'required',
        ]);

        Mahasiswa::create($request->all()); // menghubugnkan ke Models

        return response()->json(['message' => 'Data berhasil disimpan']); // Respons sukses kirim data JSON
    }

    public function edit($id) // fungsi edit dengan pengambilan berdasarkan ID
    {
        $mahasiswa = Mahasiswa::find($id); //Mencocokkan ID masukan dengan Model
        return response()->json($mahasiswa); // Respons JSON
    }

    public function update(Request $request, $id) //fungsi untuk Update DB dengan menghubungkan ke Models
    {
        $request->validate([ // sesuaikan nama kolom yang mau diedit
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,'.$id,
            'prodi' => 'required',
        ]);

        Mahasiswa::find($id)->update($request->all()); // menghubugnkan ke Models

        return response()->json(['message' => 'Data berhasil diperbarui']);
    } // Respons JSON ketika sukses

    public function destroy($id) //fungsi hapus dengan pengambilan data dari Models
    {
        Mahasiswa::destroy($id); // Fungsi Hapus by Id dari DB
        return response()->json(['message' => 'Data berhasil dihapus']); // Respons JSON saat Berhasil
    }
}
