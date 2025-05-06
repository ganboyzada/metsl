<?php

namespace App\Enums;

enum  CorrespondenceStatusEnum: string
{


    case OPEN = 'Open';

    case CLOSED = 'Closed';

    public function color(): string
    {
        return match($this) 
        {
            self::OPEN => 'bg-blue-500 text-white',
            self::CLOSED => 'bg-green-500 text-white',

        };
    }
}
