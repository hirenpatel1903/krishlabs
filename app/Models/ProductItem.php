<?php

namespace App\Models;

use DNS1D;
use DNS2D;

class ProductItem extends BaseModel
{

    protected $table       = 'product_items';
    protected $guarded     = ['id'];

    protected $fakeColumns = [];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getBarcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS1D::getBarcodePNG($this->product->barcode.'-'.$this->id, $this->product->barcode_type,1,50,array(10,10,10),true);
    }

    public function getQrcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS2D::getBarcodePNG($this->product->barcode.'-'.$this->id, 'QRCODE',20,20,array(1,1,1),true);
    }
}
