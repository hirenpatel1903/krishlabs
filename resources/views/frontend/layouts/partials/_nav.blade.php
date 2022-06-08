<header class="section-header">
    <section class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-4">
                    <a href="/"  class="brand-wrap">
                        @if(setting('site_logo'))
                            <img  src="{{ asset('images/'.setting('site_logo')) }}" class="me-2 logo" width="120" height="60"
                                 alt="{{ asset('images/'.setting('site_name')) }}"/>
                        @else
                            <img src="{{ asset('images/logo.png') }}" class="me-2 logo" width="120" height="60"
                                 alt="{{ asset('images/'.setting('site_name')) }}"/>
                        @endif
                    </a>
                   <!-- brand-wrap.// -->
                </div>
                <div class="col-lg-6 col-sm-12">
                </div> <!-- col.// -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <nav class="navbar navbar-main navbar-expand-lg navbar-light">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="main_nav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('/')}}">{{ __('frontend.home') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('check-balance')}}">{{ __('frontend.balance') }}</a>
                                    </li>
                                    @if(auth()->user())
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">{{__('frontend.dashboard')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('frontend.logout') }}
                                                <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                                @csrf
                                            </form>
                                        </li>

                                    @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.dashboard.index') }}">{{ __('frontend.login') }}</a>
                                    </li>
                                        @endif
                                </ul>
                            </div> <!-- collapse .// -->
                        </div> <!-- container .// -->
                    </nav>
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- container.// -->
    </section> <!-- header-main .// -->
</header> <!-- section-header.// -->


