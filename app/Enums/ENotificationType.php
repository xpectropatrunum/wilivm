<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class ENotificationType extends Enum
{
    const Ticket =   0;
    const Requests =   1;
    const Deploying =   2;
    const Nonclassified =   3;

}
