<?php

namespace App\Http\Livewire\PosModel;

use App\Models\User;
use Livewire\Component;

class PrintOrder extends Component
{
    public $carts = [];
    public $totalQty = 0;
    public $totalAmount = 0;
    public $totalItem = 0;
    public $customer;
    public $reference;
    public $listeners = ['showPrintOrderModal','showPrintOrderBillModal'];
    public function render()
    {
        return view('livewire.pos-model.print-order');
    }

    public function showPrintOrderModal ($carts,$totalQty,$totalAmount,$totalItem,$customerID,$reference){
        $this->dispatchBrowserEvent('printOrderModal');

        if($customerID){
            $this->customer = User::find($customerID);
        }
        $this->carts = $carts;
        $this->totalQty = $totalQty;
        $this->totalItem = $totalItem;
        $this->totalAmount = $totalAmount;
        $this->reference = $reference;
    }
    public function showPrintOrderBillModal ($carts,$totalQty,$totalAmount,$totalItem,$customerID,$reference){
        if($customerID){
            $this->customer = User::find($customerID);
        }
        $this->carts = $carts;
        $this->totalQty = $totalQty;
        $this->totalItem = $totalItem;
        $this->totalAmount = $totalAmount;
        $this->reference = $reference;
        $this->dispatchBrowserEvent('printBillModal');
    }

}
