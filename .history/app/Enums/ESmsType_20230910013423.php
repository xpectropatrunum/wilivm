<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class ESmsType extends Enum
{
    const Order =   1;
    const Ticket =   2;
    const Request =   3;
    const Draft =   4;
    const TicketReply =   5;
    const Suspension =   6;



}
