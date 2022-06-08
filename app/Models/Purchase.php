<?php

namespace App\Models;

use Shipu\Watchable\Traits\WatchableTrait;

use DNS1D;
use DNS2D;
class Purchase extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'purchases';
    protected $guarded     = ['id'];
    protected $auditColumn = true;

    protected $fakeColumns = [];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }


    public function getBarcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS1D::getBarcodePNG('purchase-'.$this->id, 'C39+',1.3,90,array(10,10,10),true);
    }

    public function getQrcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS2D::getBarcodePNG('purchase-'.$this->id, 'QRCODE',6,5,array(1,1,1),true);
    }

    public function items()
    {
        return $this->hasMany(Purchaseitem::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

}
