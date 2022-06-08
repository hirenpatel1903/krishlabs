@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.deposit') }}</h1>
            {{ Breadcrumbs::render('deposit/add') }}
        </div>

        <div class="section-body">
                <form action="{{ route('admin.deposit.store') }}" method="POST">
                    @csrf
                    <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label for="user_id">{{ __('levels.customer') }}</label> <span class="text-danger">*</span>
                                                    <select name="user_id" id="user_id"
                                                            class="select2 form-control {{ $errors->has('user_id') ? " is-invalid " : '' }}">
                                                        <option value="">{{ __('levels.select_customer') }}</option>
                                                        @if(!blank($users))
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ (old('user_id') == $user->id) ? 'selected' : '' }}>{{ $user->name }}
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
                                                <input id="amount" type="number" step="0.01"  name="amount" class="form-control {{ $errors->has('amount') ? " is-invalid " : '' }}" value="{{ old('amount') }}">
                                                @error('amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ">
                                        <button class="btn btn-primary mr-1" type="submit">{{ __('levels.add_deposit') }}</button>
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
