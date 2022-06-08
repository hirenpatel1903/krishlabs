@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('shop.shops') }}</h1>
            {{ Breadcrumbs::render('shop/view') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body card-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{ $user->images }}" alt="User profile picture">
                            <h3 class="text-center">{{ $user->name }}</h3>
                            <p class="text-center">
                                {{ $user->roles->first()->name ?? '' }}
                            </p>

                            <ul class="list-group">
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.username') }}</span> <span class="float-right">{{ $user->name }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.phone') }}</span> <span class="float-right">{{ $user->phone }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.email') }}</span> <span class="float-right">{{ $user->email }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.address') }}</span> <span class="float-right profile-list-group-item-addresss">{{ $user->address }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.deposit_amount') }}</span> <span class="float-right profile-list-group-item-addresss">{{ isset($user->deposit->deposit_amount) ? currencyFormat($user->deposit->deposit_amount) : '' }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.limit_amount') }}</span> <span class="float-right profile-list-group-item-addresss">{{ isset($user->deposit->limit_amount) ? currencyFormat($user->deposit->limit_amount) : '' }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('shop.credit') }}</span> <span class="float-right profile-list-group-item-addresss">{{ currencyFormat($user->balance->balance > 0 ? $user->balance->balance : 0 ) }}</span></li>
                                <li class="list-group-item profile-list-group-item"><span class="float-left font-weight-bold">{{ __('levels.status') }}</span> <span class="float-right profile-list-group-item-addresss">{{ $user->mystatus }}</span></li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-body card-profile shop-edit-button">
                            <img class="profile-user-img img-responsive img-circle" src="{{ $shop->images }}" alt="Shop Image">
                            <h3 class="text-center">{{ $shop->name }}</h3>
                            <p class="text-center">
                                {{ $shop->address }}
                            </p>
                            @isset(auth()->user()->shop->id)
                                <a href="{{ route('admin.shop.edit', auth()->user()->shop->id) }}" class="btn btn-sm btn-icon btn-primary shop-edit-icon" data-toggle="tooltip" data-placement="top" data-original-title="Edit"> <i class="far fa-edit"></i></a>
                            @endisset
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-desc">
                                <div class="single-profile">
                                    <p><b>{{ __('levels.name') }}: </b> {{ $shop->name}}</p>
                                </div>
                                <div class="single-profile">
                                    <p><b>{{ __('levels.status') }}: </b> {{ trans('statuses.'.$shop->status) }}</p>
                                </div>
                                <div class="single-full-profile">
                                    <p><b>{{ __('levels.address') }}: </b> {{ $shop->address}}</p>
                                </div>
                                <div class="single-full-profile">
                                    <p><b>{{ __('levels.description') }}: </b> {!! $shop->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/shop/product.js') }}"></script>
@endsection
