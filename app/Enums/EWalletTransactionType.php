<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EWalletTransactionType extends Enum
{
    const Add =   1;
    const Minus =   2;
    const Refund =   3;
    const Affiliate =   4;

}
