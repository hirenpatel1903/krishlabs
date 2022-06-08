@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('levels.customers_add') }}</h1>
            {{ Breadcrumbs::render('customers/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
                    <livewire:customer-post-form />
				</div>
        	</div>
        </div>
    </section>

@endsection


@section('scripts')
	<script src="{{ asset('js/customer/edit.js') }}"></script>
@endsection
