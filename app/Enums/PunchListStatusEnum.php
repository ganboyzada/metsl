<?php

namespace App\Enums;

enum  PunchListStatusEnum: int
{
    case CLOSED = 0;

    case WORKREQUIRED = 1;

    case WORKNOTACCEPTED = 2;

    public function text(): string
    {
        return match($this) 
        {
            self::CLOSED => 'Closed',
            self::WORKREQUIRED => 'Work Required',
            self::WORKNOTACCEPTED => 'Work Not Required',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::CLOSED => '#374151',
            self::WORKREQUIRED => '#ff5a5a',
            self::WORKNOTACCEPTED => '#eab308'
        };
    }
}
