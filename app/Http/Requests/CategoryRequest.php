<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'numeric'],
            'shop_id'      => 'required|numeric',
            'image'       => 'image|mimes:jpeg,png,jpg|max:5098'
        ];
    }

    public function attributes()
    {
        return [
            'name'        => trans('validation.attributes.name'),
            'image'       => trans('validation.attributes.image'),
            'description' => trans('validation.attributes.description'),
            'status'      => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->categoryNameUniqueCheck()) {
                $validator->errors()->add('name', 'The category  name already exists.');
            }

        });
    }

    private function categoryNameUniqueCheck()
    {
        $id            = $this->category;
        $queryArray['name']          = request('name');
        $queryArray['shop_id'] = request('shop_id');

        $categories = Category::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($categories)) {
            return false;
        }
        return true;
    }

}
