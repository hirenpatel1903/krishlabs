<div>
    <!--  start print order modal  -->
    <div wire:ignore.self class="modal fade" id="printOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sale.print_order') }}</h4>
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <button type="button" class="close mr10" onclick="printDiv('print_order_body')" ><i class="fa fa-print"></i></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="print_order_body">
                        <style>.bb td, .bb th { border-bottom: 1px solid #DDD;border-top: 1px solid #DDD; }</style>
                        <span class="text-center">
                            <h3>@if(auth()->user()->shop) {{auth()->user()->shop->name}}@endif</h3>
                            <h4>{{__('sale.order')}}</h4>
                          </span>
                        <h6> {{ __('sale.c') }}:   @if(!blank($customer)){{$customer->name}}@endif</h6>
                        <h6> {{ __('sale.r') }}: @if(!blank($reference)){{$reference}}@endif</h6>
                        <h6> {{ __('sale.u') }}: {{auth()->user()->name}}</h6>
                        <h6>{{ __('sale.t') }}: <?=date('d M Y h:m A')?></h6>
                        <table id="order-table" class="table table-condensed">
                            <tbody>
                                @if(!blank($carts))
                                    @php($i=0)
                                    @foreach($carts as $cart)
                                        <tr class="bb" data-item-id="1"><td>#{{$i+=1}}  {{$cart['name']}} ({{$cart['barcode']}})</td><td>[ {{$cart['qty']}} ]</td></tr>
                                        @endforeach
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end print order modal here -->

    <!-- print bill modal -->
    <div class="modal fade" id="printBillModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="print-title">{{ __('sale.print_bill') }}</h4>
                    <div>
                        <button type="button" class="close mr10" onclick="printBill('print_bill_body')"><i class="fa fa-print"></i></button>
                        <button type="button" class="close" id="print-modal-close"  data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="print_bill_body">
                        <style>.bb td, .bb th { border-bottom: 1px solid #DDD; }</style>
                        <span class="text-center">
                        <h3>@if(auth()->user()->shop) {{auth()->user()->shop->name}}@endif</h3>
                        <h4>{{__('sale.bill')}}</h4>
                        </span>
                        <h6>{{ __('sale.c') }}:  @if(!blank($customer)){{$customer->name}}@endif</h6>
                        <h6>{{ __('sale.r') }}:  @if(!blank($reference)){{$reference}}@endif</h6>
                        <h6>{{ __('sale.u') }}:  {{auth()->user()->name}}</h6>
                        <h6>{{ __('sale.t') }}:  <?=date('d M Y h:m A')?></h6>
                        <table id="bill-table" width="100%" class="prT table table-condensed">
                            <tbody>
                            @if(!blank($carts))
                                @php($i=0)
                                @foreach($carts as $cart)
                                    <tr class="bb" data-item-id="1"><td>#{{$i+=1}}  {{$cart['name']}} ({{$cart['barcode']}})</td></tr>
                                    <tr class="bb" data-item-id="1"><td>( {{$cart['qty']}} x {{number_format($cart['price'])}}) =  {{currencyFormat($cart['price'] * $cart['qty'])}}</td></tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <table id="bill-total-table" class="table table-condensed">
                            <tbody>
                            <tr class="bb">
                                <td>{{__('sale.total_items')}}</td>
                                <td class="text-right">{{$totalItem}} ({{$totalQty}})</td>
                            </tr>
                            <tr class="bb">
                                <td>{{__('sale.total')}}</td>
                                <td class="text-right">{{currencyFormat($totalAmount)}}</td>
                            </tr>

                            <tr>
                                <td>{{__('sale.total_payable')}}</td>
                                <td class="text-right">{{currencyFormat($totalAmount)}}</td>
                            </tr>
                            <tr><td colspan="2" class="text-center">{{__('sale.merchant_copy')}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End print bill modal -->
</div>
