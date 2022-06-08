@extends('admin.layouts.master')

@section('main-content')
  
  <section class="section">
        <div class="section-header">
            <h1>{{ __('language.language') }}</h1>
            {{ Breadcrumbs::render('language') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                     
                            <div class="card-header">
                                @can('language_create')
                                    <a href="{{ route('admin.language.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('language.add_language') }}</a>
                                @endcan
                                <a href="{{ url('translations') }}" target="_blank"
                                class="btn btn-icon icon-left btn-primary text-right ml-2"> <i
                                    class="fas fa-cog"></i>{{ __('language.translate') }}
                        </a>
                            </div>
                       
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 offset-sm-3">
                                    <div class="input-group input-daterange" id="date-picker">
                                        <select class="form-control" id="status" name="status" id="">
                                            @foreach(trans('statuses') as $key => $status)
                                                <option value="{{ $key }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="refresh"> {{ __('levels.refresh') }}</button>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="date-search">{{ __('levels.search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" data-url="{{ route('admin.language.index') }}" data-status="{{ \App\Enums\Status::ACTIVE }}" data-hidecolumn="{{ auth()->user()->can('language_edit') || auth()->user()->can('language_delete') }}">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('language.language_name') }}</th>
                                            <th>{{ __('language.flag') }}</th>
                                            <th>{{ __('language.language_code') }}</th>
                                            <th>{{ __('levels.status') }}</th>
                                            <th>{{ __('levels.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/language/index.js') }}"></script>
@endsection
