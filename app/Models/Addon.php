<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Addon extends Model implements HasMedia
{

    use HasMediaTrait;

    protected $table       = 'addons';
    protected $fillable    = ['title', 'slug', 'description','version','date','author','files','purchase_username', 'purchase_code','status'];

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('addon'))) {
            return asset($this->getFirstMediaUrl('addon'));
        }
        return asset('assets/images/logo.png');
    }

}
