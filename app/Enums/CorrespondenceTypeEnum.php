<?php

namespace App\Enums;

enum  CorrespondenceTypeEnum: string
{
    case AI = "AI";

    case RFI = 'RFI';

    case RFV = 'RFV';

    case RFC = 'RFC';


    public function color(): string
    {
        return match($this) 
        {
            self::AI => 'bg-blue-500',
            self::RFI => 'bg-yellow-400',
            self::RFV => 'bg-green-500',
            self::RFC => 'bg-red-500',
        };
    }

    public function dataFeather(): string
    {
        return match($this) 
        {
            self::AI => 'box',
            self::RFI => 'info',
            self::RFV => 'copy',
            self::RFC => 'refresh-cw',
        };
    }
}
