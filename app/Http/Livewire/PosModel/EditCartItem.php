<?php

namespace App\Http\Livewire\PosModel;

use App\Enums\Status;
use App\Enums\TaxType;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Tax;
use Livewire\Component;

class EditCartItem extends Component
{
    public $itemIndex;
    public $itemID;
    public $catItemName = '';
    public $barcode = '';
    public $cartItemPrice = 0;
    public $taxPrice = 0;
    public $cartItemQty = 0;
    public $taxID;
    public $variantID;
    public $variantName = '';
    public $variations = [];
    public $taxs = [];

    protected $listeners = ['editCart'];


    public function render()
    {
        $shopId = auth()->user()->shop->id ?? session()->get('shop_id');
        $this->taxs = Tax::where(['shop_id'=>$shopId,'status' => Status::ACTIVE])->get();
        return view('livewire.pos-model.edit-cart-item');
    }

    public function editCart($cartItem,$index)
    {
        $this->dispatchBrowserEvent('show');
        $this->variations  = ProductItem::where(['product_id'=>$cartItem['itemID']])->latest()->get();

        $this->itemIndex = $index;
        $this->itemID = $cartItem['itemID'];
        $this->catItemName = $cartItem['name'];
        $this->cartItemPrice = $cartItem['price'];
        $this->cartItemQty = $cartItem['qty'];
        $this->variantID = $cartItem['variationID'];
        $this->taxID = $cartItem['taxID'];
        $this->barcode = $cartItem['barcode'];

        $tax = Tax::where(['id'=>$this->taxID,'status' => Status::ACTIVE])->first();
        if(!blank($tax)){
            if ($tax->type == TaxType::FIXED){
                $this->taxPrice = $tax->tax_rate;
            }else{
                $this->taxPrice = $this->cartItemPrice * ($tax->tax_rate / 100);
            }
        }

    }

    public function UpdateCart(){
        $product = Product::findOrFail($this->itemID);
        if($this->variantID){
            $variation  = ProductItem::findOrFail($this->variantID);
            $item['price'] =$this->cartItemPrice;
            $item['qty'] =$this->cartItemQty;
            $item['variationID'] =$this->variantID;
            $item['barcode'] =$product->barcode.'-'.$variation->id;
            $item['taxID'] =$this->taxID;
            $item['taxPrice'] = $this->taxPrice;

        }else{
            $item['price'] =$this->cartItemPrice;
            $item['qty'] =$this->cartItemQty;
            $item['barcode'] =$this->barcode;
            $item['variationID'] =$this->variantID;
            $item['taxID'] =$this->taxID;
            $item['taxPrice'] = $this->taxPrice;
        }

        $this->emit('UpdateCart',$item,$this->itemIndex);
    }

    public function changeEvent()
    {
        $product = Product::findOrFail($this->itemID);
        $variation  = ProductItem::findOrFail($this->variantID);
        $this->cartItemPrice = $product->price  + $variation->price;
    }
    public function changeEventTax()
    {
        $tax = Tax::where(['id'=>$this->taxID,'status' => Status::ACTIVE])->first();
        if(!blank($tax)){
            if ($tax->type == TaxType::FIXED){
                $this->taxPrice = $tax->tax_rate;
            }else{
                $this->taxPrice =  $this->cartItemPrice * ($tax->tax_rate / 100);
            }
        }
    }
}
