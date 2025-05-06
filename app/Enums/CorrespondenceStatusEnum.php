<?php

namespace App\Enums;

enum  CorrespondenceStatusEnum: string
{

    case ISSUED = 'Issued';

    case OPEN = 'Open';

    case CLOSED = 'Closed';

    public function color(): string
    {
        return match($this) 
        {
            self::ISSUED => 'bg-yellow-500 text-black',
            self::OPEN => 'bg-blue-500 text-white',
            self::CLOSED => 'bg-green-500 text-white',

        };
    }
}
