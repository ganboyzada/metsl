<?php

namespace App\Enums;

enum  CorrespondenceTypeEnum: string
{
    case INS = "INS";

    case RFI = 'RFI';

    case RFC = 'RFC';

    case NCR = 'NCR';


    public function color(): string
    {
        return match($this) 
        {
            self::INS => 'bg-blue-500',
            self::RFI => 'bg-yellow-400',
            
            self::RFC => 'bg-red-500',
            self::NCR => 'bg-green-500',
        };
    }

    public function dataFeather(): string
    {
        return match($this) 
        {
            self::INS => 'box',
            self::RFI => 'info',

            self::RFC => 'refresh-cw',
            self::NCR => 'info',
        };
    }
}
