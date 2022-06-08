@extends('frontend.layouts.frontend')

@section('content')
    <div class="container-padding">
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h1 class="header-title">{{__('frontend.find_your_balance')}}</h1>
                    <p class="header-description">{{__('frontend.give_your_whatsapp_number')}}</p>
                    <form id="myForm" action="{{ route('check-balance') }}" method="POST" >
                        @csrf
                        <div class="form-group">
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" pattern="+[7-9]{2}-[0-9]{3}-[0-9]{4}"  name="phone" value="{{old('phone',$phone)}}" placeholder="{{ __('frontend.phone_number') }}">
                            @error('phone')
                            <span class="small invalid-feedback text-warning">{{ $message }}</span>
                            @enderror
                        </div>
                        <a href="{{ route('/') }}" class="btn btn-warning float-left mr-2">
                            <i class="fas fa-angle-left" aria-hidden="true"></i> {{__('frontend.cancel')}}
                        </a>
                        <button type="submit" class="btn btn-primary">{{__('frontend.check_balance')}}</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                @if(isset($customer))
                    <article class="card card-size">
                        <div class="card-body">
                            <div class="row">
                                <aside class="col-sm-4">
                                    <a href="#" class="img-wrap">
                                        @if($customer->qrcode)
                                            <img alt="image" src="{{ $customer->qrcode }}" width="125" height="125">
                                        @else
                                            <img alt="image" src="{{ $customer->images }}" >
                                        @endif
                                    </a>
                                </aside>
                                <div class="col-sm-8">
                                    <dl class="row">
                                        <dt class="col-sm-4">{{__('frontend.name')}} <small class="float-right">:</small></dt>
                                        <dd class="col-sm-8">{{ $customer->name }}</dd>

                                        <dt class="col-sm-4">{{__('frontend.phone')}} <small class="float-right">:</small></dt>
                                        <dd class="col-sm-8">{{ $customer->phone }}</dd>

                                        <dt class="col-sm-4">{{__('frontend.balance')}} <small class="float-right">:</small></dt>
                                        <dd class="col-sm-8">{{currencyFormat($customer->balance->balance > 0 ? $customer->balance->balance : 0 ) }}</dd>

                                        <dt class="col-sm-4">{{__('frontend.address')}} <small class="float-right">:</small></dt>
                                        <dd class="col-sm-8">{{ $customer->address }} </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        @elseif(!$details)
                            <div class="row g-4">
                                <div class="col d-flex align-items-start border border-warning bg-white rounded">
                                    <p align="center" class="not-data text-danger  m-auto py-3 h4">{{__('frontend.sorry_no_customer')}}</p>
                                </div>
                            </div>
                    </article>
                    @else
                    <div href="#" class="card card-size card-product-grid">
                        <img src="{{ asset('frontend/images/3.png') }}">
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
