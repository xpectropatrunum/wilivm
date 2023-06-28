<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EServiceType extends Enum
{
    const NotPaid =   1;
    const Active =   2;
    const Expired =   3;
    const Cancelled =   4;
    const Deploying =   5;
    const Refund =   6;
    const Suspended =   7;



}
