@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.sales_report') }}</h1>
            {{ Breadcrumbs::render('sales-report') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">

                    <form action="<?=route('admin.sales-report.index')?>" method="POST">
                        @csrf
                        <div class="row">
                                    @if(auth()->user()->myrole == 1)
                                <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="shop_id">{{ __('menu.shop') }}</label> <span class="text-danger">*</span>
                                            <select name="shop_id" id="shop_id"
                                                    class="select2 form-control @error('shop_id') is-invalid red-border @enderror">
                                                <option value="">{{ __('levels.select_shop') }}</option>
                                                @if(!blank($shops))
                                                    @foreach($shops as $shop)
                                                        <option value="{{ $shop->id }}"
                                                            {{ (old('shop_id',$set_to_shop_id) == $shop->id) ? 'selected' : '' }}>{{ $shop->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('shop_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                </div>
                                    @else
                                        <input type="hidden" name="shop_id" value="{{auth()->user()->shop->id ?? 0}}">
                                    @endif

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('levels.from_date') }}</label>
                                    <input type="text" name="from_date" class="form-control @error('from_date') is-invalid @enderror datepicker" value="{{ old('from_date', $set_from_date) }}">
                                    @error('from_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('levels.to_date') }}</label>
                                    <input type="text" name="to_date" class="form-control @error('to_date') is-invalid @enderror datepicker" value="{{ old('to_date', $set_to_date) }}">
                                    @error('to_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-primary form-control" type="submit">{{__('levels.get_report')}}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if($showView)
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('levels.sales_report') }} </h5>
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('Print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        @if(!blank($sales))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.bill_no') }}</th>
                                            <th>{{ __('levels.customer') }}</th>
                                            <th>{{ __('levels.date') }}</th>
                                            <th>{{ __('Order Tax') }}</th>
                                            <th>{{ __('levels.total') }}</th>
                                            <th>{{ __('levels.paid') }}</th>
                                            <th>{{ __('levels.change') }}</th>

                                        </tr>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->sale_no }}</td>
                                                <td>{{ $sale->user->name }}</td>
                                                <td>{{ date('d M Y', strtotime($sale->created_at))}}</td>
                                                <td>{{ currencyFormat($sale->tax_amount) }}</td>
                                                <td>{{ currencyFormat($sale->total) }}</td>
                                                <td>{{ currencyFormat($sale->paid_amount) }}</td>
                                                <td>{{ currencyFormat($sale->paid_amount-$sale->total) }}</td>
                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        @else
                            <h4 class="text-danger">{{ __('levels.the_sales_data_not_found') }}</h4>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/report/sales.js') }}"></script>
@endsection
