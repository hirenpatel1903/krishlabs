<?php

namespace App\Models;

use Shipu\Watchable\Traits\WatchableTrait;

class Saleitem extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'sale_items';
    protected $guarded     = ['id'];
    protected $auditColumn = false;

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
    public function product_item()
    {
        return $this->belongsTo(ProductItem::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

}
