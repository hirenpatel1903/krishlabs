@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('sale.products') }}</h1>
            {{ Breadcrumbs::render('products/edit') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                        <input id="name" type="text" name="name"
                                               class="form-control {{ $errors->has('name') ? " is-invalid " : '' }}"
                                               value="{{ old('name', $product->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col{{ $errors->has('categories') ? " has-error " : '' }}">
                                        <label for="categories">{{ __('levels.categories') }}</label>
                                        <select id="categories" name="categories[]"
                                                class="form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}"
                                                multiple="multiple">
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
                                        <label for="unit_price">{{ __('levels.mrp') }}</label> <span class="text-danger">*</span>
                                        <input id="unit_price" type="text" name="unit_price"
                                               class="form-control {{ $errors->has('unit_price') ? " is-invalid " : '' }}"
                                               value="{{ old('unit_price', $product->unit_price) }}">
                                        @error('unit_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select id="status" name="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                            @foreach(trans('statuses') as $key => $status)
                                                <option value="{{ $key }}"
                                                    {{ (old('status', $product->status) == $key) ? 'selected' : '' }}>
                                                    {{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="description">{{ __('levels.description') }}</label>
                                        <textarea name="description" class="summernote-simple form-control height-textarea @error('description')
                                                  is-invalid @enderror" id="description">
                                            {{ old('description', $product->description) }}
                                        </textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col {{ $errors->has('document') ? 'has-error' : '' }}">
                                        <label for="document">{{ __('levels.image') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="needsclick dropzone {{ $errors->has('document') ? ' is-invalid' : '' }}" id="document-dropzone"></div>
                                        @error('document')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('sale.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/product/edit.js') }}"></script>
@endsection
