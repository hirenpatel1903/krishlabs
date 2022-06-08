@extends('admin.layouts.master',$customers)

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">

@endsection

@section('main-content')

    <section class="section">
        <livewire:pos-form />
    </section>
    <!-- Modal -->
    <livewire:pos-model.edit-cart-item />
    <livewire:pos-model.order-tax />
    <livewire:pos-model.add-customer />
    <livewire:pos-model.add-payment />
    <livewire:pos-model.print-order />
    <!--  add action error message modal  -->
    <div class="modal fade" id="actionError" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div>{{__('sale.please_add_product')}}</div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-sm btn-primary">{{__('OK')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end action error message here -->
    <!-- cancelOrder modal  -->
    <div class="modal fade" tabindex="-1" role="dialog" id="cancelOrder" aria-modal="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('sale.cancel_order') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{__('sale.do_you_want_to_continue')}}</div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger btn-shadow" href="{{route('admin.pos')}}">{{__('sale.yes')}}</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary" id="" >{{__('sale.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end cancelOrder modal  -->


@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/onscan.js/onscan.min.js') }}"></script>

    <script>
        "use strict";
        @if($errors->any())
        $('#depositModal').modal('show');
        @endif
    </script>
@endsection
@section('livewire-scripts')
    <script src="{{ asset('js/sale/create.js') }}"></script>
@endsection
