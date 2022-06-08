<div>
<div class="section-body mt-lg-1 row">
<div class="col-sm-6 col-md-6 col-lg-7 mt-2 mt-lg-0 px-3 product-card" >
    <div id="item-list" class="item-list-css">
        @if(!blank($products))
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 product-button">
                @if($product->type == 10 && !blank($product->variations))
                    <button type="button"  id="{{$product->id}}" class="btn card mx-1 addProduct pos-product-button" wire:key="Product{{$loop->index}}" wire:click.prevent="addCart({{$product->id}})">
                                <span class="bg-img-product">
                                    <img  class="img-pos-product" src="{{$product->images}}" alt="{{$product->name}}">
                                </span>
                        <span>{{$product->barcode}}{{$product->variations[0]->id}}-{{ $product->name }} ({{$product->variations[0]->name}})</span>
                    </button>
                @else
                    <button type="button"  class="btn card mx-1 addProduct pos-product-button" wire:key="Product{{$loop->index}}" wire:click.prevent="addCart({{$product->id}})">
                            <span class="bg-img">
                                <img src="{{$product->images}}" alt="{{$product->name}}" class="img-pos-product">
                            </span>
                        <span>{{$product->barcode}}-{{$product->name}}</span>
                    </button>
                @endif
            </div>
           @endforeach
        </div>
        @endif
    </div>
</div> <!-- End right card div-->

<div class="card col-sm-6 col-md-6 col-lg-5 mt-2 mt-lg-0 mb-0 pos-card"  >
    <div class="card-body py-3 px-2">
        <form action="#">
            <div class="card-pos-css">
                <div class="form-group card-form-pos-css">
                    <div class="input-group"  wire:key="customer_id" >
                        <select data-placeholder="Select Customer" required="required" class="form-control  @error('customer_id') is-invalid @enderror" tabindex="-1" aria-hidden="true" id="customerID"  wire:model="customer_id">
                            <option value="1">{{__('sale.select_customer')}}</option>
                            @if(!blank($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('attribute') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="input-group-append">
                            <a class="input-group-text"  wire:click.prevent="addCustomer" id="add-customer" data-toggle="modal"><i class="fa fa-2x fa-plus-circle"></i></a>
                        </div>
                        @error('customer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="form-group card-form-pos-css">
                    <input type="text"  class="form-control @error('reference') is-invalid @enderror" wire:model="reference" placeholder="{{ __('sale.reference_note') }}">
                    @error('reference')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group card-form-pos-css">
                    <input type="text" id="productSearch" class="form-control ui-autocomplete-input" wire:model="productSearch" wire:keydown.enter="getProduct" placeholder="{{ __('sale.search_product') }}" autocomplete="off">
                </div>
            </div>
            <div id="print">
                <div class=" position-relative ">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar  pos-scroll-css">
                        <table id="posTable" class="table table-striped table-condensed table-hover  list-table">
                            <thead>
                            <tr class="success">
                                <th>Product</th>
                                <th class="pos-tr-th-css">{{__('sale.price')}}</th>
                                <th class="pos-tr-th-css">{{__('sale.tax')}}</th>
                                <th class="pos-tr-th-cssone">{{__('sale.qty')}}</th>
                                <th class="pos-tr-th-csstwo">{{__('sale.subtotal')}}</th>
                                <th wire:click.prevent="delAllItem()" class="pos-th-i"><i class="fas fa-trash"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!blank($carts))
                                @foreach($carts as $cart)
                                 <tr data-item-id="{{$loop->index}}" wire:key="Cart{{$loop->index}}">
                                <td>
                                    <button type="button"   wire:click.prevent="editCart({{$loop->index}})" class="btn bg-purple btn-block px-0 btn-small">
                                        <span class="sname" id=""> {{$cart['name']}} ({{$cart['barcode']}}) </span>
                                    </button>
                                </td>
                                <td class="text-right">
                                    <span class="text-right">{{currencyFormat($cart['price'])}}</span>
                                </td>
                                <td class="text-right">
                                    <span class="text-right">{{currencyFormat($cart['taxPrice'])}}</span>
                                </td>
                                <td>
                                    <input class="form-control text-center px-0" type="number" wire:model="carts.{{$loop->index}}.qty" wire:keyup="changeEvent({{$loop->index}})" value="{{$cart['qty']}}" data-item-id="{{$loop->index}}" >
                                </td>
                                <td class="text-right">
                                    <span class="text-right subtotal">
                                        @if((is_numeric($cart['qty']) && is_numeric($cart['subTotal'])))
                                                {{currencyFormat(($cart['price']+$cart['taxPrice']) * $cart['qty'])}}
                                            @endif
                                    </span>
                                </td>

                                <td class="text-center" wire:click.prevent="removeItem({{$loop->index}})">
                                    <i class="fa fa-trash pointer" title="Remove"></i>
                                </td>
                            </tr>
                                 @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pos-bottom">
                    <table class="table table-condensed totals pos-table-css">
                        <tbody>
                        <tr class="info">
                            <td width="25%">{{__('sale.total_items')}}</td>
                            <td class="text-right pos-tabel-th-css"><span id="count">{{number_format($totalItem)}} ({{$totalQty}})</span></td>
                            <td width="25%">{{__('sale.total')}}</td>
                            <td class="text-right" colspan="2"><span id="total">{{currencyFormat($totalAmount)}}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button"   wire:click.prevent="editOrderTax()" class="btn bg-purple btn-block px-0 btn-small pos-button-css">
                                    <span class="sname" id=""> {{ __('sale.order_tax') }} <i class="fa fa-edit"></i></span>
                                </button>
                            </td>
                            <td class="text-right" colspan="3"><span id="taxTotal">{{currencyFormat($OrdertaxPrice)}}</span></td>

                        </tr>
                        <tr class="success">
                            <td colspan="2" class="pos-total"> {{ __('sale.total_payable') }}
                                <a role="button" data-toggle="modal" data-target="#noteModal">
                                    <i class="fa fa-comment"></i>
                                </a>
                            </td>
                            <td class="text-right pos-total" colspan="2" ><span id="total-payable">{{currencyFormat($totalPayAmount)}}</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-12 text-center">
                        <div class="row justify-content-center pos-row-css">
                            <div class="col-4 col-sm-4 col-md-4 px-0 py-0">
                                <div class="btn-group-vertical btn-block">
                                    <button type="button" class="btn btn-danger btn-block px-0 pos-cancel-css" id="cancel-order"  wire:click.prevent="cancelOrder">{{ __('sale.cancel') }}</button>
                                </div>

                            </div>
                            <div class="col-4 col-sm-4 col-md-4 pos-col-css">
                                <div class="btn-group-vertical btn-block">
                                    <button type="button" class="btn bg-info btn-block px-0" id="print_order" wire:click.prevent="printOrder()">{{ __('sale.print_order') }}</button>
                                    <button type="button" class="btn bg-navy btn-block px-0" id="print_bill" wire:click.prevent="printOrderBill()">{{ __('sale.print_bill') }}</button>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4 pos-col-md-css">
                                <button type="button" class="btn btn-primary btn-block px-0 pos-cancel-css" id="payment" wire:click.prevent="paymentModal">{{ __('sale.payment') }}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

</div>

