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
    const LinuxNewServer =   7;
    const WindowsNewServer =   8;
    const SuspendService =   9;
    const Paid_order =   10;
    const New_order =   11;
    const Remind_week = 12;
    const Remind_2 = 14;
    const Overdue = 15;
    const TicketNewMessage = 16;
    const TicketCreated = 17;
    const UnsuspendService =   13;
    


}
