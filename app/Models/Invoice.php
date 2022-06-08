<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\User;

class Invoice extends BaseModel
{

    protected $auditColumn = true;
    protected $primaryKey = 'id'; // or null

    protected $casts = [
        'meta' => 'array',
        'id' => 'id'
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)
            ->where('source_balance_id', auth()->user()->id)
            ->where('type', TransactionType::PAYMENT);
    }
    
    

}
