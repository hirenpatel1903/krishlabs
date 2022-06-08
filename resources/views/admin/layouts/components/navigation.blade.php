<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="d-none d-lg-block">
            <span class="nav-link currentDate"></span>
        </li>
        @if (!blank(session()->get('shop_id')))
        <li class="dropdown">
            <a data-toggle="tooltip" data-placement="bottom" title="Change Shop" href="{{ route('admin.change-shop.shop') }}" class="nav-link nav-link-lg beep"><i class="fa fa-exchange-alt"></i></a>
        </li>
        @endif
        <li class="dropdown">
            <a data-toggle="tooltip" data-placement="bottom" title="Go to Frontend" href="{{ route('home') }}" class="nav-link nav-link-lg beep" target="_blank"><i class="fa fa-globe"></i></a>
        </li>
        @if(auth()->user()->can('pos'))
        <li class="d-none d-lg-block">
            <a href="{{route('admin.pos')}}" class="nav-link nav-link-lg" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="POS"><i class="fas fa-th"></i></a>
        </li>
        @endif
        @if(Request::is('admin/pos'))
        <li class="d-none d-lg-block">
            <a href="#depositModal" data-toggle="modal" class="nav-link nav-link-lg"  data-placement="bottom" title="" data-original-title="Deposit"><i class="fas fa-dollar-sign"></i></a>
        </li>
        @endif
        <li class="dropdown">
            <a href="{{ route('admin.profile') }}" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->images }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('levels.profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<!-- start depositModal modal  -->
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('levels.deposit_add')}}</h4>
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <form action="{{ route('admin.deposit.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                            <div class="form-group col-6">
                                <label for="user_id">{{ __('levels.customer') }}</label> <span class="text-danger">*</span>
                                <select name="user_id" id="user_id"
                                        class="select2 form-control {{ $errors->has('user_id') ? " is-invalid " : '' }}">
                                    <option value="">{{ __('levels.select_customer') }}</option>
                                    @if(Request::is('admin/pos'))
                                        @if(!blank($customers))
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ (old('user_id') == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label for="amount">{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
                                <input id="amount" type="text" name="amount" class="form-control {{ $errors->has('amount') ? " is-invalid " : '' }}" value="{{ old('amount') }}">
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{__('levels.close')}}</button>
                    <div>
                        <button class="btn btn-primary mr-1" onclick="depositFunction()" type="submit">{{ __('levels.add_deposit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end order tax modal  -->
