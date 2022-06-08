<?php

namespace App\Models;

use App\Models\BaseModel;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Category extends BaseModel implements HasMedia
{
    use  WatchableTrait, HasMediaTrait;

    protected $table       = 'categories';
    protected $auditColumn = true;
    protected $fillable    = ['name', 'slug', 'description', 'status'];


    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('categories')) && file_exists(public_path($this->getFirstMediaUrl('categories')))) {
            return asset($this->getFirstMediaUrl('categories'));
        }
        return asset('assets/img/default/category.png');
    }
}
