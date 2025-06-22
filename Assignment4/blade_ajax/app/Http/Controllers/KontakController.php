<?php
namespace App\Http\Controllers;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller // nama kelas kontroller harus sama dengan nama file
{
    public function index() // nama fungsi yang tampil secara default
    {
        $kontaks = Kontak::latest()->paginate(5); // data yang ditampilkan maksimal sebelum ada info next.
        return view('kontaks.index', compact('kontaks')); // memanggil views untuk tampilan
    }

    public function create() // nama fungsi create
    {
        return view('kontaks.create');// memanggil views
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {
        $request->validate([// sesuaikan nama kolom yang mau diisi
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        Kontak::create($request->all());// menghubugnkan ke Models

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil ditambahkan.'); // jika sukses akan di redirect ke halaman index
    }

    public function show(Kontak $kontak)// fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('kontaks.show', compact('kontak')); //memanggil ke views 
    }

    public function edit(Kontak $kontak) // fungsi edit dengan pengambilan data dari Models
    {
        return view('kontaks.edit', compact('kontak')); //memanggil ke views 
    }

    public function update(Request $request, Kontak $kontak) //fungsi untuk Update DB dengan menghubungkan ke Models
    {
        $request->validate([// sesuaikan nama kolom yang mau diedit
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $kontak->update($request->all()); // menghubugnkan ke Models

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil diperbarui.'); // jika sukses akan di redirect ke halaman index
    }

    public function destroy(Kontak $kontak) //fungsi hapus dengan pengambilan data dari Models

    {
        $kontak->delete(); // Fungsi Hapus by Id dari DB

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil dihapus.'); // jika sukses akan di redirect ke halaman index
    }
}
