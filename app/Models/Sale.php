<?php

namespace App\Models;

use Shipu\Watchable\Traits\WatchableTrait;
use DNS1D;
use DNS2D;

class Sale extends BaseModel
{

    use WatchableTrait;

    protected $table       = 'sales';
    protected $guarded     = ['id'];
    protected $auditColumn = true;
    public $timestamps = true;


    protected $fakeColumns = [];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function items()
    {
        return $this->hasMany(Saleitem::class);
    }

    public function getBarcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS1D::getBarcodePNG('POS-'.$this->sale_no, 'C39+',1.3,100,array(10,10,10),true);
    }

    public function getQrcodePrintAttribute()
    {
        return 'data:image/png;base64,' .DNS2D::getBarcodePNG('POS-'.$this->sale_no, 'QRCODE',6,5,array(1,1,1),true);
    }

    public function getGenerateSaleMsgAttribute()
    {
        $title = 'New order #'.$this->sale_no."\n\n";
        $shop = 'Shop: '.$this->shop->name."\n";
        $shop_phone = 'Phone: '.$this->shop->phone."\n\n";
        $customer = 'Customer: '.$this->user->name."\n";
        $customer_credit = 'Customer Credit: '.$this->user->balance->balance."\n\n";
        $items = '*Items:*'."\n";
        foreach ($this->items as $item){
            if(optional($item->product)->type ==10){
                $name =optional($item->product)->barcode.'-'.$item->product_item->id.'-'.optional($item->product)->name.  '('.$item->product_item->name.')';
            } else{
                $name= optional($item->product)->barcode.'-'.optional($item->product)->name;
            }
            $items .= $item->quantity.' x '.$name."\n";
        }
        $items .= "\n";

        $final  = $title.$shop.$shop_phone.$customer.$customer_credit.$items;
        $final .= '*Total*: '.currencyFormat($this->total).' '."\n\n";
        $final .= '*Paid*: '.currencyFormat($this->paid_amount).' '."\n\n";
        $final .= '*Cash*: '.currencyFormat($this->paid_cash_amount).' '."\n\n";
        $final .= '*Credit*: '.currencyFormat($this->paid_credit_amount).' '."\n\n";
        $final .= '*Note:*'."\n"."$this->description"."\n\n";

        return urlencode($final);
    }

}
