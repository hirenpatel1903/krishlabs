@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('menu.categories') }}</h1>
            {{ Breadcrumbs::render('categories/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
				    <div class="card">
				    	<form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
				    		@csrf
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
                                        @else
                                            <input type="hidden" name="shop_id" value="{{auth()->user()->shop->id ?? 0}}">
                                        @endif

									<div class="form-group col">
										<label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
										<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
										@error('name')
										<div class="invalid-feedback">
											{{ $message }}
										</div>
										@enderror
									</div>

									<div class="form-group col">
										<label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
										<select name="status" class="form-control @error('status') is-invalid @enderror">
											@foreach(trans('statuses') as $key => $status)
												<option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
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
										<label for="customFile">{{ __('levels.category_image') }}</label>
										<div class="custom-file">
											<input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
											<label  class="custom-file-label" for="customFile">{{ __('levels.choose_file') }}</label>
										</div>
										@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
										@endif
										<img class="img-thumbnail mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/category.png') }}" alt="your image" width="120px"/>
									</div>

									<div class="form-group col">
										<label>{{ __('levels.description') }}</label>
										<textarea name="description" class="summernote-simple form-control height-textarea @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
										@error('description')
										<div class="invalid-feedback">
											{{ $message }}
										</div>
										@enderror
									</div>
								</div>
						    </div>

					        <div class="card-footer">
		                    	<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
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
    <script src="{{ asset('js/category/create.js') }}"></script>
@endsection
