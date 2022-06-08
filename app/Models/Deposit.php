<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends BaseModel
{
    protected $table       = 'deposits';
    protected $fillable    = ['user_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
