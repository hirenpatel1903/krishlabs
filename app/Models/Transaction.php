<?php

namespace App\Models;

use App\Enums\LedgerType;
use App\Enums\TransactionType;
use App\Models\User;
use Shipu\Watchable\Traits\HasModelEvents;

class Transaction extends BaseModel
{

    protected $fillable = [
        'type',
        'source_balance_id',
        'destination_balance_id',
        'amount',
        'status',
        'creator_type',
        'creator_id',
        'editor_type',
        'editor_id',
        'meta',
        'invoice_id',
        'sale_id',
        'shop_id',
        'user_id'
    ];
    protected $auditColumn = true;
    protected $fakeColumns = [];
    use HasModelEvents;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $casts = [
        'meta' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function destinationUser()
    {
        return $this->belongsTo(User::class, 'destination_balance_id', 'balance_id');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_balance_id', 'balance_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'meta->shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'meta->user_id');
    }

    public function sales()
    {
        return $this->belongsTo(Sale::class, 'meta->sale_id');
    }

    public function onModelCreated()
    {
        if ($this->type == TransactionType::PAYMENT) {  //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();
            $sale = Sale::find($this->sale_id);

            $led               = new Ledger();
            $led->type         = LedgerType::DR;
            $led->amount       = $sale->paid_credit_amount;
            $led->balance_id   = $this->source_balance_id;
            $led->balance      = !blank($ledger) ? $ledger->balance - $sale->paid_credit_amount : $sale->paid_credit_amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();

            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->destination_balance_id;
            $led->balance      = !blank($ledger) ? $ledger->balance + $this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
        } elseif($this->type == TransactionType::DEPOSIT) { //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->source_balance_id;
            $led->balance      = !blank($ledger) ? $ledger->balance + $this->amount : $this->amount;
            $led->creator_type = 'App\Models\User';
            $led->editor_type  = 'App\Models\User';
            $led->creator_id   = auth()->user()->id ?? 1;
            $led->editor_id    = auth()->user()->id ?? 1;
            $led->save();
        }
    }

    public function scopeUsermeta($query, $id)
    {
        return $query->where(['meta->user_id' => $id]);
    }
}
