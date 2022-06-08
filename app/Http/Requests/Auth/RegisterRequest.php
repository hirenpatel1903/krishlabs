<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        return [
            'email'                 => 'required|email|unique:users,email',
            'username'              => request('username') ? 'required|unique:users,username' : 'nullable',
            'name'                  => 'required|max:40',
            'phone'                 => 'required|max:40',
            'roles'                 => 'nullable|numeric',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}
