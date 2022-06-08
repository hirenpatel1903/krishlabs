@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('language.language') }}</h1>
            {{ Breadcrumbs::render('language/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
						<form action="{{ route('admin.language.store') }}" method="POST">
				    		@csrf
						    <div class="card-body">
						        <div class="form-group">
			                        <label>{{ __('language.language_name') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
			                        @error('name')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>
								<div class="form-group">
			                        <label>{{ __('language.language_code') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
			                        @error('code')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
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


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ asset('js/time-slot/create.js') }}"></script>
@endsection
