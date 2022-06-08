<?php

namespace App\Http\Livewire\PosModel;

use App\Enums\Status;
use App\Enums\TaxType;
use App\Models\Tax;
use Livewire\Component;

class OrderTax extends Component
{
    public $taxs = [];
    public $taxID;

    protected $listeners = ['editOrderTax'];

    public function render()
    {
        $shopId = auth()->user()->shop->id ?? session()->get('shop_id');
        $this->taxs = Tax::where(['shop_id'=>$shopId,'status' => Status::ACTIVE])->get();
        return view('livewire.pos-model.order-tax');
    }

    public function editOrderTax($orderTax)
    {
        $this->dispatchBrowserEvent('OrderTax');
        $this->taxID = $orderTax;
    }

    public function UpdateOrderTax(){
        $this->emit('UpdateOrderTax',$this->taxID);
    }

    public function changeEventTax()
    {
       //
    }

}
