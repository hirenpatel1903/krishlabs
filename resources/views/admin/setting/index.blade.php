@extends('admin.layouts.master')



@section('main-content')



    <section class="section">

        <div class="section-header">

            <h1>{{ __('Settings') }}</h1>



            @yield('admin.setting.breadcrumbs')

        </div>

    </section>



    <div class="row">

        <div class="col-md-3">

            <div class="bg-light card">

                <div class="list-group list-group-flush">

                    <a href="{{ route('admin.setting.index') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting')) ? 'active' : '' }} ">{{ __('Site Setting') }}</a>

                    <a href="{{ route('admin.setting.whatsapp') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting/whatsapp')) ? 'active' : '' }}">{{ __('WhatsApp SMS Setting') }}</a>

                    <a href="{{ route('admin.setting.sms') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting/sms')) ? 'active' : '' }}">{{ __('SMS Setting') }}</a>

                    <a href="{{ route('admin.setting.payment') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting/payment')) ? 'active' : '' }}">{{ __('Payment Setting') }}</a>

                    <a href="{{ route('admin.setting.email') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting/email')) ? 'active' : '' }}">{{ __('Email Setting') }}</a>

                    <!-- <a href="{{ route('admin.setting.purchasekey') }}" class="border-0 list-group-item list-group-item-action {{ (request()->is('admin/setting/purchasekey')) ? 'active' : '' }}">{{ __('setting.purchase_key_setting') }}</a> -->



                </div>

            </div>

        </div>



        @yield('admin.setting.layout')

    </div>



@endsection



@section('css')

    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">

@endsection



@section('scripts')

    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>

    <script src="{{ asset('js/setting/create.js') }}"></script>

@endsection

