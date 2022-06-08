<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->shop) {
            $email    = ['required', 'email', 'string', Rule::unique("users", "email")->ignore($this->shop->user->id)];
            $phone    = ['required','string', 'max:40', Rule::unique("users", "phone")->ignore($this->shop->user->id)];
            $username = ['required', 'string', Rule::unique("users", "username")->ignore($this->shop->user->id)];
        } else {
            $email    = ['required', 'email', 'string', 'unique:users,email'];
            $phone    = ['required','string','max:40', 'unique:users,phone'];
            $username = ['required', 'string', 'unique:users,username'];
        }

        return [
            'name'            => ['required', 'string', Rule::unique("shops", "name")->ignore($this->shop), 'max:191'],
            'description'     => ['nullable', 'string'],
            'shopaddress'     => ['required', 'max:200'],
            'status'          => ['required', 'numeric'],
            'first_name'      => ['required', 'string'],
            'last_name'       => ['required', 'string'],
            'email'           => $email,
            'password'        => [$this->shop ? 'nullable' : 'required', 'min:6'],
            'image'           => 'image|mimes:jpeg,png,jpg|max:5098',
            'username'        => request('username') ? $username : ['nullable'],
            'phone'           => $phone,
            'address'         => ['required', 'max:200'],
            'userstatus'      => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name'            => trans('validation.attributes.name'),
            'description'     => trans('validation.attributes.description'),
            'delivery_charge' => trans('validation.attributes.delivery_charge'),
            'shopaddress'     => trans('validation.attributes.address'),
            'status'          => trans('validation.attributes.status'),
            'first_name'      => trans('validation.attributes.first_name'),
            'last_name'       => trans('validation.attributes.last_name'),
            'email'           => trans('validation.attributes.email'),
            'username'        => trans('validation.attributes.username'),
            'phone'           => trans('validation.attributes.phone'),
            'address'         => trans('validation.attributes.address'),
            'image'           => trans('validation.attributes.image'),
        ];
    }
}
