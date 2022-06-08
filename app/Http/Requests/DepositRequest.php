<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepositRequest extends FormRequest
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
            'user_id'        => ['required', 'numeric'],
            'amount'         => ['required', 'numeric','regex:/^\d+(\.\d{1,2})?$/',],
        ];
    }

    public function attributes()
    {
        return [
            'amount'       => trans('validation.attributes.amount'),
        ];
    }

}
