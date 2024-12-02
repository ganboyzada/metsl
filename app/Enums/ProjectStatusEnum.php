<?php

namespace App\Enums;

enum  ProjectStatusEnum: int
{
    case ONGOING = 0;

    case DONE = 1;

    case CANCELLED = 2;


    public function text(): string
    {
        return match($this) 
        {
            self::ONGOING => 'Ongoing',
            self::DONE => 'Done',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::ONGOING => 'bg-yellow-400',
            self::DONE => 'bg-green-500',
            self::CANCELLED => 'bg-red-500',
        };
    }
}
