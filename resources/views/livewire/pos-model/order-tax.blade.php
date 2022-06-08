<div>
    <!-- start edit cart item modal  -->

    <div wire:ignore.self class="modal fade" id="editOrderTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="cartItem" class="modal-content">
                <div class="modal-header modal-primary">
                    <h5 class="modal-title">{{__('sale.edit_order_tax')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12">
                        <label for="ProductTax">{{ __('sale.tax_rates') }}</label>
                        <select id="ProductTax"  wire:key="taxID" class="form-control" wire:model="taxID" wire:change="changeEventTax">
                            <option value="">{{ __('sale.select_tax_rate') }}</option>
                            @foreach($taxs as $tax)
                                <option value="{{ $tax->id }}"
                                    {{ (old('attribute') === $tax->id) ? 'selected' : '' }}>{{ $tax->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('sale.close') }}</button>
                    <button class="btn btn-success" id="editItem" wire:click.prevent="UpdateOrderTax">{{ __('sale.update') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end edit cart item modal  -->
</div>
