@extends('layouts.app')
{{-- memanggil isi konten layouts --}}

@section('title', 'Detail Kontak')
{{-- memangil yield title --}}

@section('content') 
{{-- menaggil yield content --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Kontak</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $kontak->nama }}</h5>
                    {{-- memanggil aray dari variabel controller “Kontak” --}}
                    <p class="card-text"><strong>Alamat:</strong> {{ $kontak->alamat }}</p>
                    <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $kontak->tanggal_lahir }}</p>
                    <p class="card-text"><strong>No HP:</strong> {{ $kontak->no_hp }}</p>
                    <p class="card-text"><strong>No HP Darurat:</strong> {{ $kontak->no_hp_darurat }}</p>
                    <a href="{{ route('kontaks.edit', $kontak->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('kontaks.destroy', $kontak->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                    </form>
                    <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
