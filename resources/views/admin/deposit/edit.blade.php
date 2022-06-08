@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.deposit_update') }}</h1>
            {{ Breadcrumbs::render('deposit/edit') }}
        </div>

        <div class="section-body">
            <form action="{{ route('admin.deposit.update', $deposit) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="user_id">{{ __('levels.customer') }}</label> <span class="text-danger">*</span>
                                        <select name="user_id" id="user_id"
                                                class="select2 form-control @error('user_id') is-invalid red-border @enderror">
                                            <option value="">{{ __('levels.select_customer') }}</option>
                                            @if(!blank($users))
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ (old('user_id',$deposit->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="amount">{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
                                        <input id="amount" type="number" step="0.01"  name="amount" class="form-control {{ $errors->has('amount') ? " is-invalid " : '' }}" value="{{ old('amount',$deposit->amount) }}">
                                        @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('levels.update_deposit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
@endsection
