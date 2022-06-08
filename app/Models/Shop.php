<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Shop extends BaseModel implements HasMedia
{
    use WatchableTrait, HasMediaTrait;
    protected $table       = 'shops';
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

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('shops')) && file_exists(public_path($this->getFirstMediaUrl('shops')))) {
            return asset($this->getFirstMediaUrl('shops'));
        }
        return asset('assets/img/default/shop.png');
    }

    public function scopeShopowner($query)
    {
        if (isset(auth()->user()->roles) && auth()->user()->myrole != 1) {
            $query->where('user_id', auth()->id());
        }
    }

}
