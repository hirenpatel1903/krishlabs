@extends('admin.layouts.master')

@section('main-content')
	<section class="section">
        <div class="section-header">
        <h1>{{ __('addon.addons') }}</h1>
            {{ Breadcrumbs::render('addons/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-6 col-lg-6">
				    <div class="card">
				    	<form action="{{ route('admin.addons.store') }}" method="POST" enctype="multipart/form-data">
				    		@csrf
						    <div class="card-body">
                                <div class="form-group">
                                    <label for="addon_file">{{ __('addon.file') }}</label>
                                    <div class="custom-file">
                                        <input name="addon_file" type="file"
                                               class="file-upload-input custom-file-input @error('addon_file') is-invalid @enderror"
                                               id="addon_file">
                                        <label class="custom-file-label"
                                               for="addon_file">{{ __('levels.choose_file') }}</label>
                                    </div>
                                    @if ($errors->has('addon_file'))
                                        <div class="help-block text-danger">
                                            {{ $errors->first('addon_file') }}
                                        </div>
                                    @endif
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
