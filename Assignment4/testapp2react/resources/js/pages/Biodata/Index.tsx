// Import komponen Link dan hook react
import { Link, usePage } from '@inertiajs/react';
// Import router untuk mengirim permintaan DELETE sama saja Fetch
import { router } from '@inertiajs/react';

export default function Index() {
    // Ambil data 'biodatas' yang dikirim dari controller Laravel via Inertia
    const {biodatas}: any = usePage().props;
    return (
        <div className="container mt-4">
            <h2>Daftar Biodata</h2>

            {/* Tombol untuk menuju halaman tambah data */}
            <Link href="/biodata/create" className="btn btn-primary mb-3">Tambah</Link>

            {/* Tabel untuk menampilkan daftar biodata */}
            <table className="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Negara</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Warna Iris Mata</th>
                        <th>Warna Rambut</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {/* Looping data array */}
                    {biodatas.map((data: any) => (
                        <tr key={data.id}>
                            <td>{data.nama}</td>
                            <td>{data.country}</td>
                            <td>{data.tempat_lahir}</td>
                            <td>{data.tanggal_lahir}</td>
                            <td>{data.eyecolor}</td>
                            <td>{data.haircolor}</td>
                            <td>
                                {/* Tombol edit*/}
                                <Link href={`/biodata/${data.id}/edit`} className="btn btn-sm btn-warning me-2">
                                    Edit
                                </Link>

                                {/* Tombol hapus*/}
                                <button
                                    className="btn btn-sm btn-danger"
                                    onClick={() => {
                                        if (confirm("Yakin hapus?")) {
                                            // Kirim request DELETE
                                            router.delete(`/biodata/${data.id}`);
                                        }
                                    }}
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
