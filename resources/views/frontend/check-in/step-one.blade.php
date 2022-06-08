@extends('frontend.layouts.frontend')

@section('content')
    <div class="container-padding">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="header-title">{{__('frontend.register_with_us')}}</h1>
                <p class="header-description">{{__('frontend.register_by')}}</p>

                <form id="payment-form" action="{{ route('check-in.step-one.store') }}" method="POST" >
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{old('first_name')}}" placeholder="{{ __('frontend.first_name') }}">
                            @error('first_name')
                            <span class="small invalid-feedback text-warning">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{old('last_name')}}" placeholder="{{ __('frontend.last_name') }}">
                            @error('last_name')
                            <span class="small invalid-feedback text-warning">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" pattern="+[7-9]{2}-[0-9]{3}-[0-9]{4}"  value="{{old('phone')}}" placeholder="{{ __('frontend.phone_number') }}">
                            @error('phone')
                            <span class="small invalid-feedback text-warning">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            @if(auth()->user())
                            <input type="number" step="0.01" class="form-control @error('deposit_amount') is-invalid @enderror" id="deposit_amount" name="deposit_amount" value="{{old('deposit_amount')}}" placeholder="{{ __('frontend.deposit_amount') }}">
                            @elseif(setting('stripe_key') && setting('stripe_secret') || setting('razorpay_key') && setting('razorpay_secret'))
                            <input type="number" step="0.01" class="form-control @error('deposit_amount') is-invalid @enderror" id="deposit_amount" name="deposit_amount" value="{{old('deposit_amount')}}" placeholder="{{ __('frontend.deposit_amount') }}">
                            @endif
                            @error('deposit_amount')
                            <span class="small invalid-feedback text-warning">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        @if(auth()->user())
                        <select class="form-control @error('payment_type') is-invalid @enderror" name="payment_type" id="payment_type" >
                            <option value="{{ App\Enums\PaymentMethod::CASH }}"
                                    @if (old('payment_type') == App\Enums\PaymentMethod::CASH) selected="selected" @endif>{{ __('frontend.cash') }}</option>
                            @if(setting('stripe_disabled') && setting('stripe_key') && setting('stripe_secret'))
                                <option value="{{ App\Enums\PaymentMethod::STRIPE }}"
                                        @if (old('payment_type') == App\Enums\PaymentMethod::STRIPE) selected="selected" @endif>{{ __('frontend.Stripe') }}</option>
                            @endif
                            @if(setting('razorpay_disabled') && setting('razorpay_key') && setting('razorpay_secret'))
                                <option value="{{ App\Enums\PaymentMethod::RAZORPAY }}"
                                        @if (old('payment_type') == App\Enums\PaymentMethod::RAZORPAY) selected="selected" @endif>{{ __('frontend.razorPay') }}</option>
                            @endif
                        </select>
                        @elseif(setting('stripe_disabled') || setting('stripe_key') && setting('stripe_secret') || setting('razorpay_disabled') || setting('razorpay_key') && setting('razorpay_secret'))
                        <select class="form-control  @error('payment_type') is-invalid @enderror" name="payment_type" id="payment_type" >
                                @if(setting('stripe_disabled') && setting('stripe_key') && setting('stripe_secret'))
                                    <option value="{{ App\Enums\PaymentMethod::STRIPE }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::STRIPE) selected="selected" @endif>{{ __('frontend.stripe') }}</option>
                                @endif
                                @if(setting('razorpay_disabled') && setting('razorpay_key') && setting('razorpay_secret'))
                                    <option value="{{ App\Enums\PaymentMethod::RAZORPAY }}"
                                            @if (old('payment_type') == App\Enums\PaymentMethod::RAZORPAY) selected="selected" @endif>{{ __('frontend.razorPay') }}</option>
                                @endif
                            </select>
                       @endif
                        @error('payment_type')
                        <span class="small invalid-feedback text-warning">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row g-2 my-2 stripe-payment-method-div">
                        <div class="col-md">
                            <div class="reg-form form-floating border-black">
                                <div class="payment-card-css mb-3">
                                    <label id="card-element-label">{{ __('frontend.credit_debit_card') }}</label>
                                    <div class="mt-1">
                                        <div id="card-element"></div>
                                        <div id="card-errors" class="text-warning" role="alert"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{__('frontend.take_membership')}}</button>
                </form>
            </div>

            <div class="col-lg-6">
                <div href="#" class="card card-size card-product-grid">
                    <img src="{{ asset('frontend/images/2.png') }}">
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        "use strict";
        const stripeKey = "{{ setting('stripe_key') }}";
        const razorPayKey = "{{ setting('razorpay_key') }}";
        const siteName = "{{ setting('site_name') }}";
        const currency = "{{ setting('currency_name') }}";
        const siteLogo = "{{ settingLogo() }}";
    </script>
    @if(setting('stripe_key'))
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('frontend/js/stripe.js') }}"></script>
    @endif
    @if(setting('stripe_key'))
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/checkout.js') }}"></script>
@endpush
