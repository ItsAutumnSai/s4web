@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('menu.user') }}</h5>
            <div>
                <a href="{{ route('user.index') }}"
                   class="btn btn-outline-secondary">{{ __('button.back') }}</a>
                @can('edit_user')
                <a href="{{ route('user.edit', $item->id) }}"
                   class="btn btn-primary">{{ __('button.edit') }}</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Bagian Gambar Profil -->
                <div class="col-md-3 d-flex justify-content-center">
                    <img src="{{ asset('img/profile/' . $item->image) }}" class="img-fluid rounded" alt="Profile Image" height="50">
                </div>
                <!-- Bagian Informasi Pengguna -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <input type="text" id="name" class="form-control-plaintext" readonly value="{{ __('field.name') }} : {{ $item->name }}">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="email" class="form-control-plaintext" readonly value="{{ __('field.email') }} : {{ $item->email }}">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="role" class="form-control-plaintext" readonly value="{{ __('field.role') }} : {{ $item->roles[0]?->name }}">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="iot_id" class="form-control-plaintext" readonly value="{{ __('field.iot_id') }} : {{ $item->iot_id }}">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="iot_token" class="form-control-plaintext" readonly value="{{ __('field.iot_token') }} : {{ $item->iot_token }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
