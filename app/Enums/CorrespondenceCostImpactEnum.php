<?php

namespace App\Enums;

enum  CorrespondenceCostImpactEnum: string
{
    case YES = 'Yes';

    case NO = 'No';

    //case TED = 'TED';

    case NA = 'N/A';

    public function color(): string
    {
        return match($this) 
        {
            self::YES => 'bg-yellow-400',
            self::NO => 'bg-green-500',
            //self::TED => 'bg-green-500',
            self::NA => 'bg-red-500',

        };
    }
}
