<?php

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{

    protected function transaction($type = 0,  $sourceBalanceId = 0,  $destinationBalanceId = 0, $paymentMethod = 0, $amount = 0, $orderId = 0 )
    {
        $transaction = [
            'type'                   => $type,
            'source_balance_id'      => $sourceBalanceId,
            'destination_balance_id' => $destinationBalanceId,
            'amount'                 => $amount,
            'status'                 => 1,
            'creator_type'           => 'App\Models\User',
            'editor_type'            => 'App\Models\User',
            'creator_id'             => auth()->user()->id ?? 1,
            'editor_id'              => auth()->user()->id ?? 1,
            'meta'                   => [],
            'invoice_id'             => 0,
            'sale_id'               => 0,
            'shop_id'                => 0,
            'user_id'                => 0,
        ];

        $transaction = Transaction::create($transaction);
        if ( !blank($transaction) ) {
            ResponseService::set([
                'status'   => true,
                'sale_id' => $orderId,
                'amount'   => $amount
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'something wrong'
            ]);
        }
        return ResponseService::response();
    }


    public function deposit( $sourceBalanceId = 0, $destinationBalanceId = 0, $amount = 0) //done
    {
        return $this->transaction(TransactionType::DEPOSIT, $sourceBalanceId, $destinationBalanceId, PaymentMethod::CASH, $amount, 0);
    }
}

