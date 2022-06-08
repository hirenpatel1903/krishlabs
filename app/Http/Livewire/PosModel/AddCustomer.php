<?php

namespace App\Http\Livewire\PosModel;

use App\Enums\UserStatus;
use App\Http\Services\DepositService;
use App\Models\Deposit;
use App\Models\User;
use App\Notifications\CustomerCreated;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use DNS2D;


class AddCustomer extends Component
{

    public $customer = [];
    protected $listeners = ['showCustomerModal'];

    protected function rules()
    {
            return [
                'customer.first_name' => 'required|string|max:50',
                'customer.last_name' => 'required|string|max:50',
                'customer.deposit_amount' => 'required|numeric',
                'customer.phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone,'
            ];
    }
    protected $messages = [
        'customer.deposit_amount.required' => 'The deposit amount  is required. ',
        'customer.first_name.required' => 'The first name is required. ',
        'customer.first_name.max' => 'The first name may not be greater than 50 characters. ',
        'customer.last_name.required' => 'The last name is required ',
        'customer.last_name.max' => 'The last name may not be greater than 50 characters. ',
        'customer.phone.required' => 'The phone is required. ',
        'customer.phone.unique' => 'The phone has already been taken. ',
        'customer.phone.regex' => 'The phone number format is invalid.',
    ];

    public function render()
    {
        return view('livewire.pos-model.add-customer');
    }

    public function showCustomerModal (){
        $this->dispatchBrowserEvent('customerModal');
    }

    private function resetInput()
    {
        $this->customer['first_name'] = null;
        $this->customer['last_name'] = null;
        $this->customer['phone'] = null;
        $this->customer['deposit_amount'] = null;
    }
    public function addStore(){

        $this->validate();
        $this->customer['username'] = $this->customer['first_name'];
        $this->customer['status'] = UserStatus::ACTIVE;
        $this->customer['password'] = '123456';

        $user = User::create(collect($this->customer)->except('deposit_amount')->toArray());
        $role = Role::find(2);
        $user->assignRole($role->name);

        $deposit = new Deposit;
        $deposit->user_id = $user->id;
        $deposit->amount = $this->customer['deposit_amount'];
        $deposit->save();

        $this->updateMode = false;
        $this->qrCode($user);


        $depositAmount = $deposit->amount;
        if(blank($depositAmount)) {
            $depositAmount = 0;
        }
        $depositService = app(DepositService::class)->depositAdjust( $user->id, $user->balance_id,$depositAmount);
        if(setting('twilio_disabled') || setting('wati_disabled')){
            try {
                $user->notify(new CustomerCreated($user));

            }catch (\Exception $exception){
                //
            }
        }
        $this->emit('getCustomer',$user->id);
        $this->resetInput();
        $this->dispatchBrowserEvent('customerModalHide');

    }

    public function qrCode($user){
        $folderPath = "images/";

        $qrCodeImage ='data:image/png;base64,' .DNS2D::getBarcodePNG((string)$user->id, 'QRCODE',20,20,array(1,1,1),true);

        $image_parts = explode(";base64,", $qrCodeImage);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);

        $url = public_path($file);
        $user->media()->delete();
        $user->addMediaFromUrl($url)->toMediaCollection('users');
        File::delete($url);
        return true;
    }

}
