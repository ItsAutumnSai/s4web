@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h4 class="card-header">{{ __('label.profile_information') }}</h4>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <x-forms.input name="name" :value="$user->name"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-forms.input name="email" type="email" :value="$user->email" readonly/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-forms.input name="iot_id" :value="$user->iot_id" readonly/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <x-forms.input name="iot_token" :value="$user->iot_token" readonly/>
                            </div>
                        </div>
                <div class="form-group row">
                <h5 class="card-header">{{ __('label.display_picture') }}</h5>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="{{ asset('img/profile/' . $user->image) }}" class="card-img" width="200">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <h6 class="card-header">{{ __('label.change_image') }}</h6>
                                <input type="file" class="btn btn-outline-secondary" id="image" name="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-4">
                    <x-forms.input-password name="current_password" label="Password Saat Ini"/>
                </div>
                <div class="col-md-4">
                    <x-forms.input-password name="password" label="Password Baru"/>
                </div>
                <div class="col-md-4">
                    <x-forms.input-password name="password_confirmation" label="Konfirmasi Password"/>
                </div>
            </div>
                <br>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('button.submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('button.reset') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h4 class="card-header">{{ __('label.delete_account') }}</h4>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-medium mb-1">{{ __('label.are_you_sure_delete_account') }}</h6>
                            <p class="mb-0">{{ __('label.once_your_account_deleted') }}</p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" method="post" action="{{ route('account.profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <x-forms.input-password name="password"/>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                   id="accountActivation"/>
                            <label class="form-check-label"
                                   for="accountActivation">{{ __('label.im_sure_delete_account') }}</label>
                        </div>
                        <button type="submit"  class="btn btn-danger deactivate-account"
                                id="accountActivationButton">{{ __('button.delete_permanently') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const checkBox = $('#accountActivation');
        const accountActivationButton = $('#accountActivationButton');

        $('#password').on('keyup', function (e) {
            checkBox.attr("disabled", e.target.value.length === 0);
        });

        checkBox.on('change', function (e) {
            accountActivationButton.attr('disabled', !checkBox.prop('checked'));
        })

        console.log($('#accountActivation'));
    </script>
@endpush
