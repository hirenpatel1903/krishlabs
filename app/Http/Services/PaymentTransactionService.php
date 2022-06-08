<?php

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\User;

class PaymentTransactionService
{

    public function __construct()
    {
    }


    public function completed($saleID,$userID)
    {
        $sale    = Sale::find($saleID);
        $user    = User::find($userID);

        $meta = [
            'shop_id'        => $sale->shop_id,
            'sale_id'       => $sale->id,
            'invoice_id'     => 0,
            'user_id'        => $user->id,
            'payment_method' => 0,
        ];

        $this->addTransaction(TransactionType::PAYMENT, $user->balance_id, $sale->shop->user->balance_id, $sale->paid_amount, $meta);
    }


    private function addTransaction($type, $source, $destination, $amount, $meta)
    {
        $transaction                         = new Transaction;
        $transaction->type                   = $type;
        $transaction->source_balance_id      = $source;
        $transaction->destination_balance_id = $destination;
        $transaction->amount                 = $amount;
        $transaction->status                 = 1;
        $transaction->meta                   = $meta;
        $transaction->invoice_id             = $meta['invoice_id'];
        $transaction->sale_id               = $meta['sale_id'];
        $transaction->shop_id                = $meta['shop_id'];
        $transaction->user_id                = $meta['user_id'];
        $transaction->creator_type           = User::class;
        $transaction->editor_type            = User::class;
        $transaction->creator_id             = 1;
        $transaction->editor_id              = 1;
        $transaction->save();
    }
}
