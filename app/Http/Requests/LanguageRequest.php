<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class LanguageRequest extends FormRequest
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
            'name'   => 'required|string|max:255'.Rule::unique("language","name")->ignore($this->language),
            'code'   => 'required|string|max:255'.Rule::unique("language","code")->ignore($this->language),
            'status' => 'required|numeric',
        ];
    }
}
