<?php

namespace App\Enums;

enum  CorrespondenceTypeEnum: string
{
    case RFI = 'RFI';

    case RFV = 'RFV';

    case RFC = 'RFC';


    public function color(): string
    {
        return match($this) 
        {
            self::RFI => 'bg-yellow-400',
            self::RFV => 'bg-green-500',
            self::RFC => 'bg-red-500',
        };
    }

    public function dataFeather(): string
    {
        return match($this) 
        {
            self::RFI => 'info',
            self::RFV => 'copy',
            self::RFC => 'refresh-cw',
        };
    }
}
