@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.purchase-code.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.purchase-code.title') !!}
@endsection

@section('container')
    <form method="post" action="{{ route('LaravelInstaller::purchase_code.check') }}" class="tabs-wrap">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group {{ $errors->has('purchase_code') ? ' has-error ' : '' }}">
            <label for="purchase_code">
                {{ trans('installer_messages.purchase-code.form.purchase_code_label') }}
            </label>
            <input type="text" name="purchase_code" id="purchase_code" value="" placeholder="{{ trans('installer_messages.purchase-code.form.purchase_code_label') }}" />
            @if ($errors->has('purchase_code'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('purchase_code') }}
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('purchase_username') ? ' has-error ' : '' }}">
            <label for="purchase_username">
                {{ trans('installer_messages.purchase-code.form.purchase_username_label') }}
            </label>
            <input type="text" name="purchase_username" id="purchase_username" value="" placeholder="{{ trans('installer_messages.purchase-code.form.purchase_username_label') }}" />
            @if ($errors->has('purchase_username'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('purchase_username') }}
                </span>
            @endif
        </div>

        <div class="buttons">
            <button class="button" onclick="showDatabaseSettings();return false">
                {{ trans('installer_messages.purchase-code.form.buttons.verify') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </button>
        </div>
    </form>
@endsection

@section('scripts')
{{--    <script src="{{ asset('js/installer/wizard.js') }}"></script>--}}
@endsection
