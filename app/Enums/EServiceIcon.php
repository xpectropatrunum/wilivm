<?php

namespace App\Enums;

use App\Models\ServerType;
use BenSampo\Enum\Enum;


final class EServiceIcon extends Enum
{
    const mikrotik =   1;
    const linux =   2;
    const rdp =   3;
    const windows =   4;

    public static function findIcon($type)
    {
        $type = ServerType::where("name", $type)->first();
        return self::getKey($type->id);
    }

}
