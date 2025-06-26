@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Register</div> <!-- Judul form -->

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf <!-- Token keamanan agar form hanya bisa dikirim dari aplikasi ini -->

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong> <!-- Pesan error dari validasi -->
                            </span>
                        @enderror
                    </div>

                    <!-- Input email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <!-- Input email -->
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Input password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <!-- Input password -->
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                        <!-- Tampilkan pesan error jika ada masalah pada field 'password' -->
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Konfirmasi password -->
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <!-- Input untuk mengulang password -->
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
