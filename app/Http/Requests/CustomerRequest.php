<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'numeric','regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', Rule::unique("users", "phone")],
            'deposit_amount' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => trans('levels.first_name'),
            'last_name' => trans('levels.last_name'),
            'phone' => trans('levels.phone'),
        ];
    }

}
