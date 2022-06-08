@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
    {{ Breadcrumbs::render('payment-setting') }}
@endsection

@section('admin.setting.layout')
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="paymentheader text-center">{{ __('setting.payment_type') }}</h4>
                        <hr>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ ((old('settingtypepayment', setting('settingtypepayment')) == 'stripe') || (old('settingtypepayment', setting('settingtypepayment')) == '')) ? 'active' : '' }}"
                                    id="stripe" data-toggle="pill" href="#stripetab" role="tab" aria-controls="stripetab"
                                    aria-selected="true">{{ __('setting.stripe') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (old('settingtypepayment', setting('settingtypepayment')) == 'razorpay') ? 'active' : '' }}" id="razorpay" data-toggle="pill" href="#razorpaytab" role="tab" aria-controls="razorpaytab" aria-selected="false">{{ __('setting.razorpay') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade {{ ((old('settingtypepayment', setting('settingtypepayment')) == 'stripe') || (old('settingtypepayment', setting('settingtypepayment')) == '')) ? 'show active' : '' }}"
                                id="stripetab" role="tabpanel" aria-labelledby="stripe">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.stripe_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="stripe">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stripe_key">{{ __('levels.stripe_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_key" id="stripe_key" type="text"
                                                        class="form-control @error('stripe_key') is-invalid @enderror"
                                                        value="{{ old('stripe_key', setting('stripe_key') ?? '') }}">
                                                    @error('stripe_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="stripe_secret">{{ __('levels.stripe_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="stripe_secret" id="stripe_secret" type="text"
                                                        class="form-control @error('stripe_secret') is-invalid @enderror"
                                                        value="{{ old('stripe_secret', setting('stripe_secret') ?? '') }}">
                                                    @error('stripe_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                                    <select name="stripe_disabled" id="stripe_disabled"
                                                            class="form-control @error('stripe_disabled') is-invalid @enderror">
                                                        <option value="1" {{ (old('stripe_disabled', setting('stripe_disabled')) == 1) ? 'selected' : '' }}> {{ __('setting.enable') }}</option>
                                                        <option value="0" {{ (old('stripe_disabled', setting('stripe_disabled')) == 0) ? 'selected' : '' }}> {{ __('setting.disable') }}</option>
                                                    </select>
                                                    @error('stripe_disabled')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_stripe_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade {{ (old('settingtypepayment', setting('settingtypepayment')) == 'razorpay') ? 'show active' : '' }}"
                                id="razorpaytab" role="tabpanel" aria-labelledby="razorpay">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('admin.setting.payment-update') }}">
                                    @csrf
                                    <fieldset class="setting-fieldset">
                                        <legend class="setting-legend">{{ __('setting.razorpay_setting') }}</legend>
                                        <input type="hidden" name="settingtypepayment" value="razorpay">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="razorpay_key">{{ __('levels.razorpay_key') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_key" id="razorpay_key" type="text"
                                                        class="form-control @error('razorpay_key')is-invalid @enderror"
                                                        value="{{ old('razorpay_key', setting('razorpay_key') ?? '') }}">
                                                    @error('razorpay_key')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="razorpay_secret">{{ __('levels.razorpay_secret') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input name="razorpay_secret" id="razorpay_secret" type="text"
                                                        class="form-control @error('razorpay_secret') is-invalid @enderror"
                                                        value="{{ old('razorpay_secret', setting('razorpay_secret') ?? '') }}">
                                                    @error('razorpay_secret')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                                    <select name="razorpay_disabled" id="razorpay_disabled"
                                                            class="form-control @error('razorpay_disabled') is-invalid @enderror">
                                                        <option value="1" {{ (old('razorpay_disabled', setting('razorpay_disabled')) == 1) ? 'selected' : '' }}> {{ __('setting.enable') }}</option>
                                                        <option value="0" {{ (old('razorpay_disabled', setting('razorpay_disabled')) == 0) ? 'selected' : '' }}> {{ __('setting.disable') }}</option>
                                                    </select>
                                                    @error('razorpay_disabled')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <button class="btn btn-primary">
                                            <span>{{ __('setting.update_razorpay_setting') }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
