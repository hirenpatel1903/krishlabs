<?php

namespace App\Http\Requests;

use App\Models\Tax;
use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaxRequest extends FormRequest
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
            'name'   => ['required', 'string', 'max:255'],
            'code'   => ['required', 'string', 'max:255'],
            'tax_rate'  => ['required', new IniAmount],
            'type'   => ['required', 'numeric'],
            'status' => ['required', 'numeric'],
            'shop_id'      => 'required|numeric',

        ];
    }

    public function attributes()
    {
        return [
            'name'   => trans('validation.attributes.name'),
            'status' => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->unitNameUniqueCheck()) {
                $validator->errors()->add('name', 'The tax  name already exists.');
            }

        });
    }

    private function unitNameUniqueCheck()
    {
        $id            = $this->tax;
        $queryArray['name']          = request('name');
        $queryArray['shop_id'] = request('shop_id');

        $units = Tax::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($units)) {
            return false;
        }
        return true;
    }

}
