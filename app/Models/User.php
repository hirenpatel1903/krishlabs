<?php

namespace App\Models;

use App\Enums\BalanceType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shipu\Watchable\Traits\HasModelEvents;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait, HasModelEvents, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'username', 'password', 'phone', 'address', 'roles', 'device_token', 'status', 'applied',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['myrole'];


    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }


    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('user')) && file_exists(public_path($this->getFirstMediaUrl('user')))) {
            return asset($this->getFirstMediaUrl('user'));
        }
        return asset('assets/img/default/user.png');
    }

    public function getQrcodeAttribute()
    {
        if (!empty($this->getFirstMediaUrl('users')) && file_exists(public_path($this->getFirstMediaUrl('users')))) {
            return asset($this->getFirstMediaUrl('users'));
        }
        return null;
    }

    public function OnModelCreating()
    {
        $balance               = new Balance();
        $balance->name         = $this->username;
        $balance->type         = BalanceType::REGULAR;
        $balance->balance      = 0;
        $balance->creator_type = 1;
        $balance->creator_id   = 1;
        $balance->editor_type  = 1;
        $balance->editor_id    = 1;
        $balance->save();

        $this->balance_id = $balance->id;
    }


    public function getMyroleAttribute()
    {
        return $this->roles->pluck('id', 'id')->first();
    }

    public function getrole()
    {
        return $this->hasOne(Role::class, 'id', 'myrole');
    }


    public function getMyStatusAttribute()
    {
        return trans('user_statuses.' . $this->status);
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->phone;
    }
}
