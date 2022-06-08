@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endsection

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('shop.shops') }}</h1>
        {{ Breadcrumbs::render('shop/add') }}
    </div>

    <div class="section-body">
        <form action="{{ route('admin.shop.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="article-header">
                                <h5>{{ __('shop.general') }}</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                    <input id="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('statuses') as $statusKey => $status)
                                        <option value="{{ $statusKey }}"
                                            {{ (old('status') == $statusKey) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('levels.shop_address') }}</label> <span class="text-danger">*</span>
                                <textarea name="shopaddress"
                                    class="form-control small-textarea-height @error('shopaddress') is-invalid @enderror"
                                    id="shopaddress">{{ old('shopaddress') }}</textarea>
                                @error('shopaddress')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('levels.description') }}</label>
                                <textarea name="description"
                                    class="form-control small-textarea-height @error('description') is-invalid @enderror"
                                    id="description">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customFile">{{ __('levels.shop_image') }}</label>
                                <div class="custom-file">
                                    <input name="image" type="file"
                                        class="custom-file-input @error('image') is-invalid @enderror" id="customFile"
                                        onchange="readURL(this);">
                                    <label class="custom-file-label" for="customFile">{{ __('levels.choose_file') }}</label>
                                </div>
                                @if ($errors->has('image'))
                                <div class="help-block text-danger">
                                    {{ $errors->first('image') }}
                                </div>
                                @endif
                                <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                    src="{{ asset('assets/img/default/shop.png') }}" alt="your image" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="article-header">
                                <h5>{{ __('Shop Owner') }}</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="first_name">{{ __('levels.first_name') }}</label><span
                                        class="text-danger">*</span>
                                    <input id="first_name" type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name') }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="last_name">{{ __('levels.last_name') }}</label><span
                                        class="text-danger">*</span>
                                    <input id="last_name" type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name') }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="email">{{ __('levels.email') }}</label><span class="text-danger">*</span>
                                    <input id="email" type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="username">{{ __('levels.username') }}</label>
                                    <input id="username" type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('last_name') }}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="password">{{ __('levels.password') }}</label><span class="text-danger">*</span>
                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label for="phone">{{ __('levels.phone') }}</label><span class="text-danger">*</span>
                                    <input id="phone" type="number" name="phone" pattern="+[7-9]{2}-[0-9]{3}-[0-9]{4}" 
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('levels.shop_owner_address') }}</label><span
                                    class="text-danger">*</span>
                                <textarea name="address"
                                    class="form-control small-textarea-height @error('address') is-invalid @enderror"
                                    id="address">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="userstatus" class="form-control @error('userstatus') is-invalid @enderror">
                                        @foreach(trans('user_statuses') as $key => $userstatus)
                                            <option value="{{ $key }}" {{ (old('userstatus') == $key) ? 'selected' : '' }}>{{ $userstatus }}</option>
                                        @endforeach
                                    </select>
                                    @error('userstatus')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('js/shop/create.js') }}"></script>
@endsection
