<?php

namespace App\Enums;

enum  CorrespondenceStatusEnum: string
{


    case OPEN = 'Open';

    case CLOSED = 'Closed';

    case ACCEPTED = 'Accepted';

    case REJECTED = 'Rejected';

    public function color(): string
    {
        return match($this) 
        {
            self::OPEN => 'bg-green-500 text-white',
            self::CLOSED => 'bg-blue-500 text-white',
            self::ACCEPTED => 'bg-yellow-300 text-white',
            self::REJECTED => 'bg-red-500 text-white',

        };
    }
}
