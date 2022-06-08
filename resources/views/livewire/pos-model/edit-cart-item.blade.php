<div>
    <!-- start edit cart item modal  -->

    <div wire:ignore.self class="modal fade" id="editCartItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="cartItem" class="modal-content">

                <div class="modal-header modal-primary">
                    <h5 class="modal-title">{{$catItemName}} ({{$barcode}})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    @if(!blank($variations))
                            <div class="form-group col-12">
                                <label for="ProductVariants">{{ __('sale.product_variants') }}</label>
                                <select id="ProductVariants"  class="form-control" wire:model="variantID" wire:change="changeEvent">
                                        @foreach($variations as $variation)
                                            <option value="{{ $variation->id }}"
                                                {{ (old('attribute') === $variation->id) ? 'selected' : '' }}>{{ $variation->name }}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                    @endif
                        <div class="form-group col-12">
                            <label for="ProductTax">{{ __('sale.tax_rates') }}</label>
                            <select id="ProductTax"  class="form-control" wire:model="taxID" wire:change="changeEventTax">
                                <option value="">{{ __('sale.select_tax_rate') }}</option>
                            @foreach($taxs as $tax)
                                    <option value="{{ $tax->id }}"
                                        {{ (old('attribute') === $tax->id) ? 'selected' : '' }}>{{ $tax->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group col-12">
                                <label for="nPrice">{{ __('sale.unit_price') }}</label>
                                <input type="number" class="form-control input-sm" id="nPrice" wire:model="cartItemPrice" value="{{$cartItemPrice}}"  placeholder="{{ __('sale.new_price') }}">
                            </div>

                            <div class="form-group col-12">
                                <label for="nQuantity">{{ __('sale.quantity') }}</label>
                                <input type="number" class="form-control input-sm" id="nQuantity" wire:model="cartItemQty" value="{{$cartItemQty}}"  placeholder="{{ __('sale.current_quantity') }}">
                            </div>

                        <table class="table table-bordered ">
                            <tbody><tr>
                                <th  class="pos-cart-css-th">{{ __('sale.unit_price') }}</th>
                                <th class="pos-cart-css-th15"><span >{{currencyFormat($cartItemPrice)}}</span></th>
                                <th class="pos-cart-css-th30">{{ __('sale.tax_rate') }}</th>
                                <th class="pos-cart-css-th15"><span>{{currencyFormat($taxPrice)}}</span></th>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('sale.close') }}</button>
                    <button class="btn btn-success" id="editItem" wire:click.prevent="UpdateCart">{{ __('sale.update') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
