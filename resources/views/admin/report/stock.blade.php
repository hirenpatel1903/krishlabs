@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.stock_report') }}</h1>
            {{ Breadcrumbs::render('stock-report') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">

                    <form action="<?=route('admin.stock-report.index')?>" method="POST">
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
                                                            {{ (old('shop_id') == $shop->id) ? 'selected' : '' }}>{{ $shop->name }}
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
                                    <label for="product">{{ __('levels.product') }}</label>
                                    <select id="product" name="product_id" class="form-control select2">
                                        <option value="">{{ __('levels.select_product') }}</option>
                                        @if(!blank($products))
                                            @foreach($products as $product)
                                                @if($product->type == 10 && !blank($product->variations))
                                                    <option {{(old('product_id',$set_to_product_id)== $product->id) ? 'selected' : ''}} value="{{ $product->id }}" data-product-type="{{$product->type}}" data-variant="{{$product->variations[0]->id}}">{{$product->barcode}}{{$product->variations[0]->id}}-{{ $product->name }} ({{$product->variations[0]->name}})</option>
                                                @else
                                                    <option {{(old('product_id',$set_to_product_id)== $product->id) ? 'selected' : ''}} value="{{ $product->id }}" data-variant="" data-product-type="{{$product->type}}">{{$product->barcode}}-{{ $product->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

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
                        <h5>{{ __('levels.stock_report') }} </h5>
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('Print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        @if(!blank($stockProducts))
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            @if(auth()->user()->myrole == 1)
                                                <th>{{ __('Shop') }}</th>
                                            @endif
                                            <th>{{ __('levels.product') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('levels.cost') }}</th>
                                            <th>{{ __('order.sale_qty') }}</th>
                                            <th>{{ __('order.total_qty') }}</th>
                                            <th>{{ __('order.stock_qty') }}</th>
                                            <th>{{ __('levels.income') }}</th>

                                        </tr>
                                        @php($i=0)
                                        @foreach($stockProducts as $stock)
                                            <tr>
                                                <td>{{$i+=1}}</td>
                                                @if(auth()->user()->myrole == 1)
                                                <td>{{ $stock->shop->name }}</td>
                                                @endif
                                                <td>{{$stock->name}}</td>
                                                <td>{{$stock->unit->name}}</td>
                                                <td>{{currencyFormat($stock->cost)}}</td>
                                                <td>{{number_format(isset($productSaleQuantity[$stock->id]) ? $productSaleQuantity[$stock->id]->quantity: 0)}}</td>
                                                <td>{{number_format(isset($productQuantity[$stock->id]) ? $productQuantity[$stock->id]->quantity: 0)}}</td>
                                                <td>{{number_format( (isset($productQuantity[$stock->id]) ? $productQuantity[$stock->id]->quantity: 0) -  (isset($productSaleQuantity[$stock->id]) ? $productSaleQuantity[$stock->id]->quantity: 0))}}</td>
                                                <td>{{currencyFormat(isset($productSaleQuantity[$stock->id]) ? $productSaleQuantity[$stock->id]->total_amount: 0)}}</td>
                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        @else
                            <h4 class="text-danger">{{ __('levels.the_stock_data_not_found') }}</h4>
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
