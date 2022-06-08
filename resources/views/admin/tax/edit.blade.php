@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('tax.tax_rates') }}</h1>
            {{ Breadcrumbs::render('tax/edit') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.tax.update', $tax) }}" method="POST">
				    		@method('PUT')
				    		@csrf
						    <div class="card-body">
                                <div class="form-group">
                                    @if(auth()->user()->myrole == 1)
                                        <div class="form-group">
                                            <label for="shop_id">{{ __('tax.shop') }}</label> <span class="text-danger">*</span>
                                            <select name="shop_id" id="shop_id"
                                                    class="select2 form-control @error('shop_id') is-invalid red-border @enderror">
                                                <option value="">{{ __('tax.select_shop') }}</option>
                                                @if(!blank($shops))
                                                    @foreach($shops as $shop)
                                                        <option value="{{ $shop->id }}"
                                                            {{ (old('shop_id',$tax->shop_id) == $shop->id) ? 'selected' : '' }}>{{ $shop->name }}
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
						        <div class="form-group">
			                        <label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $tax->name ) }}">
			                        @error('name')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

                                <div class="form-group">
                                    <label>{{ __('tax.code') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code',$tax->code) }}">
                                    @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tax_rate">{{ __('tax.tax_rates') }}</label> <span class="text-danger">*</span>
                                    <input id="tax_rate" type="number" step="0.01"  name="tax_rate" class="form-control {{ $errors->has('tax_rate') ? " is-invalid " : '' }}" value="{{ old('tax_rate',$tax->tax_rate) }}">
                                    @error('tax_rate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('tax.type') }}</label> <span class="text-danger">*</span>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                                        @foreach(trans('taxtype') as $key => $type)
                                            <option value="{{ $key }}" {{ (old('type',$tax->type) == $key) ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

						        <div class="form-group">
						            <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
						            <select name="status" class="form-control @error('status') is-invalid @enderror">
						            	@foreach(trans('statuses') as $key => $status)
						                	<option value="{{ $key }}" {{ (old('status', $tax->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
						                @endforeach
						            </select>
						            @error('status')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
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
