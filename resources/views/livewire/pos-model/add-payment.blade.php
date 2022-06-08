<div>
    <!-- start payment modal  -->
    <div wire:ignore.self class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('sale.payment')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body justify-content-between">
                    <div class="row">
                        <div class="col-12">
                            <div class="font16">
                                <table class="table table-bordered table-condensed">
                                    <tbody>
                                    <tr>
                                        <td width="25%" class="pos-table-total-css">{{__('sale.total_items')}}</td>
                                        <td width="25%" class="text-right"><span id="item_count">{{$totalItem}} ({{$totalQty}})</span></td>
                                        <td width="25%" class="pos-table-total-css">{{__('sale.total_payable')}}</td>
                                        <td width="25%" class="text-right"><span id="twt">{{currencyFormat($totalAmount)}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="pos-table-total-css">{{__('sale.total_customer_credit')}}</td>
                                        <td class="text-right"><span id="total_credit">{{currencyFormat($customerBalance)}}</span></td>
                                        <td class="pos-table-total-css">{{__('sale.total_paying')}}</td>
                                        <td class="text-right"><span id="total_paying">{{currencyFormat($cash_paying)}}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="amounts">{{__('sale.credit_amount')}}</label>
                                        <input  type="number" wire:model="credit_amount" value="{{$credit_amount}}" id="amounts" class="form-control @error('credit_amount') is-invalid @enderror amount">
                                        @error('credit_amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="amount">{{__('sale.cash_amount')}}</label>
                                        <input  type="number" id="amount" wire:model="cash_amount" class="form-control @error('cash_amount') is-invalid @enderror amount">
                                        @error('cash_amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="note">{{__('sale.note')}}</label>
                                <textarea  id="note" wire:model="description" class="pa form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{__('sale.close')}} </button>
                    <button class="btn btn-primary"  wire:click.prevent="store">{{__('levels.submit')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end payment modal  -->
</div>
