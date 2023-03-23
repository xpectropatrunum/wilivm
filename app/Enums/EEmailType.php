<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EEmailType extends Enum
{
    const Registration =   0;
    const Forget_Password =   1;
    const New_invoice =   2;
    const Paid_invoice =   3;
    const Deploying_server =   4;
    const Rating_ticket =   5;
    const Verify =   6;

}
