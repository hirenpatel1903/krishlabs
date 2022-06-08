@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('email-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.email-update') }}">
                    @csrf
                    <fieldset class="setting-fieldset">
                        <legend class="setting-legend">{{ __('setting.email_setting') }}</legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mail_host">{{ __('levels.mail_host') }}</label> <span class="text-danger">*</span>
                                    <input name="mail_host" id="mail_host" type="text"
                                        class="form-control @error('mail_host') is-invalid @enderror"
                                        value="{{ old('mail_host', setting('mail_host')) }}">
                                    @error('mail_host')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mail_username">{{ __('levels.mail_username') }}</label> <span
                                        class="text-danger">*</span>
                                    <input name="mail_username" id="mail_username" type="text"
                                        class="form-control @error('mail_username') is-invalid @enderror"
                                        value="{{ old('mail_username', setting('mail_username')) }}">
                                    @error('mail_username')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mail_from_name">{{ __('levels.mail_from_name') }}</label> <span
                                        class="text-danger">*</span>
                                    <input name="mail_from_name" id="mail_from_name" type="text"
                                        class="form-control @error('mail_from_name') is-invalid @enderror"
                                        value="{{ old('mail_from_name', setting('mail_from_name')) }}">
                                    @error('mail_from_name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="mail_disabled" id="mail_disabled"
                                        class="form-control @error('mail_disabled') is-invalid @enderror">
                                        <option value="1" {{ (old('mail_disabled', setting('mail_disabled')) == 1) ? 'selected' : '' }}> {{ __('setting.enable') }}</option>
                                        <option value="0" {{ (old('mail_disabled', setting('mail_disabled')) == 0) ? 'selected' : '' }}> {{ __('setting.disable') }}</option>
                                    </select>
                                    @error('mail_disabled')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mail_port">{{ __('levels.mail_port') }}</label> <span class="text-danger">*</span>
                                    <input name="mail_port" id="mail_port" class="form-control @error('mail_port') is-invalid @enderror"
                                        value="{{ old('mail_port', setting('mail_port')) }}">
                                    @error('mail_port')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mail_password">{{ __('levels.mail_password') }}</label> <span
                                        class="text-danger">*</span>
                                    <input name="mail_password" id="mail_password" type="text"
                                        class="form-control @error('mail_password') is-invalid @enderror"
                                        value="{{ old('mail_password', setting('mail_password')) }}">
                                    @error('mail_password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mail_from_address">{{ __('levels.mail_from_address') }}</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="mail_from_address" id="mail_from_address" cols="30" rows="2"
                                        class="form-control @error('mail_from_address') is-invalid @enderror">{{ old('mail_from_address', setting('mail_from_address')) }}</textarea>
                                    @error('mail_from_address')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <span>{{ __('setting.update_email_setting') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
