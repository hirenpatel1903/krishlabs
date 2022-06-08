<?php

namespace App\Models;

use DNS1D;
use DNS2D;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Product extends BaseModel implements HasMedia
{
    use  WatchableTrait, HasMediaTrait;

    protected $table       = 'products';
    protected $guarded     = ['id'];
    protected $auditColumn = true;

    protected $fakeColumns = [];

    public function getRouteKeyName()
    {
        return request()->segment(1) === 'admin' ? 'id' : 'slug';
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function scopeFromCategory($query, Category $category)
    {
        return $query->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        });
    }

    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('products')) && file_exists(public_path($this->getFirstMediaUrl('products')))) {
            return asset($this->getFirstMediaUrl('products'));
        }
        return asset('assets/img/default/product.png');
    }


    public function getBarcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS1D::getBarcodePNG($this->barcode, $this->barcode_type,1,50,array(10,10,10),true);
    }

    public function getQrcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS2D::getBarcodePNG($this->barcode, 'QRCODE',20,20,array(1,1,1),true);
    }




    public function variations()
    {
        return $this->hasMany(ProductItem::class);
    }


}
