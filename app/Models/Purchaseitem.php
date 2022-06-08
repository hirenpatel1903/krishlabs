<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Purchaseitem extends Model
{

    protected $table       = 'purchase_items';
    protected $guarded     = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_item()
    {
        return $this->belongsTo(ProductItem::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

}
