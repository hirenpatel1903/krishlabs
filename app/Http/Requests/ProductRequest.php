<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        if (!blank(request()->variation)) request()->session()->flash('variation', array_keys(request()->variation));

        return [
            'categories.*' => 'required',
            'name'         => ['required', 'string', 'max:255'],
            'description'  => 'nullable|string|max:1000',
            'cost'         => ['required', new IniAmount],
            'price'        => ['required', new IniAmount],
            'shop_id'      => 'required|numeric',
            'unit'         => 'required|numeric',
            'barcode'      => 'required|string|max:11',
            'status'       => 'required|numeric',
            'image'        => 'image|mimes:jpeg,png,jpg|max:5098',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => trans('validation.attributes.name'),
            'image'       => trans('validation.attributes.image'),
            'location_id' => trans('validation.attributes.location_id'),
            'status'      => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->productNameUniqueCheck()) {
                $validator->errors()->add('name', 'The product  name already exists.');
            }

        });
    }

    private function productNameUniqueCheck()
    {
        $id            = $this->product;
        $queryArray['name']          = request('name');
        $queryArray['shop_id'] = request('shop_id');

        $products = Product::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($products)) {
            return false;
        }
        return true;
    }
}
