@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.print_barcode') }}</h1>
            {{ Breadcrumbs::render('barcode') }}
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="<?=route('admin.barcode.print')?>" method="POST">
                        @csrf
                        <div class="row">
                                <div class="col-sm-5">
                                <div class="form-group">
                                    <label>{{ __('levels.products') }}</label>
                                    <select name="product_id" id="productVariants" class="form-control select2 @error('product_id') is-invalid @enderror">
                                        <option value="">{{ __('levels.select_product') }}</option>
                                        @if(!blank($products))
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ (old('product_id', $set_product_id) == $product->id) ? 'selected' : '' }}>{{ $product->name }} ({{$product->barcode}})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('order.product_variants') }}</label>
                                    <select name="variant_id" id="Variants" class="form-control select2 @error('variant_id') is-invalid @enderror">
                                        <option value="">{{ __('order.select_variants') }}</option>
                                        @if(!blank($variants))
                                            @foreach($variants as $variant)
                                                <option value="{{ $variant->id }}" {{ (old('variant_id', $set_variant_id) == $variant->id) ? 'selected' : '' }}>{{ $variant->name }} ({{$variant->price}}) </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('variant_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-sm-3">
                                <div class="form-group">
                                    <label>{{ __('order.product_quantity') }}</label>
                                    <input id="quantity" type="number" name="quantity" class="form-control {{ $errors->has('quantity') ? " is-invalid " : '' }}" value="{{ old('quantity',$set_quantity) }}">
                                    @error('quantity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-primary form-control" type="submit">{{ __('Get Barcode/Label') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if($showView)
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('levels.print_barcode') }}</h5>
                        <button class="btn btn-success btn-sm report-print-button" onclick="printDiv('printablediv')">{{ __('levels.print') }}</button>
                    </div>
                    <div class="card-body" id="printablediv">
                        @if(isset($productVariant))
                                <div class="printBarcode">
                                @foreach(range(1,$set_quantity) as $number)
                                <div class="item barcodeStyle">
                                    <span class="barcode_site">{{$product->shop->name}}</span>
                                    <span class="barcode_name">{{$product->name}} ({{$productVariant->name}})</span>
                                    <span class="barcode_price">{{__('levels.price')}} {{currencyFormat($product->price + $productVariant->price)}}</span>
                                    <span class="barcode_image">
                                        <img src="{{ $productVariant->barcodeprint }}" alt="{{$product->barcode}}{{$productVariant->id}}" class="{{$product->name}}">
                                    </span>
                                </div>
                              @endforeach
                                </div>
                            </div>
                            @elseif(isset($productBarcode))
                        <div class="printBarcode">
                            @foreach(range(0,$set_quantity) as $number)
                                <div class="item barcodeStyle">
                                    <span class="barcode_site">{{$productBarcode->shop->name}}</span>
                                    <span class="barcode_name">{{$productBarcode->name}}</span>
                                    <span class="barcode_price">{{__('levels.price')}} {{currencyFormat($productBarcode->price)}} @if(isset($productBarcode->tax))/ {{$productBarcode->tax->name}}@endif</span>
                                    <span class="barcode_image">
                                        <img src="{{ $productBarcode->barcodeprint }}" alt="{{$productBarcode->barcode}}" class="{{$productBarcode->name}}">
                                    </span>
                                </div>
                            @endforeach
                        </div>
                </div>
            @else
              <h4 class="text-danger">{{ __('levels.the_barcode_data_not_found') }}</h4>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/barcodeprint.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        const indexUrl = "{{ route('admin.get-product-variants') }}";
    </script>
    <script src="{{ asset('js/product/barcode.js') }}"></script>
@endsection
