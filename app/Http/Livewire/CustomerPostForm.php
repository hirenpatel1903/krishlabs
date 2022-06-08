<?php

namespace App\Http\Livewire;

use App\Enums\UserStatus;
use App\Http\Services\DepositService;
use App\Models\Deposit;
use App\Models\User;
use App\Notifications\CustomerCreated;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use DNS2D;

class CustomerPostForm extends Component
{
    public $customer = [];
    public $updateMode = false;
    public $user;

    protected function rules()
    {
        if($this->updateMode){
            return [
                'customer.first_name' => 'required|string|max:50',
                'customer.last_name' => 'required|string|max:50',
                'customer.phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone,' .optional($this->user)->id
            ];
        }else{
            return [
                'customer.first_name' => 'required|string|max:50',
                'customer.last_name' => 'required|string|max:50',
                'customer.deposit_amount' => 'required|numeric',
                'customer.phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone,' .optional($this->user)->id
            ];
        }

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
        'customer.phone.min' => 'The phone must be at least 10 characters.',
    ];

    public function render()
    {
        return view('livewire.customer-post-form');
    }

    private function resetInput()
    {
        $this->customer['first_name'] = null;
        $this->customer['last_name'] = null;
        $this->customer['phone'] = null;
        $this->customer['deposit_amount'] = null;
    }
    public function mount(User $user) {
        if($user->id){
            $this->updateMode = true;
            $this->user = $user;
            $this->customer['first_name'] = $user->first_name;
            $this->customer['last_name'] = $user->last_name;
            $this->customer['phone'] = $user->phone;
        }
    }

    public function store(){
        $this->validate();
        $this->customer['username'] = $this->customer['first_name'];
        $this->customer['status'] = UserStatus::ACTIVE;
        $this->customer['password'] = Hash::make('123456');

        $user = User::create(collect($this->customer)->except('deposit_amount')->toArray());
        $role = Role::find(2);
        $user->assignRole($role->name);

        $deposit = new Deposit;
        $deposit->user_id = $user->id;
        $deposit->amount = $this->customer['deposit_amount'];
        $deposit->save();

        $this->resetInput();

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
        session()->flash('success','The Data Inserted Successfully.');
        return redirect(route('admin.customers.index'));

    }

    public function update(User $user)
    {
        $this->validate();
        $role = Role::find(2);
        $user = User::role($role->name)->findOrFail($user->id);

        $user->update(collect($this->customer)->toArray());

        $this->resetInput();
        $this->updateMode = false;

        session()->flash('success','The Data Updated Successfully.');
        return redirect(route('admin.customers.index'));
    }


    public function qrCode($user){
        $folderPath = "images/";

        $qrCodeImage ='data:image/png;base64,' .DNS2D::getBarcodePNG('customer-'.(string)$user->id, 'QRCODE',20,20,array(1,1,1),true);

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
