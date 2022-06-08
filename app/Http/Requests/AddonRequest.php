<?php

namespace App\Http\Requests;


use App\Libraries\FileLibrary;
use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
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
            'purchase_username' => ['nullable', 'string', 'max:200'],
            'purchase_code'     => ['nullable', 'string', 'max:255'],
            'addon_file'        => 'required|file|mimes:zip|max:307200'
        ];
    }
}
