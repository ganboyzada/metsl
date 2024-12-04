<?php

namespace App\Enums;

enum  CorrespondenceStatusEnum: string
{
    case DRAFT = 'Draft';

    case ISSUED = 'Issued';

    case OPEN = 'Open';

    case CLOSED = 'Closed';

    public function color(): string
    {
        return match($this) 
        {
            self::DRAFT => 'bg-gray-300 text-black',
            self::ISSUED => 'bg-yellow-500 text-black',
            self::OPEN => 'bg-blue-500 text-white',
            self::CLOSED => 'bg-green-500 text-white',

        };
    }
}
