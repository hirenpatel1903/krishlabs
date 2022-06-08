<?php

namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
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
                $validator->errors()->add('name', 'The unit  name already exists.');
            }

        });
    }

    private function unitNameUniqueCheck()
    {
        $id            = $this->unit;
        $queryArray['name']          = request('name');
        $queryArray['shop_id'] = request('shop_id');

        $units = Unit::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($units)) {
            return false;
        }
        return true;
    }

}
