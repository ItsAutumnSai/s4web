@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <form action="{{ route('user.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-header d-flex justify-content-between">
                <h5>{{ __('menu.user') }}</h5>
                <div>
                    <a href="{{ route('user.index') }}"
                       class="btn btn-outline-secondary">{{ __('button.back') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('button.submit') }}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Bagian Gambar dan Tombol Unggah -->
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('img/profile/' . $item->image) }}" class="img-fluid rounded mb-2" alt="Profile Image" style="max-height: 400px;">
                        <div class="custom-file">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                </div>
                <!-- Bagian Informasi Pengguna -->
                <div class="col-md-9">
                    <div class="mb-3">
                        <x-forms.input name="name" autofocus="autofocus" :value="$item->name" />
                    </div>
                    <div class="mb-3">
                        <x-forms.input name="email" type="email" disabled :value="$item->email" />
                    </div>
                    <div class="mb-3">
                        <x-forms.input name="iot_id" :value="$item->iot_id" />
                    </div>
                    <div class="mb-3">
                        <x-forms.input name="iot_token" :value="$item->iot_token" />
                    </div>
                    <div class="mb-3">
                        <x-forms.input-select2 name="role" :options="$roles" :value="$item->roles[0]?->name ?? null" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
