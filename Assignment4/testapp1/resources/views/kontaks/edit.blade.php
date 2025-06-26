@extends('layouts.app')
{{-- memanggil isi konten layouts --}}

@section('title', 'Edit Kontak')
{{-- memangil yield title --}}

@section('content')
{{-- menaggil yield content --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Edit Kontak</h2>
            <form action="{{ route('kontaks.update', $kontak->id) }}" method="POST">
                {{-- memanggil aksi route yang sudah dibuat di controller ‘Update’ --}}
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $kontak->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $kontak->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $kontak->tanggal_lahir }}" required>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $kontak->no_hp }}" required>
                </div>
                <div class="mb-3">
                    <label for="no_hp_darurat" class="form-label">No HP Darurat</label>
                    <input type="text" class="form-control" id="no_hp_darurat" name="no_hp_darurat" value={{$kontak->no_hp_darurat}}required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
