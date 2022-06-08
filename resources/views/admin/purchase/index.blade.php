@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('menu.purchases') }}</h1>
            {{ Breadcrumbs::render('purchase') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(auth()->user()->can('purchase_create'))
                        <div class="card-header">
                            <a href="{{ route('admin.purchase.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('Add Purchase') }}
                            </a>
                        </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" data-url="{{ route('admin.purchase.get-purchase') }}" data-status="{{ \App\Enums\Status::ACTIVE }}">
                                    <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('menu.shop') }}</th>
                                        <th>{{ __('order.purchaseNo') }}</th>
                                        <th>{{ __('level.date') }}</th>
                                        <th>{{ __('levels.status') }}</th>
                                        <th>{{ __('levels.amount') }}</th>
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
    <!-- Delete Model -->
    <form action="" method="POST" class="remove-record-model">
        {{ csrf_field() }}
        <div id="custom-width-modal" class="modal fade purchase-model" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
            <div class="modal-dialog model-dialog-purchase">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <h4>{{__('levels.are_you_sure_want_to_delete_this_record')}}</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{__('level.close')}}</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">{{__('level.delete')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/purchase/index.js') }}"></script>
@endsection
