<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ setting('site_name'). ' - ' . __('Login') }}</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        @if(setting('site_logo'))
                            <img src="{{ asset('images/'.setting('site_logo')) }}" alt="logo" width="100">
                        @else
                            <b>{{ setting('site_name') }}</b>
                        @endif
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{ __('Login') }}</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="demoemail">{{ __('Email') }}</label><span class="text-danger"> *</span>
                                    <input id="demoemail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" />
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="demopassword" class="control-label">{{ __('Password') }}</label><span class="text-danger"> *</span>
                                    </div>
                                    <input id="demopassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password"/>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if(env('DEMO'))
                <div class="card mx-auto text-center col-md-6">
                    <div class="card-header">
                        <h4 class="mb-0">{{ __('For Quick Demo Login Click Below...') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="buttons">
                            <button id="demoadmin" class="btn btn-primary">{{ __('Admin') }}</button>
                            <button id="demoshopowner" class="btn btn-success">{{ __('Shop Owner') }}</button>
                            <button id="demoshopowner2" class="btn btn-info">{{ __('Shop Owner Two') }}</button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="simple-footer">
                {{ setting('site_footer') }}
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/demo-login.js') }}"></script>

</body>
</html>
