@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('menu.products') }}</h1>
            {{ Breadcrumbs::render('products/edit') }}
        </div>

        <div class="section-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    @if(auth()->user()->myrole == 1)
                                        <div class="form-group col">
                                            <label for="shop_id">{{ __('menu.shop') }}</label> <span class="text-danger">*</span>
                                            <select name="shop_id" id="shop_id"
                                                    class="select2 form-control @error('shop_id') is-invalid red-border @enderror">
                                                <option value="">{{ __('levels.select_shop') }}</option>
                                                @if(!blank($shops))
                                                    @foreach($shops as $shop)
                                                        <option value="{{ $shop->id }}"
                                                            {{ (old('shop_id',$product->shop_id) == $shop->id) ? 'selected' : '' }}>{{ $shop->name }}
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
                                    @else
                                        <input type="hidden" name="shop_id" value="{{auth()->user()->shop->id ?? 0}}">
                                    @endif

                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                        <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? " is-invalid " : '' }}" value="{{ old('name',$product->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col {{ $errors->has('categories') ? " has-error " : '' }}">
                                        <label for="categories">{{ __('levels.categories') }}</label>
                                        <select id="categories" name="categories[]" class="form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}" multiple="multiple">
                                            @if(!blank($categories))
                                                @foreach($categories as $category)
                                                    @if(in_array($category->id, $product_categories))
                                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('categories'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('categories') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="cost">{{ __('order.product_cost') }}</label> <span class="text-danger">*</span>
                                        <input id="cost" type="number" step="0.01"  name="cost" class="form-control {{ $errors->has('cost') ? " is-invalid " : '' }}" value="{{ old('cost',$product->cost) }}">
                                        @error('cost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="price">{{ __('order.product_price') }}</label> <span class="text-danger">*</span>
                                        <input id="price" type="number" step="0.01"  name="price" class="form-control {{ $errors->has('price') ? " is-invalid " : '' }}" value="{{ old('price',$product->price) }}">
                                        @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="unit">{{ __('order.product_unit') }}</label> <span class="text-danger">*</span>
                                        <select id="unit" name="unit" class="form-control @error('unit') is-invalid @enderror">
                                            <option value="">{{__('levels.select_unit')}}</option>
                                            @foreach($units as $key => $unit)
                                                <option value="{{ $unit->id }}" {{ (old('unit',$product->unit_id) == $unit->id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="tax_id">{{ __('order.tax_rate') }}</label>
                                        <select id="tax_id" name="tax_id" class="form-control @error('tax_id') is-invalid @enderror">
                                            <option value="">{{__('levels.select_tax_rate')}}</option>
                                            @foreach($taxs as $key => $tax)
                                                <option value="{{ $tax->id }}" {{ (old('tax_id',$product->tax_id) == $tax->id) ? 'selected' : '' }}>{{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('tax_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="barcode">{{ __('levels.barcode') }}</label> <span class="text-danger">*</span>
                                        <input id="barcode" type="text" name="barcode" class="form-control {{ $errors->has('barcode') ? " is-invalid " : '' }}" value="{{ old('barcode',$product->barcode) }}">
                                        @error('barcode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="barcode_type">{{ __('levels.barcode_type') }}</label> <span class="text-danger">*</span>
                                        <select id="barcode_type" name="barcode_type" class="form-control @error('status') is-invalid @enderror">
                                            @foreach(trans('barcodes') as $key => $barcode)
                                                <option value="{{ $barcode }}" {{ (old('barcode_type',$product->barcode_type) == $barcode) ? 'selected' : '' }}>{{ $barcode }}</option>
                                            @endforeach
                                        </select>
                                        @error('barcode_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="description">{{ __('levels.description') }}</label>
                                        <textarea name="description"
                                                  class="summernote-simple form-control height-textarea @error('description')
                                                      is-invalid @enderror"
                                                  id="description" >
                                                {{ old('description',$product->description) }}
                                            </textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('statuses') as $key => $status)
                                            <option value="{{ $key }}" {{ (old('status',$product->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="customFile">{{ __('levels.image') }}</label>
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
                                            <label  class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="help-block text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                        @if($product->getFirstMediaUrl('products'))
                                            <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset($product->getFirstMediaUrl('products')) }}" alt="{{$product->name}}"/>
                                        @else
                                            <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/product.png') }}" alt="{{$product->name}}"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('levels.update_product') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="custom-control custom-checkbox checkbox-xl">
                                    <input type="checkbox" name="variant" class="custom-control-input" id="checkbox-3" @if($product->type == 10 ) checked @elseif(old('variant') == 'on')  checked @endif   onclick="myFunction()">
                                    <label class="custom-control-label" for="checkbox-3">{{__('order.this_product_has_multiple_variants')}}</label>
                                </div>
                                <div class="row" id="variantsShow">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="itemTable">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('levels.name') }}</th>
                                                    <th>{{ __('order.additional_price') }}</th>
                                                    <th>{{ __('levels.actions') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="variationName"  placeholder="{{ __('levels.name') }}" class="form-control form-control-sm" value="">
                                                    </td>
                                                    <td>
                                                        <input type="number" id="variationPrice"  placeholder="{{ __('levels.price') }}" class="form-control form-control-sm change-productprice " value="" step="any">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" onclick="return variationAdd(event)">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @if(!blank(session('variation')))
                                                    @foreach(session('variation') as $variation)
                                                        <?php
                                                        if($variation == 0) {
                                                            continue;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="variation[<?=$variation?>][name]" placeholder="{{ __('levels.name') }}" class="form-control form-control-sm @error("variation.$variation.name") is-invalid @enderror" value="{{ old("variation.$variation.name") }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="variation[<?=$variation?>][price]" placeholder="{{ __('levels.price') }}" class="form-control form-control-sm change-productprice @error("variation.$variation.price") is-invalid @enderror" value="{{ old("variation.$variation.price") }}" step="any">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm removeBtn">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @elseif(!blank($product_variations))
                                                    @foreach($product_variations as $product_variation)
                                                        <?php
                                                        $variation = $product_variation->id;
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="variation[<?=$variation?>][name]" placeholder="{{ __('levels.name') }}" class="form-control form-control-sm @error("variation.$variation.name") is-invalid @enderror" value="{{ old("variation.$variation.name", $product_variation->name) }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="variation[<?=$variation?>][price]" placeholder="{{ __('levels.price') }}" class="form-control form-control-sm change-productprice @error("variation.$variation.price") is-invalid @enderror" value="{{ old("variation.$variation.price", $product_variation->price) }}" step="any">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm removeBtn">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('js/product/edit.js') }}"></script>
    <script>
        var product_variation_count  = <?=!blank(session('variation')) ? count(session('variation')) : ($product_variations->count() == 0 ? 0 : $product_variations->count())?>;

        var categoryShopUrl = "{{ route('admin.shop-category') }}";
        var UnitShopUrl = "{{ route('admin.shop-unit') }}";
        var TaxShopUrl = "{{ route('admin.shop-tax') }}";
    </script>
@endsection
