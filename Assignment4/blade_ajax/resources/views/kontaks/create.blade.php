@extends('layouts.app')
{{-- memanggil isi konten layouts --}}

@section('title', 'Tambah Kontak Baru')
{{-- memangil yield title --}}

@section('content')
{{-- menaggil yield content --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah Kontak Baru</h2>
            <form action="{{ route('kontaks.store') }}" method="POST">
                {{-- memanggil aksi route yang sudah dibuat di controller ‘Store’ --}}
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Batal</a>
                {{-- href bisalangsung pagil route yang dibuat saja --}}
            </form>
        </div>
    </div>
</div>
@endsection
