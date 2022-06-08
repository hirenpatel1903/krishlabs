<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/16/20
 * Time: 5:21 PM
 */

namespace App\Enums;

interface TransactionType
{
    const ADDFUND  = 1;
    const PAYMENT  = 5;
    const REFUND   = 10;
    const TRANSFER = 15;
    const WITHDRAW = 20;
    const CASHBACK = 25;
    const DEPOSIT  = 30;
}
