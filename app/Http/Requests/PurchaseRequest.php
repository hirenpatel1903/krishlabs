<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{
    protected $id;

    public function __construct($id = 0)
    {
        parent::__construct();
        $this->id = $id;
    }
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
            'shop_id'  => ['required', 'numeric'],
            'purchases_no'  => ['required', 'string'],
            'description'  => ['nullable','string'],
            'productitem' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'shop_id'  => 'Shop Id',
            'purchases_no'  => 'Purchases No',
            'productitem' => 'Product Item',
        ];
    }
}
