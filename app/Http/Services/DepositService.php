<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 5/3/20
 * Time: 11:25 AM
 */

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Models\Balance;
use App\Models\UserDeposit;

class DepositService
{

    public function depositAdjust( $userId,$userBalanceId, $depositAmount )
    {
        $balance             = Balance::where('id', $userBalanceId)->first();

        if ( !blank($balance) ) {
            if ( $depositAmount > 0 ) {
                $deposit = app(TransactionService::class)->deposit($balance->id, 0, $depositAmount);
                    if ( $deposit->status ) {
                        $status = true;
                        ResponseService::set([
                            'status' => true,
                            'amount' => $depositAmount
                        ]);
                    } else {
                        ResponseService::set([
                            'status'  => false,
                            'message' => $deposit->message
                        ]);
                    }

            } else {
                ResponseService::set([
                    'status' => true,
                    'amount' => $depositAmount
                ]);
            }

        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'The user not found',
            ]);
        }

        return ResponseService::response();
    }

}
