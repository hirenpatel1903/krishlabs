@extends('frontend.layouts.frontend')

@section('content')
    <div class="container-padding">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="header-title">{{ __('frontend.welcome_to') }} {{ setting('site_name') }}</h1>
            <p class="header-description">{{ setting('site_description') }}</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <p class="lead">
                    <a href="{{ route('check-in.step-one') }}" class="btn btn-primary btn-lg text-white">
                        {{__('frontend.register')}}
                        <i class="ml-2 fas fa-angle-right"></i>
                    </a>
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <div href="#" class="card card-size card-product-grid">
                <img src="{{ asset('frontend/images/1.png') }}">
            </div>
        </div>
    </div>
</div>

@endsection

