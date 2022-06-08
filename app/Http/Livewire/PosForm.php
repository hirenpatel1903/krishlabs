<?php

namespace App\Http\Livewire;

use App\Enums\Status;
use App\Enums\TaxType;
use App\Http\Services\PaymentTransactionService;
use App\Models\Product;
use App\Models\Purchaseitem;
use App\Models\Sale;
use App\Models\Saleitem;
use App\Models\Tax;
use App\Models\User;
use App\Notifications\SaleCreated;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class PosForm extends Component
{
    public $products = [];
    public $customer_id;
    public $customer;
    public $users = [];
    public $data = [];
    public $carts = [];
    public $product;
    public $shopId = 0;
    public $totalItem = 0;
    public $totalPayAmount = 0;
    public $totalAmount = 0;
    public $productSearch = '';
    public $reference =  '';
    public $totalQty = 0;
    public $taxPrice = 0;
    public $OrdertaxPrice = 0;
    public $orderTaxID;

    protected $listeners = ['getCustomer','getProductAdd','customerAddScan','UpdateCart','UpdateOrderTax','store'];


    public function render()
    {
        $this->shopId = auth()->user()->shop->id ?? session()->get('shop_id');
        $productArrayID = Purchaseitem::groupBy('product_id')->selectRaw('product_id')->get()->pluck('product_id')->toArray();
        $this->products  = Product::where(['status' => Status::ACTIVE,'shop_id'=>$this->shopId])->whereIn('id', $productArrayID)->get();
        $role            = Role::find(2);
        $this->users     = User::role($role->name)->latest()->get();
        return view('livewire.pos-form');
    }


    protected $rules = [
        'customer_id' => 'required|numeric',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function paymentModal(){
        $validatedData = $this->validate();
        if(blank($this->carts)){
            $this->dispatchBrowserEvent('actionError');

        }else{
            $this->emit('showPaymentModal',$this->totalQty,$this->totalPayAmount,$this->totalItem,$this->customer_id);
        }

    }
    public function store($credit_amount,$cash_amount,$description){
        $sale = new Sale;
        $sale->reference = strip_tags($this->reference);
        $sale->sale_no = random_int(1000, 9999);
        $sale->user_id = $this->customer_id;
        $sale->shop_id = $this->shopId;
        $sale->sub_total = $this->totalAmount;
        $sale->total = $this->totalPayAmount;
        $sale->tax_amount = $this->OrdertaxPrice;
        $sale->tax_id = $this->orderTaxID;
        $sale->paid_amount = $credit_amount + $cash_amount;
        $sale->paid_credit_amount = $credit_amount;
        $sale->paid_cash_amount = $cash_amount;
        $sale->description = $description;
        $sale->save();

        foreach ($this->carts as $cart){
            $saleItem = new Saleitem;
            $saleItem->sale_id = $sale->id;
            $saleItem->shop_id = $this->shopId;
            $saleItem->product_id = $cart['itemID'];
            $saleItem->product_item_id = $cart['variationID'];
            $saleItem->unit_price = $cart['price'];
            $saleItem->tax_amount = $cart['taxPrice'];
            $saleItem->tax_id = $cart['taxID'];
            $saleItem->quantity = $cart['qty'];
            $saleItem->total_amount = ($cart['price']+$cart['taxPrice'])*$cart['qty'];
            $saleItem->save();

        }
        $transaction = app(PaymentTransactionService::class)->completed($sale->id, $sale->user_id);
        if(setting('twilio_disabled') || setting('wati_disabled')){
            try {
                $sale->user->notify(new SaleCreated($sale));

            }catch (\Exception $exception){
                //
            }
        }
        $this->dispatchBrowserEvent('paymentModalHide');

        session()->flash('success','The Data Insert Successfully.');
        return redirect(route('admin.pos.view',$sale));
    }

    public function printOrder(){
        $this->emit('showPrintOrderModal',$this->carts,$this->totalQty,$this->totalAmount,$this->totalItem,$this->customer_id,$this->reference);
    }
    public function printOrderBill(){
        $this->emit('showPrintOrderBillModal',$this->carts,$this->totalQty,$this->totalAmount,$this->totalItem,$this->customer_id,$this->reference);
    }

    public function getCustomer($userID){
        $this->customer_id = $userID;
    }

    public function getProduct(){
        $productArrayID = Purchaseitem::groupBy('product_id')->selectRaw('product_id')->get()->pluck('product_id')->toArray();
        $product = Product::query()
            ->where('name', 'LIKE', "%{$this->productSearch}%")
            ->orWhere('barcode', 'LIKE', "%{$this->productSearch}%")
            ->where('shop_id',$this->shopId)
            ->whereIn('id', $productArrayID)
            ->first();

        if(!blank($product)){
            $this->addCart($product->id);
        }
        $this->productSearch = null;
    }

    public function getProductAdd($payload){
        $productArrayID = Purchaseitem::groupBy('product_id')->selectRaw('product_id')->get()->pluck('product_id')->toArray();
        $product = Product::query()
            ->where('name', 'LIKE', "%{$payload['name']}%")
            ->orWhere('barcode', 'LIKE', "%{$payload['name']}%")
            ->where('shop_id',$this->shopId)
            ->whereIn('id', $productArrayID)

            ->first();

        if(!blank($product)){
            $this->addCart($product->id);
        }
        $this->productSearch = null;
    }

    public function customerAddScan($payload){
        $this->customer_id = $payload['id'];
    }

    public function addCart($id)
    {
        $purchaseQuintity = Purchaseitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
        $saleQuintity     = Saleitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');

        $TotalQuantity = (isset($purchaseQuintity[$id]) ? $purchaseQuintity[$id]->quantity: 0) - (isset($saleQuintity[$id]) ? $saleQuintity[$id]->quantity: 0);
        if($TotalQuantity!=0){
            $product = Product::findOrFail($id);
            $item=true;
            foreach ($this->carts as $key=>$cart){
                if($cart['itemID'] == $id){
                    if( $TotalQuantity>$this->carts[$key]['qty']){
                        $this->carts[$key]['qty'] +=1;
                        $item= false;
                    }else{
                        $item= false;
                        $this->dispatchBrowserEvent('showToast');
                    }
                }
            }
            if($item){

                $tax = Tax::where(['id'=>$product->tax_id,'status' => Status::ACTIVE])->first();
                if(!blank($tax)){
                    if ($tax->type == TaxType::FIXED){
                        $this->taxPrice = $tax->tax_rate;
                    }else{
                        $this->taxPrice = ($product->price + (!blank($product->variations) ? $product->variations[0]->price : 0)) * ($tax->tax_rate / 100);
                    }
                }

                array_push($this->carts,
                    [
                        'itemID' => $product->id,
                        'taxID' => $product->tax_id,
                        'name' => $product->name,
                        'price' => $product->price + (!blank($product->variations) ? $product->variations[0]->price : 0),
                        'qty' => 1,
                        'taxPrice' => $this->taxPrice,
                        'subTotal' => $product->price + (!blank($product->variations) ? $product->variations[0]->price : 0),
                        'productType' => $product->type,
                        'barcode' => $product->barcode.(!blank($product->variations) ? '-'.$product->variations[0]->id : ''),
                        'variation' => !blank($product->variations) ? $product->variations[0]->name : null,
                        'variationID' => !blank($product->variations) ? $product->variations[0]->id : null,
                        'variation_price' => !blank($product->variations) ? $product->variations[0]->price : 0,
                    ]);
            }
            $this->totalCartAmount();
        }else{
            $this->dispatchBrowserEvent('showToast');
        }


    }

    public function addCustomer(){
        $this->emit('showCustomerModal');
    }

    public function changeEvent($index)
    {

        $purchaseQuintity = Purchaseitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
        $saleQuintity     = Saleitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');

        $TotalQuantity = (isset($purchaseQuintity[$this->carts[$index]['itemID']]) ? $purchaseQuintity[$this->carts[$index]['itemID']]->quantity: 0) - (isset($saleQuintity[$this->carts[$index]['itemID']]) ? $saleQuintity[$this->carts[$index]['itemID']]->quantity: 0);

        if(!is_numeric($this->carts[$index]['qty']) || $this->carts[$index]['qty']==0)
        {
            $this->carts[$index]['qty'] = 1;
        }
        if ($TotalQuantity >= $this->carts[$index]['qty']){
            $this->totalCartAmount();
        }else{
            $this->dispatchBrowserEvent('showToast');
            $this->carts[$index]['qty'] = 1;
            $this->totalCartAmount();
        }

    }

    public function totalCartAmount(){
        if(!blank($this->carts)){

            $this->OrderTaxAmount = 0;
            $this->totalItem = 0;
            $this->totalAmount =0;
            $this->totalPayAmount =0;
            $this->totalQty = 0;
            foreach ($this->carts as $cart){
                $this->totalItem += 1;
                $this->totalQty +=$cart['qty'];
                $this->totalAmount += ($cart['price']+$cart['taxPrice'])*$cart['qty'];
            }

            $tax = Tax::where(['id'=>$this->orderTaxID,'status' => Status::ACTIVE])->first();
            if(!blank($tax)){
                if ($tax->type == TaxType::FIXED){
                    $this->OrdertaxPrice = $tax->tax_rate;
                }else{
                    $this->OrdertaxPrice = $this->totalAmount * ($tax->tax_rate / 100);
                }
            }
            $this->totalPayAmount =$this->totalAmount+$this->OrdertaxPrice;
        }
    }

    public function removeItem($index)
    {
        unset($this->carts[$index]);

        $this->carts = array_values($this->carts);
    }

    public function delAllItem()
    {
        $this->carts =[];
    }

    public function editCart($index){
        $this->catItemName = $this->carts[$index]['name'];
        $this->emit('editCart',$this->carts[$index],$index);

    }

    public function editOrderTax(){
        $this->emit('editOrderTax',$this->orderTaxID);

    }
    public function UpdateOrderTax($orderTax){
        $this->orderTaxID =$orderTax;
        $this->totalCartAmount();
        $this->dispatchBrowserEvent('close');

    }
    public function UpdateCart($item,$index){
        $this->dispatchBrowserEvent('close');

        $purchaseQuintity = Purchaseitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
        $saleQuintity     = Saleitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');

        $TotalQuantity = (isset($purchaseQuintity[$this->carts[$index]['itemID']]) ? $purchaseQuintity[$this->carts[$index]['itemID']]->quantity: 0) - (isset($saleQuintity[$this->carts[$index]['itemID']]) ? $saleQuintity[$this->carts[$index]['itemID']]->quantity: 0);

        if ($TotalQuantity>= $item['qty']){
            $this->carts[$index]['price'] = $item['price'];
            $this->carts[$index]['taxPrice'] = $item['taxPrice'];
            $this->carts[$index]['qty'] = $item['qty'];
            $this->carts[$index]['barcode'] = $item['barcode'];
            $this->carts[$index]['variationID'] = $item['variationID'];
            $this->carts[$index]['subTotal'] = ($item['price']+$item['taxPrice'])*$item['qty'];
            $this->totalCartAmount();
        }else{
            $this->dispatchBrowserEvent('showToast');
            $this->carts[$index]['qty'] = 1;
            $this->totalCartAmount();
        }

    }

    public function cancelOrder()
    {
        $this->dispatchBrowserEvent('cancelModal');
    }

}

