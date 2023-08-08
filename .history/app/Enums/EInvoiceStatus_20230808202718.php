<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EInvoiceStatus extends Enum
{
    const Unpaid =   0;
    const Paid =   1;
    const Refund =   2;
    const Fraud =   3;
  


}
