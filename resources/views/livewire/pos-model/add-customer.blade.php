<div>
    <!-- add customers modal  -->
    <div wire:ignore.self class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-primary">
                    <h4 class="modal-title">{{ __('sale.add_customer') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="#" method="post">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="first_name">{{ __('sale.customer_first_name') }}</label> <span class="text-danger">*</span>
                                <input wire:model="customer.first_name" type="text" name="first_name" id="first_name"  class="form-control @error('customer.first_name') is-invalid @enderror">
                                @error('customer.first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="last_name">{{ __('sale.customer_last_name') }}</label> <span class="text-danger">*</span>
                                <input wire:model="customer.last_name" type="text" name="last_name" id="last_name"  class="form-control @error('customer.last_name') is-invalid @enderror">
                                @error('customer.last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="phone">{{ __('sale.customer_phone') }}</label> <span class="text-danger">*( {{__('sale.country_code')}} )</span>
                                <input wire:model="customer.phone" type="text" name="phone" id="phone"  class="form-control @error('customer.phone') is-invalid @enderror">
                                @error('customer.phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="deposit_amount">{{ __('sale.customer_deposit_amount') }}</label> <span class="text-danger">*</span>
                                    <input wire:model="customer.deposit_amount" type="number" name="deposit_amount" id="deposit_amount"  class="form-control @error('customer.deposit_amount') is-invalid @enderror">
                                    @error('customer.deposit_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{ __('sale.close') }} </button>
                        <button type="button" wire:click.prevent="addStore()"  class="btn btn-primary" id="add_customer"> {{ __('sale.add_customer') }} </button>
                    </div> <!-- modal footer-->
                </form>
            </div>
        </div>
    </div>
    <!-- end customers modal here -->
</div>
