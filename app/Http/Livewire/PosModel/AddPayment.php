<?php

namespace App\Http\Livewire\PosModel;

use App\Models\User;
use Livewire\Component;

class AddPayment extends Component
{
    public $credit_amount = 0;
    public $cash_paying = 0;
    public $cash_amount = 0;
    public $description = '';
    public $totalAmount = 0;
    public $totalItem = 0;
    public $totalQty = 0;
    public $customerBalance = 0;
    protected $listeners = ['showPaymentModal'];
    public function render()
    {
        return view('livewire.pos-model.add-payment');
    }

    public function showPaymentModal($totalQty,$totalAmount,$totalItem,$customerID){
        $this->dispatchBrowserEvent('paymentModal');

        $customer = User::where('id',$customerID)->first();

        $this->totalQty = $totalQty;
        $this->totalItem = $totalItem;
        $this->totalAmount = $totalAmount;
        $this->customerBalance = $customer->balance->balance;
        if($this->customerBalance !=0 && $this->customerBalance>$this->totalAmount){
            $this->credit_amount = $this->totalAmount;
            $this->cash_amount = 0;
            $this->cash_paying = 0;
        } elseif ($this->customerBalance !=0 && $this->customerBalance<=$this->totalAmount){
            $this->credit_amount = $this->customerBalance;
            $this->cash_amount = $this->totalAmount - $this->customerBalance;
            $this->cash_paying = $this->totalAmount - $this->customerBalance;
        }else{
            $this->cash_amount = $this->totalAmount;
            $this->cash_paying = $this->totalAmount;
            $this->credit_amount =0;
        }
    }

    protected $rules = [
        'credit_amount' => 'required|numeric',
        'cash_amount' => 'required|numeric',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store(){
        $this->emit('store',$this->credit_amount,$this->cash_amount,$this->description);

    }
}
