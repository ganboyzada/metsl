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
            self::OPEN => 'bg-yellow-500 text-white',
            self::CLOSED => 'bg-green-500 text-white',
            self::ACCEPTED => 'bg-blue-500 text-white',
            self::REJECTED => 'bg-red-500 text-white',

        };
    }


    public function text_color(): string
    {
        return match($this) 
        {
            self::OPEN => 'text-yellow-500 ',
            self::CLOSED => 'text-green-500',
            self::ACCEPTED => 'text-blue-500',
            self::REJECTED => 'text-red-500',

        };
    }
}
